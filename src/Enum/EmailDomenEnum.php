<?php

namespace App\Enum;

enum EmailDomenEnum: string implements ScoringInterface
{
    case Gmail = 'Gmail';
    case Yandex = 'Yandex';
    case Mail = 'Mail';
    case Other = 'Other';
}
