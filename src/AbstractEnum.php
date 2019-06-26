<?php

declare(strict_types=1);

namespace K9u\Enum;

abstract class AbstractEnum implements EnumInterface
{
    private static $constants;

    private $constantName;
    private $constantValue;

    private function __construct(string $name, $value)
    {
        $this->constantName = $name;
        $this->constantValue = $value;
    }

    /**
     * @return array the definition of the enum constants
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
     * @return string the name of this enum constant
     */
    public function name(): string
    {
        return $this->constantName;
    }

    /**
     * @return string the name of this enum constant
     */
    public function __toString(): string
    {
        return $this->constantName;
    }

    /**
     * @param string $name the name of the constant to return
     * @param array  $arguments (no use)
     *
     * @return static the enum constant of the specified name
     */
    public static function __callStatic(string $name, array $arguments = []): self
    {
        unset($arguments);

        foreach (self::getConstants() as $constant) {
            /** @var self $constant */
            if ($constant->name() === $name) {
                return $constant;
            }
        }

        throw new \BadMethodCallException('unknown constant: ' . $name);
    }

    /**
     * @param string $name the name of the constant to return
     *
     * @return static the enum constant of the specified name
     */
    public static function valueOf(string $name): self
    {
        foreach (self::getConstants() as $constant) {
            /** @var self $constant */
            if ($constant->name() === $name) {
                return $constant;
            }
        }

        throw new \InvalidArgumentException('unknown constant: ' . $name);
    }

    /**
     * @return static[] all the constants of an enum type
     */
    public static function values(): array
    {
        return self::getConstants();
    }

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
