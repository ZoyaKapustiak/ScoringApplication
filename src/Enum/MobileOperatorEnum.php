<?php

namespace App\Enum;

enum MobileOperatorEnum: string implements ScoringInterface
{
    case Megafon = 'Megafon';
    case Mts = 'Mts';
    case Beeline = 'Beeline';
    case Other = 'Other';

    public static function defineOperator(int $code): MobileOperatorEnum
    {
        foreach (self::cases() as $case) {
            if (in_array($code, $case->getCodes())) {
                return $case;
            }
        }

        return self::Other;
    }

    private function getCodes(): array
    {
        return match ($this) {
            self::Megafon => [902, 904, 908, 920, 921, 922, 923, 924, 925, 926, 927, 928, 929, 930, 931, 932, 933, 934, 936, 937, 938, 939, 950, 951, 958, 999],
            self::Beeline => [900, 902, 903, 904, 905, 906, 908, 909, 930, 933, 950, 951, 953, 960, 961, 962, 963, 964, 965, 966, 967, 968, 969, 980, 983, 986, 994],
            self::Mts => [901, 902, 904, 908, 910, 911, 912, 913, 914, 915, 916, 917, 918, 919, 950, 958, 978, 980, 981, 982, 983, 984, 985, 986, 987, 988, 989],
            self::Other => [],
        };
    }
}
