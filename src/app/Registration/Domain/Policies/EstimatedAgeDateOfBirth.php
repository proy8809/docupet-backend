<?php

namespace App\Registration\Domain\Policies;

use Carbon\Carbon;

class EstimatedAgeDateOfBirth
{
    public function calculate(int $estimatedAge): Carbon
    {
        return Carbon::now()->subYears($estimatedAge);
    }
}