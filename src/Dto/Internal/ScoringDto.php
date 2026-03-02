<?php

namespace App\Dto\Internal;

readonly class ScoringDto
{
    public function __construct(
        public array $scores,
        public int $totalScore,
    ) {
    }
}
