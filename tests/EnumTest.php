<?php

declare(strict_types=1);

namespace K9u\Enum;

use PHPUnit\Framework\TestCase;

class EnumTest extends TestCase
{
    public function testEnum()
    {
        $fruit = Fruit::APPLE();
        {
            $this->assertInstanceOf(Fruit::class, $fruit);
            $this->assertSame('APPLE', $fruit->name());
            $this->assertSame('APPLE', (string) $fruit);
        }

        $color = $fruit->color();
        {
            $this->assertInstanceOf(Color::class, $color);
            $this->assertSame('RED', $color->name());
            $this->assertSame('RED', (string) $color);
            $this->assertSame([255, 0, 0], $color->rgb());
            $this->assertSame('ff0000', $color->hex());
        }

        $flavor = $fruit->flavor();
        {
            $this->assertInstanceOf(Flavor::class, $flavor);
            $this->assertSame('SWEET', $flavor->name());
            $this->assertSame('SWEET', (string) $flavor);
        }
    }

    public function testValueOf()
    {
        $fruit = Fruit::valueOf('APPLE');

        $this->assertInstanceOf(Fruit::class, $fruit);
        $this->assertSame('APPLE', $fruit->name());
    }

    public function testValues()
    {
        $fruits = Fruit::values();
        $this->assertCount(2, $fruits);

        /** @var Fruit $fruit0 */
        $fruit0 = $fruits[0];
        $this->assertInstanceOf(Fruit::class, $fruit0);
        $this->assertSame('APPLE', $fruit0->name());

        /** @var Fruit $fruit1 */
        $fruit1 = $fruits[1];
        $this->assertInstanceOf(Fruit::class, $fruit1);
        $this->assertSame('LEMON', $fruit1->name());
    }
}
