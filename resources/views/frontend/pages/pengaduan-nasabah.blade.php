<x-frontend-layout>
    <x-slot name="title">Pengaduan Nasabah - {{ $companyInfo->name ?? 'BPR Syariah' }}</x-slot>

    {{-- ═══ HERO ═══ --}}
    <section class="relative pt-8 sm:pt-10 md:pt-12 pb-20 sm:pb-24 overflow-hidden">
        {{-- Background --}}
        <div class="absolute inset-0 hero-gradient">
            <div class="absolute inset-0 bg-grid-pattern opacity-30"></div>
            <div class="absolute top-0 left-1/4 w-96 h-96 bg-emerald-300/15 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-1/4 w-80 h-80 bg-emerald-400/10 rounded-full blur-3xl"></div>
        </div>

        <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            {{-- Badge --}}
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full text-emerald-100 text-xs sm:text-sm font-medium mb-6 border border-white/20">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                Layanan Resmi BPRS Bangka Belitung
            </div>

            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white mb-4 tracking-tight leading-tight">
                Pengaduan Nasabah
            </h1>
            <p class="text-base sm:text-lg text-white/80 w-full leading-relaxed">
                Kami berkomitmen merespons setiap pengaduan dengan serius, cepat, dan transparan.
                Sampaikan keluhan, saran, atau masukan Anda — suara Anda adalah cermin kualitas layanan kami
                dan landasan perbaikan yang berkelanjutan.
            </p>

            {{-- Stats bar --}}
            <div class="mt-10 flex flex-wrap justify-center gap-6 sm:gap-10">
                @foreach([
                    ['14', 'Hari Kerja', 'Waktu penyelesaian'],
                    ['24/7', 'Online', 'Form tersedia kapan saja'],
                    ['100%', 'Rahasia', 'Data Anda terlindungi'],
                ] as $stat)
                <div class="text-center">
                    <div class="text-2xl sm:text-3xl font-bold text-white">{{ $stat[0] }}</div>
                    <div class="text-xs text-emerald-200 font-semibold uppercase tracking-wider mt-0.5">{{ $stat[1] }}</div>
                    <div class="text-xs text-white/60 mt-0.5">{{ $stat[2] }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══ LACAK TIKET — Floating card ═══ --}}
    <section class="relative z-10 -mt-8 pb-4">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-xl shadow-black/10 border border-border dark:border-slate-700 overflow-hidden">
                {{-- Header strip --}}
                <div class="bg-gradient-to-r from-slate-800 to-slate-900 dark:from-slate-950 dark:to-slate-900 px-6 py-4 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-emerald-500/20 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <div>
                        <h2 class="font-bold text-white text-sm">Lacak Status Pengaduan</h2>
                        <p class="text-xs text-slate-400">Masukkan nomor tiket yang Anda terima saat mendaftar</p>
                    </div>
                </div>
                <div class="p-6">
                    <livewire:frontend.ticket-search type="customer" />
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ PROSES — How it works ═══ --}}
    <section class="py-14 sm:py-16">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10">
                <h2 class="text-2xl sm:text-3xl font-bold text-foreground dark:text-white">Bagaimana Prosesnya?</h2>
                <p class="text-secondary text-sm mt-2">Pengaduan Anda diproses secara transparan dalam 4 tahap</p>
            </div>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                @foreach([
                    ['1', 'Kirim Laporan', 'Isi form dengan lengkap dan jelas', 'from-emerald-500 to-emerald-600', 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                    ['2', 'Verifikasi', 'Tim kami memverifikasi laporan Anda', 'from-blue-500 to-blue-600', 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4'],
                    ['3', 'Penyelidikan', 'Investigasi mendalam oleh tim terkait', 'from-violet-500 to-violet-600', 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z'],
                    ['4', 'Penyelesaian', 'Respons & solusi dikirim ke Anda', 'from-amber-500 to-amber-600', 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                ] as $step)
                <div class="relative bg-white dark:bg-slate-900 rounded-2xl p-5 shadow-sm border border-border dark:border-slate-700 text-center group hover:shadow-md transition-shadow duration-300">
                    <div class="w-12 h-12 bg-gradient-to-br {{ $step[3] }} rounded-xl flex items-center justify-center mx-auto mb-3 shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $step[4] }}"/></svg>
                    </div>
                    <div class="absolute top-4 right-4 text-3xl font-black text-slate-100 dark:text-slate-800 select-none">{{ $step[0] }}</div>
                    <h3 class="font-bold text-sm text-foreground dark:text-white mb-1">{{ $step[1] }}</h3>
                    <p class="text-xs text-secondary leading-relaxed">{{ $step[2] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══ MAIN: FORM + SIDEBAR ═══ --}}
    <section class="pb-16 sm:pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-5 gap-8 xl:gap-10 items-start">

                {{-- ─── LEFT SIDEBAR ─── --}}
                <aside class="lg:col-span-2 space-y-5 lg:sticky lg:top-32">

                    {{-- Kategori Pengaduan --}}
                    <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 shadow-sm border border-border dark:border-slate-700">
                        <h3 class="font-bold text-base text-foreground dark:text-white mb-4 flex items-center gap-2">
                            <span class="w-7 h-7 bg-emerald-100 dark:bg-emerald-900/50 rounded-lg flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
                            </span>
                            Kategori Pengaduan
                        </h3>
                        <ul class="space-y-2.5">
                            @foreach([
                                ['Produk & Layanan', 'Tabungan, pembiayaan, deposito', 'from-emerald-500 to-emerald-600'],
                                ['Kualitas Pelayanan', 'Sikap dan profesionalisme petugas', 'from-blue-500 to-blue-600'],
                                ['Tagihan & Pembayaran', 'Kesalahan tagihan atau transaksi', 'from-violet-500 to-violet-600'],
                                ['Kendala Teknis', 'Sistem atau aplikasi bermasalah', 'from-orange-500 to-orange-600'],
                                ['Saran & Masukan', 'Ide untuk perbaikan layanan', 'from-teal-500 to-teal-600'],
                                ['Lainnya', 'Kategori di luar daftar di atas', 'from-slate-500 to-slate-600'],
                            ] as $cat)
                            <li class="flex items-center gap-3 text-sm">
                                <span class="w-2 h-2 rounded-full bg-gradient-to-br {{ $cat[2] }} shrink-0"></span>
                                <div>
                                    <span class="font-medium text-foreground dark:text-slate-200">{{ $cat[0] }}</span>
                                    <span class="text-secondary text-xs block leading-tight">{{ $cat[1] }}</span>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- SLA & Waktu --}}
                    <div class="bg-gradient-to-br from-emerald-600 to-emerald-700 rounded-2xl p-5 text-white">
                        <div class="flex items-start gap-3 mb-3">
                            <div class="w-9 h-9 bg-white/15 rounded-xl flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-sm">Waktu Penyelesaian</h3>
                                <p class="text-emerald-100 text-xs mt-1 leading-relaxed">Pengaduan ditindaklanjuti maksimal <strong class="text-white">20 hari kerja</strong> sesuai ketentuan OJK.</p>
                            </div>
                        </div>
                        <div class="bg-white/10 rounded-xl p-3 text-xs text-emerald-100 leading-relaxed">
                            Anda akan mendapat notifikasi email di setiap perubahan status pengaduan.
                        </div>
                    </div>

                    {{-- Kontak Alternatif --}}
                    <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 shadow-sm border border-border dark:border-slate-700">
                        <h3 class="font-bold text-base text-foreground dark:text-white mb-4 flex items-center gap-2">
                            <span class="w-7 h-7 bg-blue-100 dark:bg-blue-900/50 rounded-lg flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </span>
                            Kontak Alternatif
                        </h3>
                        <div class="space-y-3">
                            <a href="mailto:{{ $companyInfo->email_complaint ?? $companyInfo->email ?? '#' }}"
                               class="flex items-center gap-3 p-3 rounded-xl bg-slate-50 dark:bg-slate-800 hover:bg-emerald-50 dark:hover:bg-emerald-900/30 transition-colors group">
                                <div class="w-8 h-8 bg-emerald-100 dark:bg-emerald-900/50 rounded-lg flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs text-secondary">Email Pengaduan</p>
                                    <p class="text-sm font-medium text-foreground dark:text-white truncate">{{ $companyInfo->email_complaint ?? $companyInfo->email ?? '-' }}</p>
                                </div>
                            </a>
                            @if($companyInfo->phone)
                            <a href="tel:{{ $companyInfo->phone }}"
                               class="flex items-center gap-3 p-3 rounded-xl bg-slate-50 dark:bg-slate-800 hover:bg-emerald-50 dark:hover:bg-emerald-900/30 transition-colors group">
                                <div class="w-8 h-8 bg-emerald-100 dark:bg-emerald-900/50 rounded-lg flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-secondary">Telepon</p>
                                    <p class="text-sm font-medium text-foreground dark:text-white">{{ $companyInfo->phone }}</p>
                                </div>
                            </a>
                            @endif
                        </div>
                    </div>

                    {{-- Whistleblowing CTA --}}
                    <div class="bg-amber-50 dark:bg-amber-900/20 rounded-2xl p-5 border border-amber-200 dark:border-amber-700/40">
                        <div class="flex gap-3">
                            <div class="w-9 h-9 bg-amber-100 dark:bg-amber-900/50 rounded-xl flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-sm text-amber-800 dark:text-amber-400 mb-1">Melaporkan Pelanggaran?</h4>
                                <p class="text-xs text-amber-700 dark:text-amber-500 mb-3 leading-relaxed">Gunakan Whistleblowing System untuk melaporkan dugaan kecurangan atau pelanggaran secara anonim.</p>
                                <a href="{{ route('whistleblowing') }}"
                                   class="inline-flex items-center gap-1.5 text-xs font-semibold text-amber-700 dark:text-amber-400 hover:text-amber-900 dark:hover:text-amber-300 transition-colors">
                                    Buka Whistleblowing System
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </aside>

                {{-- ─── FORM AREA ─── --}}
                <div class="lg:col-span-3">
                    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-border dark:border-slate-700 overflow-hidden">
                        {{-- Form header --}}
                        <div class="px-6 sm:px-8 pt-6 sm:pt-8 pb-4 border-b border-border dark:border-slate-700">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-emerald-600 to-emerald-700 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-500/20 shrink-0">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </div>
                                <div>
                                    <h2 class="text-xl sm:text-2xl font-bold text-foreground dark:text-white leading-tight">Form Pengaduan Nasabah</h2>
                                    <p class="text-secondary text-sm mt-1">Lengkapi seluruh field bertanda <span class="text-red-500 font-bold">*</span> dengan informasi yang akurat</p>
                                </div>
                            </div>
                        </div>

                        {{-- Form body --}}
                        <div class="px-6 sm:px-8 py-6 sm:py-8">
                            <livewire:frontend.customer-complaint.form />
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

</x-frontend-layout>
