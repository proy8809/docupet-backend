<?php

namespace App\Registration;

use Illuminate\Support\ServiceProvider;
use App\Registration\Write\Domain\PetRepositoryInterface;
use App\Registration\Write\Infrastructure\Eloquent\PetRepository;

class RegistrationServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(PetRepositoryInterface::class, PetRepository::class);
    }
}
