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

    protected function getConstantName(): string
    {
        return $this->constantName;
    }

    protected function getConstantValue()
    {
        return $this->constantValue;
    }

    public static function __callStatic(string $name, array $arguments = []): self
    {
        return static::valueOf($name);
    }

    public function name(): string
    {
        return $this->constantName;
    }

    public function __toString(): string
    {
        return $this->constantName;
    }

    public static function valueOf(string $name): self
    {
        $value = static::constants()[$name];
        return new static($name, $value);
    }

    public static function values(): array
    {
        $constants = static::constants();

        return array_map(function ($name, $value) {
            return new static($name, $value);
        }, array_keys($constants), array_values($constants));
    }
}
