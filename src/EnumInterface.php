<?php

declare(strict_types=1);

namespace K9u\Enum;

interface EnumInterface
{
    /**
     * @return string the name of this enum constant
     */
    public function name(): string;

    /**
     * @return string the name of this enum constant
     */
    public function __toString(): string;

    /**
     * @param mixed $var variable
     *
     * @return bool return true if the specified variable is equal to this enum constant
     */
    public function equals($var): bool;

    /**
     * @param string       $name the name of the constant to return
     * @param array<mixed> $arguments (no use)
     *
     * @return static the enum constant of the specified name
     */
    public static function __callStatic(string $name, array $arguments = []);

    /**
     * @param string $name the name of the constant to return
     *
     * @return static the enum constant of the specified name
     */
    public static function valueOf(string $name);

    /**
     * @return static[] all the constants of an enum type
     */
    public static function constants(): array;
}
