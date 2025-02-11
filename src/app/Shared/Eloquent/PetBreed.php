<?php

namespace App\Shared\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PetBreed extends Model
{
    public $table = "pet_breeds";

    public $timestamps = false;

    /**
     * @var list<string>
     */
    protected $fillable = ["pet_type_id", "key"];

    /**
     * @return BelongsTo<PetType,$this>
     */
    public function petType(): BelongsTo
    {
        return $this->belongsTo(PetType::class, "pet_type_id");
    }
}