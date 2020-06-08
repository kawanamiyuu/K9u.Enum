<?php

declare(strict_types=1);

namespace K9u\Enum;

/**
 * @method static Fruit APPLE()
 * @method static Fruit BANANA()
 */
final class Fruit extends AbstractEnum
{
    /**
     * @return array<string, array{Color, Flavor, Season[]}>
     */
    protected static function enumerate(): array
    {
        return [
            'APPLE' => [Color::RED(), Flavor::SWEET(), [Season::AUTUMN(), Season::WINTER()]],
            'BANANA' => [Color::YELLOW(), Flavor::SOUR(), [Season::SUMMER()]]
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

    /**
     * @return Season[]
     */
    public function seasons(): array
    {
        return $this->getConstantValue()[2];
    }
}
