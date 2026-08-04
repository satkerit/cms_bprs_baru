<x-frontend-layout>
    <x-slot name="title">Pengaduan Nasabah - {{ $companyInfo->name ?? 'BPR Syariah' }}</x-slot>

    {{-- ═══ HERO — tinta gelap, aksen amber (sama dengan Whistleblowing) ═══ --}}
    <section class="relative bg-slate-950 text-white overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_left,rgba(217,119,6,0.12),transparent_50%)]"></div>
        <div class="absolute -top-20 right-10 w-80 h-80 rounded-full border border-amber-400/10"></div>
        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-14 pb-14 sm:pt-16 sm:pb-16">
            <div>
                <p class="font-mono text-[11px] sm:text-xs uppercase tracking-[0.3em] text-amber-400/90 mb-4 flex items-center gap-3">
                    <span class="inline-block w-8 h-px bg-amber-400/60"></span>
                    Layanan Resmi Pengaduan
                </p>
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold tracking-tight leading-[1.08] mb-5">
                    Pengaduan Nasabah
                </h1>
                <p class="text-slate-300/80 text-sm sm:text-base leading-relaxed">
                    Kami menanggapi setiap pengaduan dengan serius, cepat, dan transparan.
                    Sampaikan keluhan, saran, atau masukan Anda — suara Anda menjadi dasar
                    perbaikan layanan yang berkelanjutan.
                </p>
            </div>

            {{-- Statistik — baris berpenggaris, bukan kartu --}}
            <dl class="mt-10 grid grid-cols-1 sm:grid-cols-3 border-t border-slate-700/70 sm:divide-x sm:divide-slate-700/70">
                @foreach([
                    ['14', 'Hari Kerja', 'Waktu penyelesaian'],
                    ['24/7', 'Online', 'Form tersedia kapan saja'],
                    ['100%', 'Rahasia', 'Data Anda terlindungi'],
                ] as $stat)
                <div class="py-4 sm:py-5 sm:px-6 sm:first:pl-0">
                    <dt class="font-mono text-2xl sm:text-3xl font-bold tracking-tight">{{ $stat[0] }}</dt>
                    <dd class="mt-1 font-mono text-[11px] font-bold uppercase tracking-widest text-amber-400">{{ $stat[1] }}</dd>
                    <dd class="text-xs text-slate-400 mt-1">{{ $stat[2] }}</dd>
                </div>
                @endforeach
            </dl>
        </div>
    </section>

    {{-- ═══ 01 · PROSES — daftar bernomor, bukan kartu 4 kolom ═══ --}}
    <section id="proses" class="py-14 sm:py-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-baseline gap-4 mb-8">
                <span class="font-mono text-emerald-700 dark:text-emerald-400 text-sm font-bold">01</span>
                <div>
                    <h2 class="text-xl sm:text-2xl font-bold text-foreground dark:text-white tracking-tight">Bagaimana Prosesnya?</h2>
                    <p class="text-sm text-secondary mt-1">Empat tahap penanganan, dari laporan masuk hingga penyelesaian.</p>
                </div>
            </div>

            <ol class="border border-border dark:border-slate-700 divide-y divide-border dark:divide-slate-700 bg-card dark:bg-card">
                @foreach([
                    ['Kirim Laporan', 'Isi formulir dengan lengkap dan jelas. Sertakan bukti pendukung bila tersedia.'],
                    ['Verifikasi', 'Tim kami memverifikasi kelengkapan dan kebenaran laporan Anda.'],
                    ['Penyelidikan', 'Unit terkait melakukan investigasi dan koordinasi untuk mencari solusi.'],
                    ['Penyelesaian', 'Hasil dan solusi disampaikan kepada Anda, dengan notifikasi email di setiap perubahan status.'],
                ] as $i => $step)
                <li class="flex items-start gap-4 sm:gap-6 p-5 sm:p-6">
                    <span class="font-mono text-emerald-700 dark:text-emerald-400 text-lg font-bold shrink-0 mt-0.5">0{{ $i + 1 }}</span>
                    <div class="flex-1">
                        <h3 class="font-bold text-foreground dark:text-white">{{ $step[0] }}</h3>
                        <p class="mt-1 text-xs sm:text-sm text-secondary leading-relaxed">{{ $step[1] }}</p>
                    </div>
                    <svg class="w-4 h-4 text-slate-300 dark:text-slate-600 shrink-0 mt-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </li>
                @endforeach
            </ol>
        </div>
    </section>

    {{-- ═══ 02 · LACAK — band dokumen ═══ --}}
    <section id="lacak" class="pb-4">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="border border-border dark:border-slate-700 bg-card dark:bg-card">
                <div class="flex items-center justify-between gap-4 px-5 sm:px-7 py-4 border-b border-border dark:border-slate-700">
                    <div class="flex items-center gap-3">
                        <span class="font-mono text-emerald-700 dark:text-emerald-400 text-sm font-bold">02</span>
                        <h2 class="text-base sm:text-lg font-bold text-foreground dark:text-white tracking-tight">Lacak Status Pengaduan</h2>
                    </div>
                    <span class="hidden sm:inline font-mono text-[10px] uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">Nomor Tiket</span>
                </div>
                <div class="p-5 sm:p-7">
                    <livewire:frontend.ticket-search type="customer" />
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ 03 · FORMULIR + SIDEBAR ═══ --}}
    <section id="form" class="py-14 sm:py-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 grid lg:grid-cols-12 gap-8 lg:gap-12 items-start">

            {{-- ─── SIDEBAR — daftar isi & info singkat ─── --}}
            <aside class="lg:col-span-4 order-2 lg:order-1 space-y-6 lg:sticky lg:top-32">

                <nav class="border border-border dark:border-slate-700 bg-card dark:bg-card">
                    <p class="px-5 pt-5 pb-3 font-mono text-[10px] uppercase tracking-[0.25em] text-slate-400 dark:text-slate-500">Isi Halaman Ini</p>
                    <ol class="divide-y divide-border dark:divide-slate-700">
                        @foreach([
                            ['#proses', '01', 'Bagaimana prosesnya'],
                            ['#lacak', '02', 'Lacak status pengaduan'],
                            ['#form', '03', 'Formulir pengaduan'],
                        ] as $link)
                        <li>
                            <a href="{{ $link[0] }}" class="flex items-center gap-3 px-5 py-3 text-sm hover:bg-emerald-50/60 dark:hover:bg-emerald-950/30 transition-colors">
                                <span class="font-mono text-emerald-700 dark:text-emerald-400 font-bold text-xs">{{ $link[1] }}</span>
                                <span class="font-medium text-foreground dark:text-slate-200">{{ $link[2] }}</span>
                            </a>
                        </li>
                        @endforeach
                    </ol>
                </nav>

                <div class="border-l-2 border-emerald-600 dark:border-emerald-500 pl-4">
                    <h3 class="text-sm font-bold text-foreground dark:text-white">Waktu Penyelesaian</h3>
                    <p class="mt-1 text-xs text-secondary leading-relaxed">
                        Pengaduan ditindaklanjuti maksimal <strong class="text-emerald-700 dark:text-emerald-400">20 hari kerja</strong>
                        sesuai ketentuan OJK, dan mayoritas selesai dalam 14 hari.
                    </p>
                    <p class="mt-2 text-xs text-secondary leading-relaxed">Anda mendapat notifikasi email pada setiap perubahan status.</p>
                </div>

                <div class="border border-border dark:border-slate-700 bg-card dark:bg-card divide-y divide-border dark:divide-slate-700">
                    <p class="px-5 pt-5 pb-3 font-mono text-[10px] uppercase tracking-[0.25em] text-slate-400 dark:text-slate-500">Kontak Alternatif</p>
                    <a href="mailto:{{ $companyInfo->email_complaint ?? $companyInfo->email ?? '#' }}"
                       class="flex items-center gap-3 px-5 py-4 group">
                        <span class="w-9 h-9 rounded-lg border border-emerald-200 dark:border-emerald-800/60 bg-emerald-50 dark:bg-emerald-950/40 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </span>
                        <span class="min-w-0">
                            <span class="block text-[10px] font-mono uppercase tracking-widest text-slate-400 dark:text-slate-500">Email Pengaduan</span>
                            <span class="block text-sm font-medium text-foreground dark:text-white truncate mt-0.5 group-hover:text-emerald-700 dark:group-hover:text-emerald-400 transition-colors">{{ $companyInfo->email_complaint ?? $companyInfo->email ?? '-' }}</span>
                        </span>
                    </a>
                    @if($companyInfo->phone)
                    <a href="tel:{{ $companyInfo->phone }}" class="flex items-center gap-3 px-5 py-4 group">
                        <span class="w-9 h-9 rounded-lg border border-emerald-200 dark:border-emerald-800/60 bg-emerald-50 dark:bg-emerald-950/40 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </span>
                        <span>
                            <span class="block text-[10px] font-mono uppercase tracking-widest text-slate-400 dark:text-slate-500">Telepon</span>
                            <span class="block text-sm font-medium text-foreground dark:text-white mt-0.5 group-hover:text-emerald-700 dark:group-hover:text-emerald-400 transition-colors">{{ $companyInfo->phone }}</span>
                        </span>
                    </a>
                    @endif
                </div>

                <div class="bg-amber-50 dark:bg-amber-900/10 border border-amber-200 dark:border-amber-700/40 p-5">
                    <p class="font-mono text-[10px] uppercase tracking-[0.25em] text-amber-700 dark:text-amber-400">Saluran Khusus</p>
                    <h3 class="mt-2 text-sm font-bold text-amber-900 dark:text-amber-300">Melaporkan pelanggaran internal?</h3>
                    <p class="mt-1 text-xs text-amber-800/80 dark:text-amber-500 leading-relaxed">Gunakan Whistleblowing System untuk dugaan kecurangan atau pelanggaran, dengan opsi laporan anonim.</p>
                    <a href="{{ route('whistleblowing') }}"
                       class="mt-3 inline-flex items-center gap-2 text-xs font-bold text-amber-800 dark:text-amber-400 hover:text-amber-950 dark:hover:text-amber-200 transition-colors">
                        Buka Whistleblowing System
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>

                <div class="border border-border dark:border-slate-700 bg-card dark:bg-card p-5">
                    <p class="font-mono text-[10px] uppercase tracking-[0.25em] text-slate-400 dark:text-slate-500 mb-3">Sebelum Mengisi, Siapkan</p>
                    <ul class="space-y-2 text-xs text-secondary leading-relaxed">
                        <li class="flex gap-2"><span class="text-emerald-600 dark:text-emerald-400 shrink-0">•</span>Nomor rekening atau identitas nasabah (jika ada)</li>
                        <li class="flex gap-2"><span class="text-emerald-600 dark:text-emerald-400 shrink-0">•</span>Bukti pendukung — bukti transaksi, tangkapan layar, atau dokumen lain</li>
                        <li class="flex gap-2"><span class="text-emerald-600 dark:text-emerald-400 shrink-0">•</span>Kronologi kejadian yang ingin disampaikan</li>
                    </ul>
                </div>
            </aside>

            {{-- ─── FORM — kertas formulir ─── --}}
            <div class="lg:col-span-8 order-1 lg:order-2">
                <div class="border border-border dark:border-slate-700 bg-card dark:bg-card">
                    <div class="px-5 sm:px-7 pt-6 sm:pt-7 pb-5 border-b border-border dark:border-slate-700">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="font-mono text-[10px] uppercase tracking-[0.25em] text-emerald-700 dark:text-emerald-400 mb-1.5">Formulir Resmi</p>
                                <h2 class="text-xl sm:text-2xl font-bold text-foreground dark:text-white tracking-tight">Formulir Pengaduan Nasabah</h2>
                            </div>
                            <span class="hidden sm:block font-mono text-5xl font-bold text-slate-100 dark:text-slate-800 select-none leading-none">03</span>
                        </div>
                        <p class="mt-2 text-xs sm:text-sm text-secondary">Lengkapi seluruh kolom bertanda <span class="text-red-600 font-bold">*</span>. Informasi yang lengkap mempercepat penanganan.</p>
                    </div>
                    <div class="px-5 sm:px-7 py-6 sm:py-8">
                        <livewire:frontend.customer-complaint.form />
                    </div>
                </div>
            </div>

        </div>
    </section>

</x-frontend-layout>
