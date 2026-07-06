<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invitations', function (Blueprint $table): void {
            $table->id();

            // One invitation per account: the frontend persistence boundary
            // loads/saves a single invitation object for the signed-in user.
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();

            // ——— Core content ———
            $table->string('title')->default('');
            $table->string('subtitle')->default('');
            $table->string('names')->default('');
            // Display date, free-format text chosen in the wizard (e.g. "12 Ağustos 2026").
            $table->string('event_date')->default('');
            $table->string('venue')->default('');
            $table->text('map_url')->nullable();
            $table->text('phone_background')->nullable();
            $table->string('image_theme')->default('');
            $table->string('category_id')->default('');
            $table->string('palette', 32)->default('midnight');

            // ——— Module visibility toggles ———
            $table->boolean('show_envelope')->default(true);
            $table->boolean('show_timer')->default(true);
            $table->boolean('show_timeline')->default(true);
            $table->boolean('show_gallery')->default(true);
            $table->boolean('show_gift')->default(true);
            $table->boolean('show_rsvp')->default(true);

            // ——— Gift / IBAN ———
            $table->string('bank_name')->default('');
            $table->string('account_holder')->default('');
            $table->string('iban', 34)->default('');
            $table->json('gift_options'); // number[] — pre-set gift amounts (₺)

            // ——— RSVP settings ———
            $table->string('rsvp_deadline', 10)->default(''); // yyyy-MM-dd
            $table->boolean('ask_menu_preference')->default(true);

            // ——— Content collections ———
            $table->json('timeline_events'); // TimelineEvent[] {id, time, title, description}
            $table->json('gallery_images');  // string[] — public media URLs

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invitations');
    }
};
