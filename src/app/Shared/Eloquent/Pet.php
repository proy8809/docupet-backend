<?php

namespace App\Shared\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $name
 * @property string $gender
 * @property string $date_of_birth
 * @property int $pet_type_id
 * @property ?int $pet_breed_id
 * @property string $breed_mix
 * @property bool $is_dangerous
 * @property PetType $petType
 * @property ?PetBreed $petBreed
 */
class Pet extends Model
{
    public $table = "pets";

    public $timestamps = false;

    /**
     * @var list<string>
     */
    protected $fillable = [
        "name",
        "gender",
        "date_of_birth",
        "pet_type_id",
        "pet_breed_id",
        "breed_mix",
        "is_dangerous",
    ];

    /**
     * @return BelongsTo<PetType,$this>
     */
    public function petType(): BelongsTo
    {
        return $this->belongsTo(PetType::class, "pet_type_id");
    }

    /**
     * @return BelongsTo<PetBreed,$this>
     */
    public function petBreed(): BelongsTo
    {
        return $this->belongsTo(PetBreed::class, "pet_breed_id");
    }
}