<x-frontend-layout>
    <x-slot name="title">Whistleblowing System - {{ $companyInfo->name ?? 'BPR Syariah' }}</x-slot>
    <x-slot name="metaDescription">Sistem pelaporan pelanggaran (Whistleblowing System) PT BPRS Bangka Belitung. Saluran pengaduan independen, rahasia, dan terpercaya.</x-slot>

    @php
        $guarantees = [
            (object)[
                'icon' => 'user-circle',
                'title' => 'Perlindungan Identitas',
                'desc' => 'Identitas pelapor dijamin kerahasiaannya dan tidak akan diungkapkan tanpa persetujuan.'
            ],
            (object)[
                'icon' => 'shield-check',
                'title' => 'Perlindungan Hukum',
                'desc' => 'Pelapor dilindungi dari tindakan balasan, diskriminasi, atau pemutusan hubungan kerja.'
            ],
            (object)[
                'icon' => 'document-text',
                'title' => 'Penanganan Profesional',
                'desc' => 'Setiap laporan ditangani oleh tim independen yang kompeten dan profesional.'
            ],
            (object)[
                'icon' => 'clock',
                'title' => 'Respons Cepat',
                'desc' => 'Laporan akan ditindaklanjuti dalam waktu maksimal 14 hari kerja.'
            ],
        ];
    @endphp

    {{-- ═══ HERO — latar emerald (sama dengan produk/laporan), font editorial ═══ --}}
    <section class="relative text-white overflow-hidden">
        <div class="absolute inset-0 hero-gradient">
            <div class="absolute inset-0 bg-grid-pattern opacity-30"></div>
            <div class="absolute top-10 left-1/4 w-80 h-80 bg-emerald-400/20 rounded-full blur-3xl animate-float-slow"></div>
            <div class="absolute bottom-10 right-1/4 w-96 h-96 bg-emerald-400/20 rounded-full blur-3xl animate-float-slow" style="animation-delay: 3s;"></div>
        </div>
        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-14 pb-14 sm:pt-16 sm:pb-16">
            <div>
                <p class="font-mono text-[11px] sm:text-xs uppercase tracking-[0.3em] text-amber-400/90 mb-4 flex items-center gap-3">
                    <span class="inline-block w-8 h-px bg-amber-400/60"></span>
                    Saluran Independen &amp; Rahasia
                </p>
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold tracking-tight leading-[1.08] mb-5">
                    Whistleblowing System
                </h1>
                <p class="text-slate-300/80 text-sm sm:text-base leading-relaxed">
                    Sarana pelaporan pelanggaran yang independen, rahasia, dan terpercaya.
                    Bersama menjaga integritas perusahaan.
                </p>
            </div>

            {{-- Prinsip — baris berpenggaris, bukan kartu --}}
            <dl class="mt-10 grid grid-cols-1 sm:grid-cols-3 border-t border-slate-700/70 sm:divide-x sm:divide-slate-700/70">
                @foreach([
                    ['Independen', 'Ditangani unit khusus'],
                    ['Rahasia', 'Identitas terlindungi'],
                    ['Tanpa Balasan', 'Dilindungi peraturan'],
                ] as $p)
                <div class="py-4 sm:py-5 sm:px-6 sm:first:pl-0">
                    <dt class="font-mono text-xs font-bold uppercase tracking-widest text-amber-400">{{ $p[0] }}</dt>
                    <dd class="mt-1 text-xs text-slate-400">{{ $p[1] }}</dd>
                </div>
                @endforeach
            </dl>
        </div>
    </section>

    {{-- ═══ 01 · JAMINAN — klausul bernomor ═══ --}}
    <section id="guarantees" class="py-14 sm:py-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-baseline gap-4 mb-8">
                <span class="font-mono text-amber-600 dark:text-amber-400 text-sm font-bold">01</span>
                <div>
                    <h2 class="text-xl sm:text-2xl font-bold text-foreground dark:text-white tracking-tight">Jaminan Perlindungan</h2>
                    <p class="text-sm text-secondary mt-1">Perlindungan bagi pelapor (whistleblower) sesuai dengan peraturan yang berlaku.</p>
                </div>
            </div>

            <ol class="border border-border dark:border-slate-700 divide-y divide-border dark:divide-slate-700 bg-card dark:bg-card">
                @foreach($guarantees as $i => $guarantee)
                <li class="flex items-start gap-4 sm:gap-6 p-5 sm:p-6">
                    <span class="font-mono text-amber-600 dark:text-amber-400 text-lg font-bold shrink-0 mt-0.5">0{{ $i + 1 }}</span>
                    <div class="flex-1">
                        <h4 class="font-bold text-foreground dark:text-white">{{ $guarantee->title }}</h4>
                        <p class="mt-1 text-xs sm:text-sm text-secondary leading-relaxed">{{ $guarantee->desc }}</p>
                    </div>
                </li>
                @endforeach
            </ol>
        </div>
    </section>

    {{-- ═══ 02 · LACAK — band dokumen ═══ --}}
    <section id="lacak" class="pb-14 sm:pb-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="border border-border dark:border-slate-700 bg-card dark:bg-card">
                <div class="flex items-center justify-between gap-4 px-5 sm:px-7 py-4 border-b border-border dark:border-slate-700">
                    <div class="flex items-center gap-3">
                        <span class="font-mono text-amber-600 dark:text-amber-400 text-sm font-bold">02</span>
                        <h2 class="text-base sm:text-lg font-bold text-foreground dark:text-white tracking-tight">Lacak Laporan</h2>
                    </div>
                    <span class="hidden sm:inline font-mono text-[10px] uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">Nomor Tiket</span>
                </div>
                <div class="p-5 sm:p-7">
                    <livewire:frontend.ticket-search type="whistleblower" />
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ 03 · FORMULIR ═══ --}}
    <section id="form" class="pb-16 sm:pb-20">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="border border-border dark:border-slate-700 bg-card dark:bg-card">
                <div class="px-5 sm:px-7 pt-6 sm:pt-7 pb-5 border-b border-border dark:border-slate-700">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="font-mono text-[10px] uppercase tracking-[0.25em] text-amber-600 dark:text-amber-400 mb-1.5">Formulir Resmi</p>
                            <h2 class="text-xl sm:text-2xl font-bold text-foreground dark:text-white tracking-tight">Formulir Laporan Online</h2>
                        </div>
                        <span class="hidden sm:block font-mono text-5xl font-bold text-slate-100 dark:text-slate-800 select-none leading-none">03</span>
                    </div>
                    <p class="mt-2 text-xs sm:text-sm text-secondary">Laporkan dugaan pelanggaran secara anonim. Seluruh data dirahasiakan.</p>
                </div>
                <div class="px-5 sm:px-7 py-6 sm:py-8">
                    <livewire:frontend.complaint.form />
                </div>
            </div>
        </div>
    </section>

</x-frontend-layout>
