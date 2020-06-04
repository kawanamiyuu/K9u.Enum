<?php

declare(strict_types=1);

namespace K9u\Enum;

use BadMethodCallException;
use InvalidArgumentException;

abstract class AbstractEnum implements EnumInterface
{
    /**
     * @var array<string, static[]>
     */
    private static $constants = [];

    /**
     * @var string
     */
    private $constantName;

    /**
     * @var mixed
     */
    private $constantValue;

    /**
     * @param string $name
     * @param mixed  $value
     */
    final private function __construct(string $name, $value)
    {
        $this->constantName = $name;
        $this->constantValue = $value;
    }

    /**
     * @return array<mixed> the definition of the enum constants
     */
    abstract protected static function constants(): array;

    /**
     * @return mixed the value of this enum constant
     */
    protected function getConstantValue()
    {
        return $this->constantValue;
    }

    /**
     * {@inheritDoc}
     */
    public function name(): string
    {
        return $this->constantName;
    }

    /**
     * {@inheritDoc}
     */
    public function __toString(): string
    {
        return $this->constantName;
    }

    /**
     * {@inheritDoc}
     */
    public function equals($var): bool
    {
        return $var instanceof static && $var->name() === $this->name();
    }

    /**
     * {@inheritDoc}
     */
    public static function __callStatic(string $name, array $arguments = [])
    {
        unset($arguments);

        foreach (self::getConstants() as $constant) {
            /** @var static $constant */
            if ($constant->name() === $name) {
                return $constant;
            }
        }

        throw new BadMethodCallException('unknown constant: ' . $name);
    }

    /**
     * {@inheritDoc}
     */
    public static function valueOf(string $name)
    {
        foreach (self::getConstants() as $constant) {
            /** @var static $constant */
            if ($constant->name() === $name) {
                return $constant;
            }
        }

        throw new InvalidArgumentException('unknown constant: ' . $name);
    }

    /**
     * {@inheritDoc}
     */
    public static function values(): array
    {
        return self::getConstants();
    }

    /**
     * @return static[]
     */
    private static function getConstants(): array
    {
        if (isset(self::$constants[static::class])) {
            return self::$constants[static::class];
        }

        self::$constants[static::class] = self::factory(static::constants(), function ($name, $value) {
            return new static($name, $value);
        });

        return self::$constants[static::class];
    }

    /**
     * @param array<mixed> $constants
     * @param callable     $factory
     *
     * @return static[]
     */
    private static function factory(array $constants, callable $factory): array
    {
        $results = [];

        // sequential
        if (array_values($constants) === $constants) {
            foreach ($constants as $name) {
                $results[] = $factory($name, $name);
            }

            return $results;
        }

        // associative
        foreach ($constants as $name => $value) {
            $results[] = $factory($name, $value);
        }

        return $results;
    }
}
