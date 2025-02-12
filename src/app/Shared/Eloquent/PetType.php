<?php

namespace App\Shared\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $key
 * @property Collection<int,PetBreed> $petBreeds
 */
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