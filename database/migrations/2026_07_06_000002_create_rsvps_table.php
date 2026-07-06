<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rsvps', function (Blueprint $table): void {
            $table->id();

            // Owner of the invitation the response belongs to. The account has
            // a single invitation, so responses hang off the user directly.
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->string('guest_name');
            $table->unsignedSmallInteger('guest_count')->default(1);
            $table->string('menu_preference')->default('');
            $table->string('status', 32); // Katılıyor | Bekleniyor | Katılamıyor
            $table->text('message')->nullable();
            $table->text('photo_url')->nullable();
            $table->text('video_url')->nullable();

            $table->timestamps();

            $table->index(['user_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rsvps');
    }
};
