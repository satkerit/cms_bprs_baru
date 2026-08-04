<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('auctions', function (Blueprint $table) {
            $table->id();

            // Informasi Dasar
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('auction_number')->unique();
            $table->string('object_number')->nullable();
            $table->text('description')->nullable();

            // Informasi Aset
            $table->string('asset_type'); // tanah, rumah, ruko, apartemen, gedung, pabrik, kendaraan, mesin, lainnya
            $table->string('asset_category')->nullable();
            $table->text('asset_description')->nullable();
            $table->string('building_condition')->nullable();
            $table->unsignedTinyInteger('floors')->nullable();
            $table->unsignedTinyInteger('bedrooms')->nullable();
            $table->unsignedTinyInteger('bathrooms')->nullable();
            $table->unsignedTinyInteger('parking_spaces')->nullable();
            $table->unsignedSmallInteger('year_built')->nullable();

            // Lokasi
            $table->text('address')->nullable();
            $table->string('village')->nullable();
            $table->string('district')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('postal_code', 10)->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            // Sertifikat
            $table->string('certificate_type')->nullable(); // SHM, SHGB, BPKB, dll
            $table->string('certificate_number')->nullable();
            $table->date('certificate_date')->nullable();
            $table->string('certificate_issued_by')->nullable();

            // Ukuran
            $table->decimal('land_area', 10, 2)->nullable();    // m²
            $table->decimal('building_area', 10, 2)->nullable(); // m²

            // Informasi Debitur
            $table->string('debtor_name')->nullable();
            $table->string('debtor_id_number', 20)->nullable();
            $table->text('debtor_address')->nullable();

            // Informasi Lelang
            $table->string('auction_type')->nullable(); // eksekusi_hak_tanggungan, dll
            $table->string('auction_method')->nullable();
            $table->date('auction_date')->nullable();
            $table->time('auction_time')->nullable();
            $table->string('auction_location')->nullable();
            $table->text('auction_address')->nullable();
            $table->string('auction_url')->nullable(); // Link KPKNL

            // Harga
            $table->decimal('limit_price', 20, 2)->nullable();       // Harga limit
            $table->decimal('estimated_price', 20, 2)->nullable();    // Harga estimasi
            $table->decimal('deposit_amount', 20, 2)->nullable();     // Uang jaminan
            $table->decimal('deposit_percentage', 5, 2)->nullable();  // % jaminan
            $table->decimal('increment_amount', 20, 2)->nullable();   // Kenaikan minimum

            // Rekening
            $table->string('bank_name')->nullable();
            $table->string('bank_branch')->nullable();
            $table->string('account_number', 50)->nullable();
            $table->string('account_holder')->nullable();
            $table->string('swift_code', 20)->nullable();

            // Kreditur / Legal
            $table->string('creditor_name')->nullable();
            $table->text('creditor_address')->nullable();
            $table->text('legal_basis')->nullable();
            $table->string('court_decision')->nullable();
            $table->date('court_decision_date')->nullable();
            $table->decimal('debt_amount', 20, 2)->nullable();
            $table->text('encumbrance_details')->nullable();

            // Pendaftaran
            $table->date('registration_start')->nullable();
            $table->date('registration_end')->nullable();
            $table->text('registration_requirements')->nullable();
            $table->text('registration_procedure')->nullable();

            // Viewing / Survey
            $table->date('viewing_start')->nullable();
            $table->date('viewing_end')->nullable();
            $table->text('viewing_schedule')->nullable();
            $table->string('viewing_contact')->nullable();
            $table->text('viewing_notes')->nullable();

            // Syarat & Ketentuan
            $table->text('terms_conditions')->nullable();
            $table->text('special_conditions')->nullable();
            $table->text('payment_terms')->nullable();
            $table->unsignedSmallInteger('payment_deadline_days')->nullable();
            $table->text('delivery_terms')->nullable();

            // Penyelenggara
            $table->string('organizer_name')->nullable();
            $table->string('organizer_type')->nullable();
            $table->text('organizer_address')->nullable();
            $table->string('organizer_phone', 20)->nullable();
            $table->string('organizer_email')->nullable();
            $table->string('organizer_website')->nullable();

            // Kontak
            $table->string('contact_person')->nullable();
            $table->string('contact_position')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('contact_phone', 20)->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_whatsapp', 20)->nullable();
            $table->string('contact_office_hours')->nullable();
            $table->json('contacts')->nullable(); // array [{name, phone}]

            // Fasilitas & Analisis
            $table->text('facilities')->nullable();
            $table->text('nearby_facilities')->nullable();
            $table->text('transportation_access')->nullable();
            $table->text('investment_potential')->nullable();
            $table->text('market_analysis')->nullable();
            $table->text('risk_factors')->nullable();

            // SEO
            $table->string('meta_title')->nullable();
            $table->string('meta_description', 500)->nullable();
            $table->string('meta_keywords')->nullable();

            // Media
            $table->json('images')->nullable(); // array path gambar

            // Status & Publishing
            $table->string('status')->default('draft'); // draft, published, registration_open, registration_closed, sold, cancelled
            $table->boolean('is_featured')->default(false);
            $table->timestamp('featured_until')->nullable();
            $table->boolean('is_urgent')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->integer('view_count')->default(0);
            $table->timestamp('published_at')->nullable();

            // Hasil Lelang
            $table->decimal('winning_bid', 20, 2)->nullable();
            $table->string('winner_name')->nullable();
            $table->string('winner_phone', 20)->nullable();
            $table->date('sold_at')->nullable();

            $table->timestamps();

            // Indexes
            $table->index(['status', 'published_at']);
            $table->index(['auction_date', 'status']);
            $table->index('asset_type');
            $table->index('city');
            $table->index('is_featured');
            $table->index('sort_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('auctions');
    }
};
