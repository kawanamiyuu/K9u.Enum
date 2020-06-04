<?php

declare(strict_types=1);

namespace K9u\Enum;

/**
 * @method static Color RED()
 * @method static Color YELLOW()
 */
final class Color extends AbstractEnum
{
    /**
     * @return array<string, array{array{int, int, int}, string}>
     */
    protected static function constants(): array
    {
        return [
            'RED' => [[255, 0, 0], 'ff0000'],
            'YELLOW' => [[255, 255, 0], 'ffff00']
        ];
    }

    /**
     * @return array{int, int, int}
     */
    public function rgb(): array
    {
        return $this->getConstantValue()[0];
    }

    public function hex(): string
    {
        return $this->getConstantValue()[1];
    }
}
