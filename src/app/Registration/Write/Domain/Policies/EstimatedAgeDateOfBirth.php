<?php

namespace App\Registration\Write\Domain\Policies;

use Carbon\Carbon;

class EstimatedAgeDateOfBirth
{
    public function calculate(int $estimatedAge): Carbon
    {
        return Carbon::now()->subYears($estimatedAge);
    }
}