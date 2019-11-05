<?php

declare(strict_types=1);

namespace K9u\Enum;

/**
 * @method static Fruit APPLE()
 * @method static Fruit LEMON()
 */
final class Fruit extends AbstractEnum
{
    protected static function constants(): array
    {
        return [
            'APPLE' => [Color::RED(), Flavor::SWEET()],
            'LEMON' => [Color::YELLOW(), Flavor::SOUR()]
        ];
    }

    public function color(): Color
    {
        return $this->getConstantValue()[0];
    }

    public function flavor(): Flavor
    {
        return $this->getConstantValue()[1];
    }
}