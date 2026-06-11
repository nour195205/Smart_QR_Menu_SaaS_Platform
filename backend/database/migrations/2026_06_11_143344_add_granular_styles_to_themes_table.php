<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('themes', function (Blueprint $table) {
            $table->string('category_title_color', 20)->default('#1A1A2E')->after('text_color');
            $table->string('item_title_color', 20)->default('#1A1A2E')->after('category_title_color');
            $table->string('item_description_color', 20)->default('#666666')->after('item_title_color');
            $table->string('item_price_color', 20)->default('#FF6B35')->after('item_description_color');
            $table->string('card_background_color', 20)->default('#FFFFFF')->after('item_price_color');
            $table->enum('text_alignment', ['left', 'center', 'right'])->default('left')->after('card_style');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('themes', function (Blueprint $table) {
            $table->dropColumn([
                'category_title_color',
                'item_title_color',
                'item_description_color',
                'item_price_color',
                'card_background_color',
                'text_alignment',
            ]);
        });
    }
};
