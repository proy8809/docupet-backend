<?php

namespace App\Registration\Presentation\Requests;

use Illuminate\Validation\Rule;
use App\Shared\Requests\ApplicationRequest;
use App\Registration\Write\Application\Commands\CreatePet\CreatePetCommand;

/**
 * @property string $name
 * @property string $gender
 * @property ?string $date_of_birth
 * @property ?int $estimated_age
 * @property string $type
 * @property ?string $breed
 * @property ?string $breed_mix
 */
class CreatePetRequest extends ApplicationRequest
{
    protected function getFailedValidationMessage(): string
    {
        return "api.exceptions.invalid_request";
    }

    /**
     * @return array<string,mixed>
     */
    public function rules(): array
    {
        return [
            "name" => ["required", "string", "max:32"],
            "gender" => ["required", "string", "in:m,f"],
            "date_of_birth" => ["sometimes", Rule::date()->before(today())],
            "estimated_age" => ["sometimes", "between:0,20"],
            "type" => ["required", "string", "in:cat,dog"],
            "breed" => ["sometimes", "string", "max:64"],
            "breed_mix" => ["nullable", "string", "max:128"],
        ];
    }

    public function toCommand(): CreatePetCommand
    {
        return new CreatePetCommand(
            petName: $this->name,
            petGender: $this->gender,
            petDateOfBirth: $this->date_of_birth,
            petEstimatedAge: $this->estimated_age,
            petType: $this->type,
            petBreed: $this->breed,
            petBreedMix: $this->breed_mix ?? ""
        );
    }
}
