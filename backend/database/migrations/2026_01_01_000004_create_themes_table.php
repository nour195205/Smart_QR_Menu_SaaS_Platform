<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('themes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->unique()->constrained()->cascadeOnDelete();

            $table->string('primary_color', 20)->default('#FF6B35');
            $table->string('secondary_color', 20)->default('#2E294E');
            $table->string('background_color', 20)->default('#FFFFFF');
            $table->string('text_color', 20)->default('#1A1A2E');
            $table->string('font_family', 100)->default('Outfit');
            $table->enum('card_style', ['rounded', 'flat', 'shadow'])->default('rounded');
            $table->boolean('dark_mode')->default(false);
            $table->enum('layout_style', ['grid', 'list'])->default('grid');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('themes');
    }
};
