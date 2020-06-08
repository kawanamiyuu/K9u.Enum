<?php

declare(strict_types=1);

namespace K9u\Enum;

/**
 * @method static Season SPRING()
 * @method static Season SUMMER()
 * @method static Season AUTUMN()
 * @method static Season WINTER()
 */
final class Season extends AbstractEnum
{
    /**
     * @return array<string, int>
     */
    protected static function enumerate(): array
    {
        return [
            'SPRING' => 0,
            'SUMMER' => 1,
            'AUTUMN' => 2,
            'WINTER' => 3
        ];
    }

    public function value(): int
    {
        return $this->getConstantValue();
    }
}
