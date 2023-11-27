<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('therapists', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);

            $table->string('name'); 
            $table->json('treatment_fields');

            $table->string('education');
            $table->string('phone_number');
            $table->string('profile_picture')->nullable();

            $table->text('description');

            $table->boolean('therapist_enabled')->default(false);

            $table->decimal('price', 8, 3); 
            $table->integer('work_experience');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('therapists');
    }
};
