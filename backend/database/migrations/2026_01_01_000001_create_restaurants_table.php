<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Identity
            $table->string('name');
            $table->string('slug', 100)->unique();

            // Media
            $table->string('logo_url', 500)->nullable();
            $table->string('cover_url', 500)->nullable();

            // Info
            $table->text('description')->nullable();
            $table->string('phone', 30)->nullable();
            $table->text('address')->nullable();
            $table->json('social_links')->nullable(); // {instagram, facebook, twitter, whatsapp}

            // Menu configuration
            $table->enum('menu_type', ['dynamic', 'pdf'])->default('dynamic');

            // Currency (per-restaurant)
            $table->string('currency_code', 10)->default('USD');
            $table->string('currency_symbol', 10)->default('$');

            // Status
            $table->boolean('is_active')->default(true);

            // Draft / Publish system
            $table->boolean('has_unpublished_changes')->default(false);
            $table->timestamp('last_published_at')->nullable();
            $table->enum('last_sync_status', ['pending', 'syncing', 'success', 'failed'])->nullable();
            $table->text('sync_error_message')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('restaurants');
    }
};
