<?php
declare(strict_types=1);

namespace K9u\Enum;

interface EnumInterface
{
    /**
     * @return string the name of this enum constant
     */
    function name(): string;

    /**
     * @return string the name of this enum constant
     */
    function __toString(): string;

    /**
     * @param string $name the name of the constant to return
     * @return self the enum constant of the specified  name
     */
    static function valueOf(string $name);

    /**
     * @return self[] all the constants of an enum type
     */
    static function values(): array;
}
