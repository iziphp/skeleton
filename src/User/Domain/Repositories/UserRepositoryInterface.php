<?php

declare(strict_types=1);

namespace User\Domain\Repositories;

use DateTimeInterface;
use Shared\Domain\Repositories\RepositoryInterface;
use Shared\Domain\ValueObjects\Id;
use Shared\Domain\ValueObjects\MaxResults;
use Shared\Domain\ValueObjects\SortDirection;
use User\Domain\Entities\UserEntity;
use User\Domain\ValueObjects\Email;
use User\Domain\ValueObjects\SortParameter;

/** @package User\Domain\Repositories */
interface UserRepositoryInterface extends RepositoryInterface
{
    /**
     * Add new user entity to the repository
     *
     * @param UserEntity $user
     * @return self
     */
    public function add(UserEntity $user): self;

    /**
     * Remove the user entity from the repository
     *
     * @param UserEntity $user
     * @return self
     */
    public function remove(UserEntity $user): self;

    /**
     * Find user entity by id
     *
     * @param Id $id
     * @return UserEntity|null
     */
    public function ofId(Id $id): ?UserEntity;

    /**
     * Find a single user entity by email
     *
     * @param Email $email
     * @return UserEntity|null
     */
    public function ofEmail(Email $email): ?UserEntity;

    /**
     * Filter user entities collection by the created after the date
     *
     * @param DateTimeInterface $date
     * @return self
     */
    public function createdAfter(DateTimeInterface $date): self;

    /**
     * Filter user entities collection by the created before the date
     *
     * @param DateTimeInterface $date
     * @return self
     */
    public function createdBefore(DateTimeInterface $date): self;

    /**
     * @param SortDirection $dir
     * @param null|SortParameter $param
     * @param null|UserEntity $cursor
     * @return UserRepositoryInterface
     */
    public function orderAndSliceAfter(
        SortDirection $dir,
        ?SortParameter $param = null,
        ?UserEntity $cursor = null
    ): self;

    /**
     * @param SortDirection $dir
     * @param null|SortParameter $param
     * @param null|UserEntity $cursor
     * @return UserRepositoryInterface
     */
    public function orderAndSliceBefore(
        SortDirection $dir,
        ?SortParameter $param = null,
        ?UserEntity $cursor = null
    ): self;
}
