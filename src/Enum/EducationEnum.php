<?php

namespace App\Enum;

enum EducationEnum: string
{
    use EnumValuesTrait;
    case Middle = 'Middle';
    case Special = 'Special';
    case Higher = 'Higher';

    public function label(): string
    {
        return match ($this) {
            self::Middle => 'Среднее образование',
            self::Special => 'Специальное образование',
            self::Higher => 'Высшее образование',
        };
    }

    public static function choices(): array
    {
        $choices = [];
        foreach (self::cases() as $case) {
            $choices[$case->label()] = $case;
        }

        return $choices;
    }
}
