<?php

namespace App\Shared\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PetType extends Model
{
    public $table = "pet_types";

    public $timestamps = false;

    /**
     * @var list<string>
     */
    protected $fillable = ["key"];

    /**
     * @return HasMany<PetBreed,$this>
     */
    public function petBreeds(): HasMany
    {
        return $this->hasMany(PetBreed::class, "pet_type_id");
    }
}