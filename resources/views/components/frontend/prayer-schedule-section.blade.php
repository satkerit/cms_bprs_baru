<section class="relative py-16 lg:py-20 overflow-hidden" x-data="prayerSectionWidget()">
    <!-- Background -->
    <div class="absolute inset-0 hero-gradient"></div>
    <div class="absolute inset-0 bg-grid-pattern opacity-40"></div>

    <!-- Decorative round blurs -->
    <div class="absolute top-20 left-10 w-72 h-72 bg-emerald-400/20 rounded-full blur-3xl"></div>
    <div class="absolute bottom-10 right-10 w-96 h-96 bg-emerald-400/20 rounded-full blur-3xl"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-emerald-50 rounded-full blur-3xl"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-12 fade-in-section" x-intersect="$el.classList.add('is-visible')">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-white/10 backdrop-blur-sm rounded-full border border-white/20 mb-4">
                <svg class="w-4 h-4 text-yellow-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-xs font-semibold text-yellow-200 uppercase tracking-wider">Jadwal Sholat</span>
            </div>
            <h2 class="text-3xl sm:text-4xl font-bold text-white mb-3 tracking-tight">
                Waktu {{ $title ?? 'Sholat' }}
            </h2>
            <p class="text-white/80 mx-auto">
                Jadwal sholat untuk wilayah Bangka Belitung. Tetaplah dekat dengan Allah dalam setiap langkah dan aktivitas Anda.
            </p>
        </div>

        <!-- Loading State -->
        <template x-if="loading">
            <div class="text-center py-16">
                <div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-white/30 border-t-white"></div>
                <p class="text-white/80 text-base mt-4">Memuat jadwal sholat...</p>
            </div>
        </template>

        <!-- Error State -->
        <template x-if="!loading && error">
            <div class="text-center py-12">
                <div class="w-16 h-16 mx-auto mb-4 bg-white/10 rounded-2xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-yellow-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <p class="text-white/90 text-lg mb-4" x-text="error"></p>
                <button @click="fetchPrayerTimes()" class="px-5 py-2.5 bg-white/20 hover:bg-white/30 text-white rounded-xl text-sm font-semibold transition-all backdrop-blur-sm border border-white/20">
                    Coba Lagi
                </button>
            </div>
        </template>

        <!-- Content -->
        <template x-if="!loading && !error && prayerTimes.length > 0">
            <div>
                <!-- Date & Time Row -->
                <div class="grid md:grid-cols-2 gap-6 mb-8">
                    <!-- Current Time Card -->
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 sm:p-8 border border-white/10 text-center md:text-left fade-in-section" x-intersect="$el.classList.add('is-visible')">
                        <p class="text-white/70 text-sm mb-2">Waktu Saat Ini</p>
                        <div class="text-5xl sm:text-6xl font-bold text-white tracking-tight tabular-nums" x-text="currentTime"></div>
                        <div class="mt-3 space-y-1">
                            <p class="text-white/80 text-base" x-text="currentDate"></p>
                            <p class="text-white/60 text-sm" x-text="hijriDate"></p>
                        </div>
                    </div>

                    <!-- Next Prayer Countdown -->
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 sm:p-8 border border-white/10 text-center fade-in-section" x-intersect="$el.classList.add('is-visible')" style="animation-delay: 0.1s;">
                        <p class="text-yellow-200 font-semibold text-sm mb-1">Menuju Waktu</p>
                        <p class="text-white font-bold text-2xl mb-4" x-text="nextPrayer?.name"></p>
                        <template x-if="nextPrayer">
                            <div class="flex items-center justify-center gap-3">
                                <div class="bg-white/15 rounded-xl px-4 py-3 min-w-[70px]">
                                    <div class="text-3xl font-bold text-white tabular-nums" x-text="countdown.hours"></div>
                                    <div class="text-white/60 text-xs mt-0.5">Jam</div>
                                </div>
                                <span class="text-white/60 text-2xl font-bold">:</span>
                                <div class="bg-white/15 rounded-xl px-4 py-3 min-w-[70px]">
                                    <div class="text-3xl font-bold text-white tabular-nums" x-text="countdown.minutes"></div>
                                    <div class="text-white/60 text-xs mt-0.5">Menit</div>
                                </div>
                                <span class="text-white/60 text-2xl font-bold">:</span>
                                <div class="bg-white/15 rounded-xl px-4 py-3 min-w-[70px]">
                                    <div class="text-3xl font-bold text-white tabular-nums" x-text="countdown.seconds"></div>
                                    <div class="text-white/60 text-xs mt-0.5">Detik</div>
                                </div>
                            </div>
                        </template>
                        <template x-if="!nextPrayer">
                            <p class="text-white/80 text-lg">Hari ini telah selesai</p>
                        </template>
                    </div>
                </div>

                <!-- Prayer Times Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3 sm:gap-4 fade-in-section" x-intersect="$el.classList.add('is-visible')">
                    <template x-for="(prayer, index) in prayerTimes" :key="prayer.name">
                        <div class="rounded-2xl p-4 sm:p-5 text-center transition-all duration-300 border"
                             :class="prayer.isNext
                                ? 'bg-white/20 border-yellow-200/40 shadow-lg shadow-black/10 scale-105'
                                : prayer.isPast
                                    ? 'bg-white/5 border-white/5 opacity-60'
                                    : 'bg-white/10 border-white/10 hover:bg-white/15 hover:-translate-y-0.5'">
                            <div class="w-10 h-10 mx-auto mb-3 rounded-xl flex items-center justify-center"
                                 :class="prayer.isNext ? 'bg-yellow-200/30' : 'bg-white/10'">
                                <template x-if="prayer.name === 'Subuh'">
                                    <svg class="w-5 h-5" :class="prayer.isNext ? 'text-yellow-200' : 'text-white/80'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                                    </svg>
                                </template>
                                <template x-if="prayer.name === 'Dzuhur'">
                                    <svg class="w-5 h-5" :class="prayer.isNext ? 'text-yellow-200' : 'text-white/80'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                </template>
                                <template x-if="prayer.name === 'Ashar'">
                                    <svg class="w-5 h-5" :class="prayer.isNext ? 'text-yellow-200' : 'text-white/80'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                    </svg>
                                </template>
                                <template x-if="prayer.name === 'Maghrib'">
                                    <svg class="w-5 h-5" :class="prayer.isNext ? 'text-yellow-200' : 'text-white/80'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12h2m7-7v2m5.364-2.364l-1.414 1.414M21 12h-2m-7 7v-2M7.05 5.636L5.636 7.05M3 12h18"/>
                                    </svg>
                                </template>
                                <template x-if="prayer.name === 'Isya'">
                                    <svg class="w-5 h-5" :class="prayer.isNext ? 'text-yellow-200' : 'text-white/80'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                                    </svg>
                                </template>
                            </div>
                            <p class="text-white font-semibold text-sm sm:text-base" x-text="prayer.name"></p>
                            <p class="text-white/80 font-bold text-base sm:text-lg mt-1 tabular-nums" x-text="prayer.time"></p>
                            <div x-show="prayer.isNext" class="mt-2">
                                <span class="inline-block px-2 py-0.5 bg-yellow-200/20 text-yellow-200 text-xs font-semibold rounded-full">Selanjutnya</span>
                            </div>
                            <div x-show="prayer.isNext === false && prayer.isPast" class="mt-2">
                                <span class="inline-block px-2 py-0.5 text-white/40 text-xs">Selesai</span>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </template>
    </div>
</section>
