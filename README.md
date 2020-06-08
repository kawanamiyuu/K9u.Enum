# K9u.Enum

![badge](https://github.com/kawanamiyuu/K9u.Enum/workflows/CI/badge.svg)

**K9u.Enum** provides an Enumeration implementation for PHP.

## Usage

All examples are [here](examples).

### Simple Enum

```php
namespace K9u\Enum;

/**
 * @method static Flavor SWEET()
 * @method static Flavor SOUR()
 */
final class Flavor extends AbstractEnum
{
    /**
     * @return string[]
     */
    protected static function enumerate(): array
    {
        return [
            'SWEET',
            'SOUR'
        ];
    }
}
```

```php
$flavor = Flavor::SWEET();

var_dump(get_class($flavor));
/*
string(15) "K9u\Enum\Flavor"
*/

var_dump((string) $flavor);
/*
string(5) "SWEET"
*/
```

### Enum constant has values

```php
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
    protected static function enumerate(): array
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
```

```php
$color = Color::RED();

var_dump($color->rgb());
/*
array(3) {
  [0]=>
  int(255)
  [1]=>
  int(0)
  [2]=>
  int(0)
}
*/

var_dump($color->hex());
/*
string(6) "ff0000"
*/
```

### Enum constant can also have enum constant(s)

```php
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
```

```php
$fruit = Fruit::APPLE();

var_dump((string) $fruit->color());
/*
string(3) "RED"
*/

var_dump((string) $fruit->flavor());
/*
string(5) "SWEET"
*/

var_dump((string) $fruit->seasons()[0], (string) $fruit->seasons()[1]);
/*
string(6) "AUTUMN"
string(6) "WINTER"
*/
```
