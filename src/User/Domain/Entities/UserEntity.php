<?php

declare(strict_types=1);

namespace User\Domain\Entities;

use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Shared\Domain\ValueObjects\Id;
use User\Domain\Exceptions\InvalidPasswordException;
use User\Domain\ValueObjects\Email;
use User\Domain\ValueObjects\FirstName;
use User\Domain\ValueObjects\Language;
use User\Domain\ValueObjects\LastName;
use User\Domain\ValueObjects\Password;
use User\Domain\ValueObjects\PasswordHash;

#[ORM\Entity]
#[ORM\Table(name: 'user')]
class UserEntity
{
    /**
     * A unique numeric identifier of the entity. Don't set this property
     * programmatically. It is automatically set by Doctrine ORM.
     */
    #[ORM\Embedded(class: Id::class, columnPrefix: false)]
    private Id $id;

    /** The email of the user entity */
    #[ORM\Embedded(class: Email::class, columnPrefix: false)]
    private Email $email;

    /** Password hash of the user */
    #[ORM\Embedded(class: PasswordHash::class, columnPrefix: false)]
    private PasswordHash $passwordHash;

    /** First name of the user entity */
    #[ORM\Embedded(class: FirstName::class, columnPrefix: false)]
    private FirstName $firstName;

    /** Last name of the user entity */
    #[ORM\Embedded(class: LastName::class, columnPrefix: false)]
    private LastName $lastName;

    /** Language of the user */
    #[ORM\Embedded(class: Language::class, columnPrefix: false)]
    private Language $language;

    /** Creation date and time of the entity */
    #[ORM\Column(type: 'datetime', name: 'created_at')]
    private DateTimeInterface $createdAt;

    /** The date and time when the entity was last modified. */
    #[ORM\Column(type: 'datetime', name: 'updated_at', nullable: true)]
    private ?DateTimeInterface $updatedAt = null;

    public function __construct(
        Email $email,
        Password $password,
        FirstName $firstName,
        LastName $lastName,
        Language $language
    ) {
        $this->id = new Id();
        $this->email = $email;
        $this->setPassword($password);
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->language = $language;
        $this->createdAt = new DateTime();
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    // public function getPasswordHash(): PasswordHash
    // {
    //     return $this->passwordHash;
    // }

    public function getFirstName(): FirstName
    {
        return $this->firstName;
    }

    public function setFirstName(FirstName $firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): LastName
    {
        return $this->lastName;
    }

    public function setLastName(LastName $lastName): self
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getLanguage(): Language
    {
        return $this->language;
    }

    public function setLanguage(Language $language): self
    {
        $this->language = $language;
        return $this;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    // Password is required to change the email
    public function updateEmail(Email $email, Password $password): self
    {
        $this->verifyUserPassword($password);

        $this->email = $email;
        return $this;
    }

    // Current password is required to change the password
    public function updatePassword(
        Password $currentPassword,
        Password $password
    ): self {
        $this->verifyUserPassword($currentPassword);

        if ($currentPassword->value === $password->value) {
            throw new InvalidPasswordException(
                $this,
                $password,
                InvalidPasswordException::TYPE_SAME_AS_OLD
            );
        }

        $this->setPassword($password);
        return $this;
    }

    private function verifyUserPassword(Password $password): bool
    {
        if (
            !password_verify(
                $password->value,
                $this->passwordHash->value
            )
        ) {
            throw new InvalidPasswordException(
                $this,
                $password,
                InvalidPasswordException::TYPE_INCORRECT
            );
        }

        return true;
    }

    private function setPassword(Password $password): void
    {
        $this->passwordHash = new PasswordHash(
            password_hash($password->value, PASSWORD_DEFAULT)
        );
    }

    public function preUpdate(): void
    {
        $this->updatedAt = new DateTime();
    }
}
