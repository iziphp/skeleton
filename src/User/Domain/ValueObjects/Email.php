<?php

declare(strict_types=1);

namespace User\Domain\ValueObjects;

use Shared\Domain\ValueObjects\Email as BaseEmail;
use Doctrine\ORM\Mapping as ORM;

/** @package User\Domain\ValueObjects */
#[ORM\Embeddable]
class Email extends BaseEmail
{
}
