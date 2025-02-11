<?php

namespace App\Shared\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pet extends Model
{
    public $table = "pets";

    public $timestamps = false;

    /**
     * @var list<string>
     */
    protected $fillable = [
        "pet_type_id",
        "pet_breed_id",
        "breed_mix",
        "name",
        "gender",
        "date_of_birth",
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