# K9u.Enum

**K9u.Enum** provides an Enumeration implementation for PHP. It has the interface like Java's.

## Usage

All examples are [here](tests/Fake).

### Enum constant has single value

```php
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
            'SWEET' => 'SWEET',
            'SOUR' => 'SOUR'
        ];
    }
}
```

```php
$flavor = Flavor::SWEET(); 

var_dump($flavor->name());
/*
string(5) "SWEET"
*/
```

```php
$flavor = Flavor::valueOf('SOUR');

var_dump($flavor->name());
/*
string(4) "SOUR"
*/
```

```php
$flavors = Flavor::values();

var_dump($flavors[0]->name());
/*
string(5) "SWEET"
*/

var_dump($flavors[1]->name());
/*
string(4) "SOUR"
*/
```

### Enum constant has multiple values

```php
namespace K9u\Enum;

/**
 * @method static Color RED()
 * @method static Color YELLOW()
 */
final class Color extends AbstractEnum
{
    protected static function constants(): array
    {
        return [
            'RED' => [[255, 0, 0], 'ff0000'],
            'YELLOW' => [[255, 255, 0], 'ffff00']
        ];
    }

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

### Enum constant can also have enum constan(s)

```php
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
```
