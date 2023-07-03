<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Repositories\DoctrineOrm;

use ArrayIterator;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use InvalidArgumentException;
use Iterator;
use RuntimeException;
use Shared\Domain\Repositories\RepositoryInterface;
use Shared\Domain\ValueObjects\Id;
use Shared\Domain\ValueObjects\MaxResults;
use Shared\Domain\ValueObjects\SortDirection;
use Shared\Domain\ValueObjects\SortKeyValue;

/**
 * This abstract DoctrineORM repository is meant to every DDoctrineORM
 * repository implementation. This abstract repository implements the
 * RepositoryInterface contract in an immutable way.
 *
 * @package Shared\Infrastructure\Repositories\DoctrineOrm
 */
abstract class AbstractRepository implements RepositoryInterface
{
    private bool $reverseSort = false;

    /**
     * Visibility set to private for not exposing the query builder to child
     * classes. This guarantees that the original reference is not modified
     * in child classes.
     */
    private QueryBuilder $qb;

    /**
     * @param EntityManagerInterface $em
     * @param string $entityClass
     * @param string $alias
     * @return void
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function __construct(
        /** Doctrine's Entity Manager. Child classes may use it. */
        protected EntityManagerInterface $em,
        private string $entityClass,
        private string $alias
    ) {
        $this->qb = $this->em->createQueryBuilder()
            ->select($alias)
            ->from($entityClass, $alias);
    }

    /**
     * @inheritDoc
     */
    public function getIterator(): Iterator
    {
        $iterator = new Paginator($this->qb->getQuery());

        if ($this->reverseSort) {
            $iterator = new ArrayIterator(
                array_reverse(iterator_to_array($iterator))
            );
        }

        yield from $iterator;
    }

    /**
     * @inheritDoc
     */
    public function slice(int $start, int $size = 20): RepositoryInterface
    {
        return $this->filter(
            static function (QueryBuilder $qb) use ($start, $size) {
                $qb->setFirstResult($start)->setMaxResults($size);
            }
        );
    }

    /**
     * @inheritDoc
     */
    public function count(): int
    {
        $paginator = new Paginator($this->qb->getQuery());
        return $paginator->count();
    }

    /**
     * @inheritDoc
     */
    public function flush(): void
    {
        $this->em->flush();
    }

    /** @inheritDoc */
    public function setMaxResults(MaxResults $maxResults): static
    {
        return $this->filter(
            static function (QueryBuilder $qb) use ($maxResults) {
                $qb->setMaxResults($maxResults->value);
            }
        );
    }

    /**
     * Filters the repository using the query builder
     *
     * Clones this repository and returns the new instance with the modified
     * query builder, so the original reference is preserved.
     *
     * @param callable $filter
     * @return static
     */
    protected function filter(callable $filter): self
    {
        $cloned = clone $this;
        $filter($cloned->qb);

        return $cloned;
    }

    /**
     * Returns a cloned instance of the query builder.
     * Use this to perform single result queries.
     *
     * @return QueryBuilder
     */
    protected function query(): QueryBuilder
    {
        return clone $this->qb;
    }

    /**
     * Allow cloning only from this scope.
     * Also always clone the query builder.
     *
     * @return void
     */
    protected function __clone()
    {
        $this->qb = clone $this->qb;
    }

    /**
     * ort repo entities and slice after provided cursor
     *
     * @param SortDirection $dir
     * @param null|SortKeyValue $sortKeyValue
     * @param null|Id $cursorId
     * @return static
     */
    protected function doSortAndStartAfter(
        SortDirection $dir,
        ?SortKeyValue $sortKeyValue = null,
        ?Id $cursorId = null
    ): static {
        $repoAlias = $this->alias;

        return $this->filter(
            static function (QueryBuilder $qb) use (
                $repoAlias,
                $dir,
                $sortKeyValue,
                $cursorId
            ) {
                if ($sortKeyValue) {
                    $qb->orderBy($repoAlias . '.' . $sortKeyValue->key, $dir->value);
                }

                $qb->addOrderBy($repoAlias . '.id.value', $dir->value);

                if ($cursorId) {
                    $op = $dir === SortDirection::ASC ? '>' : '<';

                    if ($sortKeyValue) {
                        $qb->andWhere(
                            $qb->expr()->orX(
                                $op == '>'
                                    ? $qb->expr()->gt($repoAlias . '.' . $sortKeyValue->key, ':sortParam')
                                    : $qb->expr()->lt($repoAlias . '.' . $sortKeyValue->key, ':sortParam'),
                                $qb->expr()->andX(
                                    $qb->expr()->eq($repoAlias . '.' . $sortKeyValue->key, ':sortParam'),
                                    $op == '>'
                                        ? $qb->expr()->gt($repoAlias . '.id.value', ':id')
                                        : $qb->expr()->lt($repoAlias . '.id.value', ':id')
                                )
                            )
                        )->setParameter('sortParam', $sortKeyValue->value);
                    } else {
                        $qb->andWhere(
                            $op == '>'
                                ? $qb->expr()->gt($repoAlias . '.id.value', ':id')
                                : $qb->expr()->lt($repoAlias . '.id.value', ':id')
                        );
                    }

                    $qb->setParameter('id', $cursorId->value->getBytes());
                }
            }
        );
    }

    /**
     * Sort repo entities and slice before provided cursor
     *
     * @param SortDirection $dir
     * @param null|SortKeyValue $sortKeyValue
     * @param null|Id $cursorId
     * @return static
     */
    protected function doSortAndEndBefore(
        SortDirection $dir,
        ?SortKeyValue $sortKeyValue = null,
        ?Id $cursorId = null
    ): static {
        $this->reverseSort = true;
        $repoAlias = $this->alias;

        return $this->filter(
            static function (QueryBuilder $qb) use (
                $repoAlias,
                $dir,
                $sortKeyValue,
                $cursorId
            ) {
                if ($cursorId) {
                    if ($sortKeyValue) {
                        $qb->orderBy($repoAlias . '.' . $sortKeyValue->key, $dir->getOpposite()->value);
                    }

                    $qb->addOrderBy($repoAlias . '.id.value', $dir->getOpposite()->value);

                    $op = $dir->getOpposite() === SortDirection::ASC ? '>' : '<';

                    if ($sortKeyValue) {
                        $qb->andWhere(
                            $qb->expr()->orX(
                                $op == '>'
                                    ? $qb->expr()->gt($repoAlias . '.' . $sortKeyValue->key, ':sortParam')
                                    : $qb->expr()->lt($repoAlias . '.' . $sortKeyValue->key, ':sortParam'),
                                $qb->expr()->andX(
                                    $qb->expr()->eq($repoAlias . '.' . $sortKeyValue->key, ':sortParam'),
                                    $op == '>'
                                        ? $qb->expr()->gt($repoAlias . '.id.value', ':id')
                                        : $qb->expr()->lt($repoAlias . '.id.value', ':id')
                                )
                            )
                        )->setParameter('sortParam', $sortKeyValue->value);
                    } else {
                        $qb->andWhere(
                            $op == '>'
                                ? $qb->expr()->gt($repoAlias . '.id.value', ':id')
                                : $qb->expr()->lt($repoAlias . '.id.value', ':id')
                        );
                    }

                    $qb->setParameter('id', $cursorId->value->getBytes());
                } else {
                    if ($sortKeyValue) {
                        $qb->orderBy($repoAlias . '.' . $sortKeyValue->key, $dir->value);
                    }

                    $qb->addOrderBy($repoAlias . '.id.value', $dir->value);
                }
            }
        );
    }
}
