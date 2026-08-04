<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Perampingan tabel auctions: 119 kolom → 30 kolom inti.
     * Drop 89 kolom yang jarang dipakai; pertahankan informasi penting.
     */
    public function up(): void
    {
        Schema::table('auctions', function (Blueprint $table) {
            // Asset details (hapus detail properti yang terlalu spesifik)
            $table->dropColumn([
                'object_number',
                'asset_category',
                'asset_description',
                'building_condition',
                'floors',
                'bedrooms',
                'bathrooms',
                'parking_spaces',
                'year_built',
            ]);

            // Certificate (hapus tanggal & penerbit)
            $table->dropColumn(['certificate_date', 'certificate_issued_by']);

            // Location (hapus desa/kecamatan/kode pos/koordinat)
            $table->dropColumn(['village', 'district', 'postal_code', 'latitude', 'longitude']);

            // Debtor (hapus semua info debitur)
            $table->dropColumn(['debtor_name', 'debtor_id_number', 'debtor_address']);

            // Auction detail (hapus alamat & URL lelang)
            $table->dropColumn(['auction_address', 'auction_url']);

            // Registration (hapus periode & prosedur pendaftaran)
            $table->dropColumn([
                'registration_start',
                'registration_end',
                'registration_requirements',
                'registration_procedure',
            ]);

            // Pricing (hapus persentase deposit & increment)
            $table->dropColumn(['deposit_percentage', 'increment_amount']);

            // Bank (hapus semua info bank)
            $table->dropColumn([
                'bank_name',
                'bank_branch',
                'account_number',
                'account_holder',
                'swift_code',
            ]);

            // Legal (hapus semua info legal/kreditur)
            $table->dropColumn([
                'creditor_name',
                'creditor_address',
                'legal_basis',
                'court_decision',
                'court_decision_date',
                'debt_amount',
                'encumbrance_details',
            ]);

            // Viewing (hapus jadwal viewing)
            $table->dropColumn([
                'viewing_start',
                'viewing_end',
                'viewing_schedule',
                'viewing_contact',
                'viewing_notes',
            ]);

            // Terms (hapus syarat & ketentuan detail)
            $table->dropColumn([
                'terms_conditions',
                'special_conditions',
                'payment_terms',
                'payment_deadline_days',
                'delivery_terms',
            ]);

            // Organizer (hapus info penyelenggara)
            $table->dropColumn([
                'organizer_name',
                'organizer_type',
                'organizer_address',
                'organizer_phone',
                'organizer_email',
                'organizer_website',
            ]);

            // Contact (hapus posisi, email, jam kantor, contacts JSON)
            $table->dropColumn([
                'contact_position',
                'contact_email',
                'contact_office_hours',
                'contacts',
            ]);

            // Media (hapus dokumen, denah, sertifikat, virtual tour, video)
            $table->dropColumn([
                'documents',
                'floor_plans',
                'certificates',
                'virtual_tour_url',
                'video_url',
            ]);

            // Winner detail (hapus ID, alamat, telepon pemenang)
            $table->dropColumn(['winner_id_number', 'winner_address', 'winner_phone']);

            // Auction analytics (hapus total bidder/bid, catatan)
            $table->dropColumn(['status_notes', 'auction_notes', 'total_bidders', 'total_bids']);

            // Additional info (hapus fasilitas, akses, analisis pasar, risiko)
            $table->dropColumn([
                'facilities',
                'nearby_facilities',
                'transportation_access',
                'investment_potential',
                'market_analysis',
                'risk_factors',
            ]);

            // SEO (hapus meta title/desc/keywords)
            $table->dropColumn(['meta_title', 'meta_description', 'meta_keywords']);

            // Metrics (hapus interest_count, download_count)
            $table->dropColumn(['interest_count', 'download_count']);

            // Flags (hapus featured_until, is_urgent, sort_order)
            $table->dropColumn(['featured_until', 'is_urgent', 'sort_order']);
        });
    }

    /**
     * Rollback: tambahkan kembali semua kolom (struktur default).
     * PENTING: Data yang sudah dihapus tidak dapat dikembalikan.
     */
    public function down(): void
    {
        Schema::table('auctions', function (Blueprint $table) {
            $table->string('object_number')->nullable();
            $table->string('asset_category')->nullable();
            $table->text('asset_description')->nullable();
            $table->string('building_condition')->nullable();
            $table->integer('floors')->nullable();
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->integer('parking_spaces')->nullable();
            $table->integer('year_built')->nullable();

            $table->date('certificate_date')->nullable();
            $table->string('certificate_issued_by')->nullable();

            $table->string('village')->nullable();
            $table->string('district')->nullable();
            $table->string('postal_code', 10)->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();

            $table->string('debtor_name')->nullable();
            $table->string('debtor_id_number')->nullable();
            $table->text('debtor_address')->nullable();

            $table->text('auction_address')->nullable();
            $table->string('auction_url')->nullable();

            $table->dateTime('registration_start')->nullable();
            $table->dateTime('registration_end')->nullable();
            $table->text('registration_requirements')->nullable();
            $table->text('registration_procedure')->nullable();

            $table->decimal('deposit_percentage', 5, 2)->nullable();
            $table->decimal('increment_amount', 15, 2)->nullable();

            $table->string('bank_name')->nullable();
            $table->string('bank_branch')->nullable();
            $table->string('account_number')->nullable();
            $table->string('account_holder')->nullable();
            $table->string('swift_code')->nullable();

            $table->string('creditor_name')->nullable();
            $table->text('creditor_address')->nullable();
            $table->text('legal_basis')->nullable();
            $table->string('court_decision')->nullable();
            $table->date('court_decision_date')->nullable();
            $table->decimal('debt_amount', 15, 2)->nullable();
            $table->text('encumbrance_details')->nullable();

            $table->dateTime('viewing_start')->nullable();
            $table->dateTime('viewing_end')->nullable();
            $table->text('viewing_schedule')->nullable();
            $table->string('viewing_contact')->nullable();
            $table->text('viewing_notes')->nullable();

            $table->text('terms_conditions')->nullable();
            $table->text('special_conditions')->nullable();
            $table->text('payment_terms')->nullable();
            $table->integer('payment_deadline_days')->nullable();
            $table->text('delivery_terms')->nullable();

            $table->string('organizer_name')->nullable();
            $table->string('organizer_type')->nullable();
            $table->text('organizer_address')->nullable();
            $table->string('organizer_phone')->nullable();
            $table->string('organizer_email')->nullable();
            $table->string('organizer_website')->nullable();

            $table->string('contact_position')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_office_hours')->nullable();
            $table->json('contacts')->nullable();

            $table->json('documents')->nullable();
            $table->json('floor_plans')->nullable();
            $table->json('certificates')->nullable();
            $table->string('virtual_tour_url')->nullable();
            $table->string('video_url')->nullable();

            $table->text('status_notes')->nullable();
            $table->string('winner_id_number')->nullable();
            $table->text('winner_address')->nullable();
            $table->string('winner_phone')->nullable();
            $table->text('auction_notes')->nullable();
            $table->integer('total_bidders')->default(0);
            $table->integer('total_bids')->default(0);

            $table->text('facilities')->nullable();
            $table->text('nearby_facilities')->nullable();
            $table->text('transportation_access')->nullable();
            $table->text('investment_potential')->nullable();
            $table->text('market_analysis')->nullable();
            $table->text('risk_factors')->nullable();

            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();

            $table->unsignedInteger('interest_count')->default(0);
            $table->unsignedInteger('download_count')->default(0);

            $table->timestamp('featured_until')->nullable();
            $table->boolean('is_urgent')->default(false);
            $table->integer('sort_order')->default(0);
        });
    }
};
