<?php

declare(strict_types=1);

namespace K9u\Enum;

use BadMethodCallException;

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
    abstract protected static function enumerate(): array;

    /**
     * @return mixed the value of this enum constant
     */
    final protected function getConstantValue()
    {
        return $this->constantValue;
    }

    /**
     * {@inheritDoc}
     */
    final public function name(): string
    {
        return $this->constantName;
    }

    /**
     * {@inheritDoc}
     */
    final public function __toString(): string
    {
        return $this->constantName;
    }

    /**
     * {@inheritDoc}
     */
    final public function equals($var): bool
    {
        return $var instanceof static && $var->name() === $this->name();
    }

    /**
     * {@inheritDoc}
     */
    final public static function __callStatic(string $name, array $arguments = [])
    {
        unset($arguments);

        foreach (self::constants() as $constant) {
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
    final public static function constants(): array
    {
        if (isset(self::$constants[static::class])) {
            return self::$constants[static::class];
        }

        self::$constants[static::class] = self::factory(static::enumerate(), function ($name, $value) {
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
