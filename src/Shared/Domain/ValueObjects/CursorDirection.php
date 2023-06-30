<?php

namespace Shared\Domain\ValueObjects;

enum CursorDirection: string
{
    case STARTING_AFTER = 'starting_after';
    case ENDING_BEFORE = 'ending_before';
}
