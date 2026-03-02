<?php

namespace App\Enum;

trait EnumValuesTrait
{
    /**
     * Возвращает список значений енама.
     *
     * @return int[]|string[]
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function choices(): array
    {
        $cases = [];
        foreach (self::cases() as $case) {
            $cases[] = $case->value;
        }

        return $cases;
    }
}
