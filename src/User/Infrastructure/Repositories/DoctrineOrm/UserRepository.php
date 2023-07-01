<?php

declare(strict_types=1);

namespace User\Infrastructure\Repositories\DoctrineOrm;

use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\QueryBuilder;
use DomainException;
use InvalidArgumentException;
use RuntimeException;
use Shared\Domain\ValueObjects\Id;
use Shared\Domain\ValueObjects\SortDirection;
use Shared\Domain\ValueObjects\SliceLimit;
use Shared\Domain\ValueObjects\SortKeyValue;
use Shared\Infrastructure\Repositories\DoctrineOrm\AbstractRepository;
use User\Domain\Entities\UserEntity;
use User\Domain\Repositories\UserRepositoryInterface;
use User\Domain\ValueObjects\Email;
use User\Domain\ValueObjects\SortParameter;

/** @package User\Infrastructure\Repositories\DoctrineOrm */
class UserRepository extends AbstractRepository implements
    UserRepositoryInterface
{
    protected const ENTITY_CLASS = UserEntity::class;
    protected const ALIAS = 'user';

    /**
     * @param EntityManagerInterface $em
     * @return void
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, self::ENTITY_CLASS, self::ALIAS);
    }

    /**
     * @inheritDoc
     */
    public function add(UserEntity $user): self
    {
        $this->em->persist($user);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function remove(UserEntity $user): self
    {
        $this->em->remove($user);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function ofId(Id $id): ?UserEntity
    {
        $object = $this->em->find(self::ENTITY_CLASS, $id);
        return $object instanceof UserEntity ? $object : null;
    }

    /**
     * @inheritDoc
     */
    public function ofEmail(Email $email): ?UserEntity
    {
        try {
            $object = $this->query()
                ->where(self::ALIAS . '.email.value = :email')
                ->setParameter(':email', $email->value)
                ->getQuery()
                ->getSingleResult();
        } catch (NoResultException $e) {
            return null;
        } catch (NonUniqueResultException $e) {
            throw new DomainException('More than one result found');
        }

        return $object;
    }

    /**
     * @inheritDoc
     */
    public function createdAfter(
        DateTimeInterface $date
    ): UserRepositoryInterface {
        return $this->filter(static function (QueryBuilder $qb) use ($date) {
            $qb->andWhere('user.createdAt > :after')
                ->setParameter(':after', $date, Types::DATETIME_MUTABLE);
        });
    }

    /**
     * @inheritDoc
     */
    public function createdBefore(
        DateTimeInterface $date
    ): UserRepositoryInterface {
        return $this->filter(static function (QueryBuilder $qb) use ($date) {
            $qb->andWhere('user.createdAt < :before')
                ->setParameter(':before', $date, Types::DATETIME_MUTABLE);
        });
    }

    public function orderAndSliceAfter(
        SortDirection $dir,
        SliceLimit $limit,
        ?SortParameter $param = null,
        ?UserEntity $cursor = null
    ): UserRepositoryInterface {
        return $this->doOrderAndSliceAfter(
            self::ALIAS,
            $dir,
            $limit,
            $param ? $this->getSortKeyValue($param, $cursor) : null,
            $cursor ? $cursor->getId() : null
        );
    }

    public function orderAndSliceBefore(
        SortDirection $dir,
        SliceLimit $limit,
        ?SortParameter $param = null,
        ?UserEntity $cursor = null
    ): UserRepositoryInterface {
        return $this->doOrderAndSliceBefore(
            self::ALIAS,
            $dir,
            $limit,
            $param ? $this->getSortKeyValue($param, $cursor) : null,
            $cursor ? $cursor->getId() : null
        );
    }

    private function getSortKeyValue(
        SortParameter $param,
        ?UserEntity $cursor
    ): SortKeyValue {
        return match ($param) {
            SortParameter::ID => new SortKeyValue(
                'id.value',
                $cursor?->getId()->value->getBytes(),
            ),
            SortParameter::FIRST_NAME => new SortKeyValue(
                'firstName.value',
                $cursor?->getFirstName()->value,
            ),
            SortParameter::LAST_NAME => new SortKeyValue(
                'lastName.value',
                $cursor?->getLastName()->value
            ),
            SortParameter::CREATED_AT => new SortKeyValue(
                'createdAt',
                $cursor?->getCreatedAt()
            ),
            SortParameter::UPDATED_AT => new SortKeyValue(
                'updatedAt',
                $cursor?->getUpdatedAt()
            )
        };
    }
}
