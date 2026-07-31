<x-frontend-layout>
    <x-slot name="title">Kebijakan Privasi - {{ $companyInfo->name ?? 'BPRS Bangka Belitung' }}</x-slot>
    <x-slot name="metaDescription">Kebijakan privasi dan perlindungan data nasabah BPRS Bangka Belitung. Komitmen kami dalam menjaga kerahasiaan dan keamanan informasi pribadi Anda.</x-slot>

    @php
        $lastUpdated = '1 Januari 2026';
        $sections = [
            [
                'icon' => 'shield',
                'title' => 'Pendahuluan',
                'content' => 'PT BPRS Bangka Belitung ("Kami", "Kami", "Bank") berkomitmen untuk melindungi privasi dan keamanan data pribadi Nasabah ("Anda"). Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, menyimpan, mengungkapkan, dan melindungi informasi pribadi Anda sesuai dengan:
                <br><br>
                1. Undang-Undang Nomor 27 Tahun 2022 tentang Perlindungan Data Pribadi (UU PDP)<br>
                2. Peraturan Otoritas Jasa Keuangan (POJK) terkait perlindungan konsumen<br>
                3. Prinsip-prinsip syariah dalam perbankan Islam<br>
                4. Standar internasional keamanan data perbankan'
            ],
            [
                'icon' => 'collection',
                'title' => 'Data Pribadi yang Dikumpulkan',
                'content' => 'Kami dapat mengumpulkan data pribadi berikut untuk keperluan layanan perbankan syariah:
                <br><br>
                <strong>Data Identitas:</strong><br>
                • Nama lengkap, tempat dan tanggal lahir<br>
                • Nomor Induk Kependudukan (NIK)<br>
                • Nomor Pokok Wajib Pajak (NPWP)<br>
                • Status perkawinan dan informasi keluarga<br>
                • Kewarganegaraan<br><br>
                <strong>Data Kontak:</strong><br>
                • Alamat rumah dan/atau kantor<br>
                • Nomor telepon dan/atau ponsel<br>
                • Alamat email<br><br>
                <strong>Data Keuangan:</strong><br>
                • Informasi penghasilan dan sumber dana<br>
                • Informasi aset dan kewajiban<br>
                • Riwayat transaksi perbankan<br>
                • Informasi pembiayaan dan agunan<br>
                • Informasi usaha bagi nasabah pembiayaan<br><br>
                <strong>Data Elektronik:</strong><br>
                • Alamat IP (Internet Protocol)<br>
                • Data lokasi perangkat<br>
                • Cookie dan teknologi pelacakan<br>
                • Riwayat aktivitas pada layanan digital kami'
            ],
            [
                'icon' => 'document-text',
                'title' => 'Tujuan Pengumpulan Data',
                'content' => 'Data pribadi Anda dikumpulkan dan digunakan untuk tujuan:
                <br><br>
                1. <strong>Pelayanan Perbankan:</strong> Membuka dan mengelola rekening simpanan, deposito, dan pembiayaan syariah<br><br>
                2. <strong>Verifikasi & Due Diligence:</strong> Menerapkan prinsip Know Your Customer (KYC) dan Anti-Money Laundering (AML) sesuai regulasi<br><br>
                3. <strong>Penilaian Kelayakan:</strong> Menganalisis kelayakan pembiayaan berdasarkan prinsip syariah<br><br>
                4. <strong>Komunikasi:</strong> Menyampaikan informasi produk, layanan, dan kegiatan Bank<br><br>
                5. <strong>Kepatuhan Regulasi:</strong> Memenuhi kewajiban pelaporan kepada OJK, LPS, dan otoritas terkait<br><br>
                6. <strong>Peningkatan Layanan:</strong> Mengembangkan dan meningkatkan kualitas produk dan layanan kami<br><br>
                7. <strong>Keamanan:</strong> Melindungi keamanan transaksi dan mencegah penipuan (fraud)'
            ],
            [
                'icon' => 'clock',
                'title' => 'Periode Penyimpanan Data',
                'content' => 'Kami menyimpan data pribadi Anda selama:
                <br><br>
                • <strong>Masa Aktif:</strong> Selama Anda menjadi nasabah aktif Bank<br>
                • <strong>Pasca Penutupan:</strong> Minimal 10 (sepuluh) tahun setelah hubungan bisnis berakhir, sesuai ketentuan perundang-undangan yang berlaku<br>
                • <strong>Data Transaksi:</strong> Disimpan sesuai ketentuan OJK dan peraturan perpajakan<br><br>
                Setelah periode penyimpanan berakhir, data pribadi Anda akan dihapus atau dianonimkan sehingga tidak dapat lagi diidentifikasi sebagai data pribadi Anda.'
            ],
            [
                'icon' => 'lock-closed',
                'title' => 'Keamanan Data',
                'content' => 'Kami menerapkan langkah-langkah keamanan teknis dan organisasi untuk melindungi data pribadi Anda:
                <br><br>
                <strong>Keamanan Teknis:</strong><br>
                • Enkripsi data dalam penyimpanan dan transmisi menggunakan standar SSL/TLS<br>
                • Firewall dan sistem deteksi intrusi (IDS/IPS)<br>
                • Otentikasi multi-faktor untuk akses sistem internal<br>
                • Perlindungan dari serangan siber dan malware<br><br>
                <strong>Keamanan Organisasi:</strong><br>
                • Pembatasan akses data berdasarkan need-to-know<br>
                • Pelatihan keamanan data bagi seluruh karyawan<br>
                • Audit keamanan secara berkala oleh pihak independen<br>
                • Kebijakan internal tentang perlindungan data pribadi<br><br>
                <strong>Sertifikasi:</strong><br>
                • Standar keamanan informasi sesuai ISO 27001<br>
                • Kepatuhan terhadap PCI DSS (jika berlaku)<br>
                • Sertifikasi sistem inti perbankan dari OJK'
            ],
            [
                'icon' => 'user-group',
                'title' => 'Hak-Hak Anda',
                'content' => 'Sebagai pemilik data pribadi, Anda memiliki hak-hak berikut sesuai UU PDP:
                <br><br>
                1. <strong>Hak Akses:</strong> Meminta informasi tentang data pribadi yang kami miliki<br><br>
                2. <strong>Hak Perbaikan:</strong> Meminta perbaikan data yang tidak akurat atau tidak lengkap<br><br>
                3. <strong>Hak Penghapusan:</strong> Meminta penghapusan data pribadi yang tidak lagi diperlukan<br><br>
                4. <strong>Hak Pembatasan:</strong> Meminta pembatasan pemrosesan data dalam kondisi tertentu<br><br>
                5. <strong>Hak Portabilitas:</strong> Meminta pengiriman data dalam format yang dapat dibaca mesin<br><br>
                6. <strong>Hak Keberatan:</strong> Menolak penggunaan data untuk tujuan pemasaran langsung<br><br>
                7. <strong>Hak Penarikan Persetujuan:</strong> Menarik persetujuan yang telah diberikan sebelumnya<br><br>
                Untuk menggunakan hak-hak ini, silakan hubungi kami melalui kontak yang tercantum di bawah ini. Kami akan merespons permintaan Anda dalam waktu maksimal 30 hari kerja sesuai ketentuan yang berlaku.'
            ],
            [
                'icon' => 'share',
                'title' => 'Pengungkapan Data kepada Pihak Ketiga',
                'content' => 'Kami dapat mengungkapkan data pribadi Anda kepada pihak ketiga dalam kondisi berikut:
                <br><br>
                1. <strong>Regulator & Otoritas:</strong> OJK, LPS, Bank Indonesia, dan otoritas terkait lainnya untuk kepatuhan regulasi<br><br>
                2. <strong>Vendor Layanan:</strong> Pihak ketiga yang menyediakan layanan pemrosesan data, IT, dan operasional bank, dengan perjanjian kerahasiaan yang ketat<br><br>
                3. <strong>Lembaga Keuangan Lain:</strong> Bank koresponden, lembaga kliring, dan asosiasi perbankan untuk keperluan transaksi<br><br>
                4. <strong>Penegak Hukum:</strong> Kepolisian, kejaksaan, atau pengadilan berdasarkan ketentuan hukum yang berlaku<br><br>
                5. <strong>Auditor:</strong> Auditor internal dan eksternal untuk keperluan audit kepatuhan dan keuangan<br><br>
                Kami tidak akan menjual data pribadi Anda kepada pihak ketiga untuk tujuan komersial tanpa persetujuan eksplisit dari Anda.'
            ],
            [
                'icon' => 'globe',
                'title' => 'Penggunaan Cookie',
                'content' => 'Website kami menggunakan cookie dan teknologi serupa untuk meningkatkan pengalaman browsing Anda:
                <br><br>
                <strong>Jenis Cookie yang Digunakan:</strong><br>
                • <strong>Cookie Esensial:</strong> Diperlukan untuk fungsi dasar website, seperti keamanan dan manajemen sesi. Tidak dapat dinonaktifkan.<br>
                • <strong>Cookie Fungsional:</strong> Mengingat preferensi Anda untuk pengalaman yang lebih personal.<br>
                • <strong>Cookie Analitik:</strong> Membantu kami memahami bagaimana pengunjung menggunakan website (anonymized).<br>
                • <strong>Cookie Pemasaran:</strong> Digunakan untuk menampilkan konten yang relevan (dengan persetujuan Anda).<br><br>
                Anda dapat mengelola preferensi cookie melalui pengaturan browser Anda. Menonaktifkan cookie tertentu dapat mempengaruhi fungsionalitas website.'
            ],
        ];
    @endphp

    <!-- Hero -->
    <section class="relative pt-8 sm:pt-10 md:pt-12 pb-16 sm:pb-20 overflow-hidden">
        <div class="absolute inset-0 hero-gradient">
            <div class="absolute inset-0 bg-grid-pattern opacity-50"></div>
            <div class="absolute top-20 left-10 w-72 h-72 bg-emerald-400/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-10 right-10 w-96 h-96 bg-emerald-400/20 rounded-full blur-3xl"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="inline-flex items-center px-3 sm:px-4 py-1.5 sm:py-2 bg-white/10 backdrop-blur-sm rounded-full text-white/90 text-xs sm:text-sm font-medium mb-4 sm:mb-6 animate-slide-up">
                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1.5 sm:mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                Kebijakan Privasi
            </span>
            <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4 sm:mb-6 animate-slide-up delay-100 tracking-tight">Kebijakan Privasi</h1>
            <p class="text-sm sm:text-lg md:text-xl text-white/80 w-full animate-slide-up delay-200 px-4">
                Komitmen {{ $companyInfo->name ?? 'BPRS Bangka Belitung' }} dalam melindungi data pribadi dan privasi Nasabah sesuai prinsip syariah dan peraturan perundang-undangan.
            </p>
            <div class="mt-6 animate-slide-up delay-300">
                <span class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full text-white/70 text-xs sm:text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Terakhir diperbarui: {{ $lastUpdated }}
                </span>
            </div>
        </div>
    </section>

    <!-- Content -->
    <section class="py-12 sm:py-16 md:py-20 bg-muted -mt-8 sm:-mt-10 relative z-10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Quick Summary Card -->
            <div class="bg-card rounded-2xl border border-border p-6 sm:p-8 mb-8 sm:mb-10 shadow-sm" x-intersect="$el.classList.add('animate-slide-up')">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-emerald-50 rounded-xl flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg sm:text-xl font-bold text-card-foreground mb-2">Komitmen Kami</h2>
                        <p class="text-sm sm:text-base text-muted-foreground leading-relaxed">
                            {{ $companyInfo->name ?? 'BPRS Bangka Belitung' }} berkomitmen untuk menjaga kerahasiaan dan keamanan data pribadi Anda. Kebijakan ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi informasi pribadi Anda sehubungan dengan penggunaan produk dan layanan perbankan syariah kami.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Table of Contents -->
            <div class="bg-card rounded-2xl border border-border p-6 sm:p-8 mb-8 sm:mb-10 shadow-sm" x-intersect="$el.classList.add('animate-slide-up')">
                <h2 class="text-lg sm:text-xl font-bold text-card-foreground mb-4 sm:mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    Daftar Isi
                </h2>
                <div class="grid sm:grid-cols-2 gap-2 sm:gap-3">
                    @foreach($sections as $index => $section)
                    <a href="#section-{{ $index + 1 }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-emerald-50 transition-colors group">
                        <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 text-xs font-bold shrink-0 group-hover:scale-110 transition-transform">
                            {{ $index + 1 }}
                        </span>
                        <span class="text-sm font-medium text-card-foreground group-hover:text-emerald-600 transition-colors">{{ $section['title'] }}</span>
                    </a>
                    @endforeach
                </div>
            </div>

            <!-- Content Sections -->
            <div class="space-y-6 sm:space-y-8">
                @foreach($sections as $index => $section)
                <div id="section-{{ $index + 1 }}" class="bg-card rounded-2xl border border-border overflow-hidden shadow-sm card-hover" x-intersect="$el.classList.add('animate-slide-up')">
                    <div class="p-6 sm:p-8">
                        <div class="flex items-center gap-4 mb-4 sm:mb-6">
                            <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-emerald-600 to-emerald-700 rounded-xl flex items-center justify-center shrink-0 shadow-emerald-500/20">
                                @php
                                    $icons = [
                                        'shield' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>',
                                        'collection' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>',
                                        'document-text' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>',
                                        'clock' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                                        'lock-closed' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>',
                                        'user-group' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>',
                                        'share' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>',
                                        'globe' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                                    ];
                                @endphp
                                <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    {!! $icons[$section['icon']] ?? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>' !!}
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-lg sm:text-xl font-bold text-card-foreground">{{ $section['title'] }}</h2>
                            </div>
                        </div>
                        <div class="prose prose-sm sm:prose-base prose-emerald max-w-none text-muted-foreground leading-relaxed">
                            {!! $section['content'] !!}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Contact Section -->
            <div class="mt-8 sm:mt-10 bg-gradient-to-br from-emerald-600 to-emerald-700 rounded-2xl p-6 sm:p-8 md:p-10 text-white relative overflow-hidden" x-intersect="$el.classList.add('animate-scale-in')">
                <div class="absolute top-0 right-0 w-48 h-48 bg-white/10 rounded-full -mr-16 -mt-16"></div>
                <div class="absolute bottom-0 left-0 w-32 h-32 bg-white/10 rounded-full -ml-12 -mb-12"></div>
                <div class="relative">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <h2 class="text-xl sm:text-2xl font-bold">Hubungi Kami</h2>
                    </div>
                    <p class="text-emerald-50 text-sm sm:text-base mb-6 leading-relaxed">
                        Jika Anda memiliki pertanyaan, kekhawatiran, atau ingin menggunakan hak-hak Anda terkait data pribadi, silakan hubungi kami melalui:
                    </p>
                    <div class="grid sm:grid-cols-2 gap-4 mb-6">
                        @if($companyInfo->email)
                        <div class="flex items-center gap-3 p-3 bg-white/10 backdrop-blur-sm rounded-xl">
                            <svg class="w-5 h-5 text-emerald-200 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <div>
                                <p class="text-xs text-emerald-200">Email</p>
                                <p class="text-sm font-semibold">{{ $companyInfo->email }}</p>
                            </div>
                        </div>
                        @endif
                        @if($companyInfo->phone)
                        <div class="flex items-center gap-3 p-3 bg-white/10 backdrop-blur-sm rounded-xl">
                            <svg class="w-5 h-5 text-emerald-200 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            <div>
                                <p class="text-xs text-emerald-200">Telepon</p>
                                <p class="text-sm font-semibold">{{ $companyInfo->phone }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                    <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white dark:bg-slate-800 text-emerald-600 dark:text-emerald-400 rounded-xl font-semibold text-sm hover:bg-emerald-50 dark:hover:bg-slate-700 transition-all btn-press hover:shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        Hubungi Kami
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-frontend-layout>
