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
            $this->assertSame('APPLE', (string) $fruit);
        }

        $color = $fruit->color();
        {
            $this->assertInstanceOf(Color::class, $color);
            $this->assertSame('RED', (string) $color);
            $this->assertSame([255, 0, 0], $color->rgb());
            $this->assertSame('ff0000', $color->hex());
        }

        $flavor = $fruit->flavor();
        {
            $this->assertInstanceOf(Flavor::class, $flavor);
            $this->assertSame('SWEET', (string) $flavor);
        }

        $seasons = $fruit->seasons();
        {
            $this->assertCount(2, $seasons);

            $this->assertInstanceOf(Season::class, $seasons[0]);
            $this->assertSame('AUTUMN', (string) $seasons[0]);
            $this->assertSame(2, $seasons[0]->value());

            $this->assertInstanceOf(Season::class, $seasons[1]);
            $this->assertSame('WINTER', (string) $seasons[1]);
            $this->assertSame(3, $seasons[1]->value());
        }
    }

    public function testConstants()
    {
        $fruits = Fruit::constants();
        $this->assertCount(2, $fruits);

        $this->assertInstanceOf(Fruit::class, $fruits[0]);
        $this->assertSame('APPLE', (string) $fruits[0]);

        $this->assertInstanceOf(Fruit::class, $fruits[1]);
        $this->assertSame('BANANA', (string) $fruits[1]);
    }

    public function testEquals()
    {
        $fruit = Fruit::APPLE();

        $this->assertTrue($fruit->equals(Fruit::APPLE()));

        $this->assertFalse($fruit->equals(null));
        $this->assertFalse($fruit->equals('APPLE'));
        $this->assertFalse($fruit->equals(FakeFruit::APPLE()));
    }

    public function testCompare()
    {
        $this->assertSame(Fruit::APPLE(), Fruit::APPLE());
        $this->assertSame(Fruit::constants(), Fruit::constants());

        $this->assertNotSame(Fruit::APPLE(), Fruit::BANANA());
        $this->assertNotSame(Fruit::APPLE(), FakeFruit::APPLE());
    }

    public function testUnknownMethodCall()
    {
        $this->expectException(\BadMethodCallException::class);

        Fruit::UNKNOWN();
    }
}
