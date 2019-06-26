<?php

declare(strict_types=1);

namespace K9u\Enum;

/**
 * @method static Flavor SWEET()
 * @method static Flavor SOUR()
 */
final class Flavor extends AbstractEnum
{
    protected static function constants(): array
    {
        return [
            'SWEET', 'SOUR'
        ];
    }
}
