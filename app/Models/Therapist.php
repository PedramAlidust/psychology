<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Therapist extends Model
{
    use HasFactory;

    protected $fillable = ['0', 'user_id', 'name', 'treatment_fields', 'education', 'phone_number', 'profile_picture', 'description', 'therapist_enabled', 'price', 'work_experience'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function resolveRouteBinding($value, $field = null)
    {
        // Customize the model retrieval based on user_id instead of id
        $therapist = $this->where('user_id', $value)->first();

        if ($therapist === null) {
            abort(response()->json(['error' => 'درمانگر پیدا نشد'], 404));
        }

        return $therapist;
    }
}
