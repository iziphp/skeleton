<?php

namespace User\Domain\ValueObjects;

enum SortParameter: string
{
    case ID = 'id';
    case FIRST_NAME = 'first_name';
    case LAST_NAME = 'last_name';
    case CREATED_AT = 'created_at';
    case UPDATED_AT = 'updated_at';
}
