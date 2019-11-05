<?php

declare(strict_types=1);

namespace K9u\Enum;

/**
 * @method static FakeFruit APPLE()
 * @method static FakeFruit LEMON()
 */
final class FakeFruit extends AbstractEnum
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
