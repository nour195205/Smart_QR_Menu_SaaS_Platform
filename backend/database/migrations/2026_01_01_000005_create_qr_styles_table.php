<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('qr_styles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->unique()->constrained()->cascadeOnDelete();

            // Dot / corner styling
            $table->string('dot_style', 50)->default('rounded');
            $table->string('corner_square_style', 50)->default('extra-rounded');
            $table->string('corner_dot_style', 50)->default('dot');

            // Colors
            $table->string('dot_color', 20)->default('#000000');
            $table->string('background_color', 20)->default('#FFFFFF');

            // Gradient (optional)
            $table->boolean('gradient_enabled')->default(false);
            $table->string('gradient_color_1', 20)->nullable();
            $table->string('gradient_color_2', 20)->nullable();
            $table->enum('gradient_type', ['linear', 'radial'])->nullable();

            // Branding
            $table->string('logo_url', 500)->nullable();
            $table->string('frame_style', 50)->nullable();
            $table->string('top_text', 255)->nullable();
            $table->string('bottom_text', 255)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('qr_styles');
    }
};
