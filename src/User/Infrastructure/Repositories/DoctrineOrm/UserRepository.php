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
use Iterator;
use RuntimeException;
use Shared\Domain\ValueObjects\Id;
use Shared\Domain\ValueObjects\SortDirection;
use Shared\Infrastructure\Repositories\DoctrineOrm\AbstractRepository;
use User\Domain\Entities\UserEntity;
use User\Domain\Repositories\UserRepositoryInterface;
use User\Domain\ValueObjects\Email;
use User\Domain\ValueObjects\SortParameter;

/** @package User\Infrastructure\Repositories\DoctrineOrm */
class UserRepository extends AbstractRepository implements
    UserRepositoryInterface
{
    private const ENTITY_CLASS = UserEntity::class;
    private const ALIAS = 'user';
    private ?SortParameter $sortParameter = null;

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

    /** @inheritDoc */
    public function sort(
        SortDirection $dir,
        ?SortParameter $sortParameter = null
    ): static {
        $cloned = $this->doSort($dir, $this->getSortKey($sortParameter));
        $cloned->sortParameter = $sortParameter;

        return $cloned;
    }

    /** @inheritDoc */
    public function startingAfter(UserEntity $cursor): Iterator
    {
        return $this->doStartingAfter(
            $cursor->getId(),
            $this->getCompareValue($cursor)
        );
    }

    /** @inheritDoc */
    public function endingBefore(UserEntity $cursor): Iterator
    {
        return $this->doEndingBefore(
            $cursor->getId(),
            $this->getCompareValue($cursor)
        );
    }

    /**
     * @param SortParameter $param 
     * @return null|string 
     */
    private function getSortKey(
        ?SortParameter $param
    ): ?string {
        return match ($param) {
            SortParameter::ID => 'id.value',
            SortParameter::FIRST_NAME => 'firstName.value',
            SortParameter::LAST_NAME => 'lastName.value',
            SortParameter::CREATED_AT => 'createdAt',
            SortParameter::UPDATED_AT => 'updatedAt',
            default => null
        };
    }

    /**
     * @param UserEntity $cursor 
     * @return null|string 
     */
    private function getCompareValue(UserEntity $cursor): ?string
    {
        return match ($this->sortParameter) {
            SortParameter::ID => $cursor->getId()->value->getBytes(),
            SortParameter::FIRST_NAME => $cursor->getFirstName()->value,
            SortParameter::LAST_NAME => $cursor->getLastName()->value,
            SortParameter::CREATED_AT => $cursor->getCreatedAt(),
            SortParameter::UPDATED_AT => $cursor->getUpdatedAt(),
            default => null
        };
    }
}
