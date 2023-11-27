<?php

use App\Models\Therapist;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

use function Laravel\Prompts\table;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(User::class);
            $table->string('name');
            $table->text('description1');
            $table->text('description2'); 
            $table->text('description3'); 
            $table->text('description4'); 
            $table->text('description5'); 
            $table->text('description6'); 
            $table->text('content_image1');
            $table->text('content_image2');
            $table->text('content_image3');
            $table->text('content_image4');
            $table->text('content_image5');
            $table->text('content_image6');
            $table->text('source');
            $table->text('featured_image');
            $table->string('categorie'); 
            $table->boolean('article_enabled')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
