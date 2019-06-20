<?php

declare(strict_types=1);

namespace K9u\Enum;

abstract class AbstractEnum implements EnumInterface
{
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
     * @return string the name of this enum constant
     */
    protected function getConstantName(): string
    {
        return $this->constantName;
    }

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

        return static::valueOf($name);
    }

    /**
     * @param string $name the name of the constant to return
     *
     * @return static the enum constant of the specified name
     */
    public static function valueOf(string $name): self
    {
        $value = static::constants()[$name];
        return new static($name, $value);
    }

    /**
     * @return static[] all the constants of an enum type
     */
    public static function values(): array
    {
        $constants = static::constants();

        return array_map(function ($name, $value) {
            return new static($name, $value);
        }, array_keys($constants), array_values($constants));
    }
}
