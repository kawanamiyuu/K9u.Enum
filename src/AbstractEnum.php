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
     * @return string[]|array<string, mixed> the definition of the enum constants
     */
    abstract protected static function enumerate(): array;

    /**
     * @return string the name of this enum constant
     */
    final protected function getConstantName(): string
    {
        return $this->constantName;
    }

    /**
     * @return mixed the value of this enum constant
     */
    final protected function getConstantValue()
    {
        return $this->constantValue;
    }

    /**
     * @return static[] all the constants of an enum type
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
     * @param mixed $var variable
     *
     * @return bool return true if the specified variable is equal to this enum constant
     */
    final public function equals($var): bool
    {
        return $var instanceof static && $var->getConstantName() === $this->getConstantName();
    }

    /**
     * @param string       $name the name of the constant to return
     * @param array<mixed> $arguments (no use)
     *
     * @return static the enum constant of the specified name
     */
    final public static function __callStatic(string $name, array $arguments = []): static
    {
        unset($arguments);

        foreach (self::constants() as $constant) {
            /** @var static $constant */
            if ($constant->getConstantName() === $name) {
                return $constant;
            }
        }

        throw new BadMethodCallException('unknown constant: ' . $name);
    }

    /**
     * @return string the name of this enum constant
     */
    final public function __toString(): string
    {
        return $this->getConstantName();
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
