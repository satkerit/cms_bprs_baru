<x-frontend-layout>
    <x-slot name="title">Whistleblowing System - {{ $companyInfo->name ?? 'BPR Syariah' }}</x-slot>
    <x-slot name="metaDescription">Sistem pelaporan pelanggaran (Whistleblowing System) PT BPRS Bangka Belitung. Saluran pengaduan independen, rahasia, dan terpercaya.</x-slot>

    @php
        $channels = [
            (object)[
                'icon' => 'email',
                'label' => 'Email Khusus',
                'value' => $companyInfo->email_whistleblower ?? config('whistleblowing.email', 'whistleblower@bprsbabel.co.id'),
                'desc' => 'Kirim laporan melalui email khusus whistleblowing',
                'link' => 'mailto:' . ($companyInfo->email_whistleblower ?? config('whistleblowing.email', 'whistleblower@bprsbabel.co.id')),
                'color' => 'from-emerald-600 to-emerald-700',
                'shadow' => 'shadow-emerald-500/30'
            ],
            (object)[
                'icon' => 'phone',
                'label' => 'Hotline',
                'value' => $companyInfo->phone_whistleblower ?? config('whistleblowing.phone', '0717-xxxxx'),
                'desc' => 'Hubungi hotline khusus whistleblowing',
                'link' => 'tel:' . ($companyInfo->phone_whistleblower ?? config('whistleblowing.phone', '0717-xxxxx')),
                'color' => 'from-blue-500 to-cyan-500',
                'shadow' => 'shadow-blue-500/30'
            ],
            (object)[
                'icon' => 'document',
                'label' => 'Surat / Laporan Tertulis',
                'value' => 'PO BOX',
                'desc' => 'Kirim laporan tertulis melalui pos atau langsung',
                'link' => '#letter',
                'color' => 'from-purple-500 to-pink-500',
                'shadow' => 'shadow-purple-500/30'
            ],
            (object)[
                'icon' => 'globe',
                'label' => 'Form Online',
                'value' => 'Lapor Langsung',
                'desc' => 'Gunakan form online di halaman ini',
                'link' => '#form',
                'color' => 'from-amber-500 to-orange-500',
                'shadow' => 'shadow-amber-500/30'
            ],
        ];

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

    <!-- Hero -->
    <section class="relative pt-24 sm:pt-28 md:pt-32 pb-16 sm:pb-20 overflow-hidden">
        <div class="absolute inset-0 hero-gradient">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.05\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-50"></div>
            <div class="absolute top-20 left-10 w-72 h-72 bg-emerald-400/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-10 right-10 w-96 h-96 bg-emerald-400/20 rounded-full blur-3xl"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="inline-flex items-center px-3 sm:px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full text-white/90 text-xs sm:text-sm font-medium mb-4 sm:mb-6 animate-slide-up">
                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                Whistleblowing System
            </span>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white mb-4 sm:mb-6 animate-slide-up delay-100 tracking-tight">Whistleblowing System</h1>
            <p class="text-base sm:text-lg md:text-xl text-white/80 max-w-3xl mx-auto animate-slide-up delay-200 px-4">
                Sarana pelaporan pelanggaran yang independen, rahasia, dan terpercaya. Bersama menjaga integritas perusahaan.
            </p>
        </div>
    </section>

    <!-- Content -->
    <section class="py-12 sm:py-16 md:py-20 bg-muted -mt-10 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Info Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8 sm:mb-12">
                @foreach($channels as $channel)
                <a href="{{ $channel->link }}" class="bg-white rounded-lg sm:rounded-lg p-4 sm:p-6 shadow-sm border border-border hover:border-emerald-100 transition-all duration-300 group card-hover touch-manipulation">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br {{ $channel->color }} rounded-lg flex items-center justify-center mb-3 sm:mb-4 group-hover:scale-110 transition-transform shadow-lg {{ $channel->shadow }} shrink-0">
                        @if($channel->icon === 'email')
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        @elseif($channel->icon === 'phone')
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        @elseif($channel->icon === 'document')
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        @elseif($channel->icon === 'globe')
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        @endif
                    </div>
                    <h3 class="font-bold text-foreground text-base sm:text-xl mb-1">{{ $channel->label }}</h3>
                    <p class="text-xs sm:text-sm text-secondary mb-2">{{ $channel->desc }}</p>
                    <div class="flex items-center text-emerald-600 font-medium text-xs sm:text-sm group-hover:gap-2 transition-all">
                        <span class="truncate">{{ $channel->value }}</span>
                        <svg class="w-4 h-4 ml-1 shrink-0 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    </div>
                </a>
                @endforeach
            </div>

            <!-- Protection Guarantees -->
            <div class="bg-white rounded-lg sm:rounded-lg p-6 sm:p-8 shadow-sm border border-border mb-8 sm:mb-12" x-intersect="$el.classList.add('animate-slide-up')">
                <div class="flex items-center gap-3 sm:gap-4 mb-6 sm:mb-8">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-emerald-600 to-emerald-700 rounded-lg flex items-center justify-center shadow-emerald-500/30 shrink-0">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <div>
                        <h2 class="text-xl sm:text-2xl font-bold text-foreground">Jaminan Perlindungan</h2>
                        <p class="text-sm sm:text-base text-secondary mt-1">Perlindungan bagi pelapor (whistleblower) sesuai dengan peraturan yang berlaku</p>
                    </div>
                </div>
                <div class="grid sm:grid-cols-2 gap-4 sm:gap-6">
                    @foreach($guarantees as $guarantee)
                    <div class="flex items-start p-4 sm:p-5 bg-muted rounded-lg" x-intersect="$el.classList.add('animate-slide-in-left')">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-emerald-600 to-emerald-700 rounded-lg flex items-center justify-center mr-3 sm:mr-4 shrink-0 shadow-emerald-500/20">
                            @if($guarantee->icon === 'user-circle')
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            @elseif($guarantee->icon === 'shield-check')
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            @elseif($guarantee->icon === 'document-text')
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            @elseif($guarantee->icon === 'clock')
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            @endif
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-foreground text-sm sm:text-base mb-1">{{ $guarantee->title }}</h4>
                            <p class="text-xs sm:text-sm text-secondary leading-relaxed">{{ $guarantee->desc }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Ticket Search -->
            <div class="mb-8 sm:mb-12">
                <div class="bg-white rounded-lg sm:rounded-lg p-4 sm:p-6 md:p-8 shadow-sm border border-border" x-intersect="$el.classList.add('animate-slide-up')">
                    <div class="flex items-center gap-3 sm:gap-4 mb-4 sm:mb-6">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-emerald-600 to-emerald-700 rounded-lg flex items-center justify-center shrink-0 shadow-emerald-500/30">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <div>
                            <h2 class="text-xl sm:text-xl font-bold text-foreground">Lacak Laporan</h2>
                            <p class="text-secondary text-xs sm:text-sm">Masukkan nomor tiket untuk melihat status laporan Anda</p>
                        </div>
                    </div>
                    <livewire:frontend.ticket-search type="whistleblower" />
                </div>
            </div>

            <!-- Report Form -->
            <div id="form" class="bg-white rounded-lg sm:rounded-lg p-4 sm:p-6 md:p-8 shadow-sm border border-border" x-intersect="$el.classList.add('animate-slide-up')">
                <div class="flex items-center gap-3 sm:gap-4 mb-4 sm:mb-6">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-emerald-600 to-emerald-700 rounded-lg flex items-center justify-center shadow-emerald-500/30 shrink-0">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <h2 class="text-xl sm:text-2xl font-bold text-foreground">Form Laporan Online</h2>
                        <p class="text-secondary text-sm sm:text-base">Laporkan dugaan pelanggaran secara anonim (identitas dirahasiakan)</p>
                    </div>
                </div>
                @livewire('frontend.whistleblowing.form')
            </div>
        </div>
    </section>
</x-frontend-layout>
