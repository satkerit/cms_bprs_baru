<footer class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white relative overflow-hidden">
    <!-- Floating Elements -->
    <div class="absolute top-10 left-10 w-32 h-32 bg-orange-500/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-10 right-10 w-40 h-40 bg-emerald-600/10 rounded-full blur-3xl"></div>

    <div class="relative">
        <!-- Main Footer Content -->
        <div class="max-w-7xl mx-auto px-4 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div>
                    <div class="flex items-center gap-3 mb-6">
                        @if($company?->logo)
                            <img src="{{ \App\Helpers\StorageHelper::url($company->logo) }}"
                                 alt="{{ $company->name }}"
                                 class="h-12 w-auto brightness-0 invert">
                        @else
                            <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-red-500 rounded-xl flex items-center justify-center">
                                <span class="text-white font-bold text-xl">{{ substr($company->name ?? 'BPRS', 0, 1) }}</span>
                            </div>
                        @endif
                        <div>
                            <h3 class="text-xl font-bold text-white tracking-tight">Lelang Agunan</h3>
                            <p class="text-orange-400 font-medium">{{ $company->name ?? 'BPRS Bangka Belitung' }}</p>
                        </div>
                    </div>

                    <p class="text-slate-300 mb-6 leading-relaxed">
                        Platform lelang agunan terpercaya untuk mendapatkan properti dan aset berkualitas dengan harga terbaik.
                        Proses transparan, aman, dan sesuai regulasi.
                    </p>

                    <!-- Contact Info -->
                    <div>
                        @if($company->phone)
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 bg-orange-500/20 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400">Telepon</p>
                                <a href="tel:{{ $company->phone }}" class="text-white font-medium hover:text-orange-400 transition-colors">
                                    {{ $company->phone }}
                                </a>
                            </div>
                        </div>
                        @endif

                        @if($company->email)
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 bg-orange-500/20 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400">Email</p>
                                <a href="mailto:{{ $company->email }}" class="text-white font-medium hover:text-orange-400 transition-colors">
                                    {{ $company->email }}
                                </a>
                            </div>
                        </div>
                        @endif

                        @if($company->address)
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-orange-500/20 rounded-lg flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-5 h-5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400">Alamat</p>
                                <p class="text-white leading-relaxed">{{ $company->address }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-bold text-white mb-6 tracking-tight">Navigasi Cepat</h4>
                    <ul class="space-y-3">
                        <li>
                            <a href="{{ route('auctions.index') }}" class="text-slate-400 flex items-center gap-2 hover:text-orange-400 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                                <span>Semua Lelang</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('auctions.index', ['asset_type' => 'rumah']) }}" class="text-slate-400 flex items-center gap-2 hover:text-orange-400 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                                <span>Lelang Rumah</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('auctions.index', ['asset_type' => 'tanah']) }}" class="text-slate-400 flex items-center gap-2 hover:text-orange-400 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                                <span>Lelang Tanah</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('auctions.index', ['asset_type' => 'ruko']) }}" class="text-slate-400 flex items-center gap-2 hover:text-orange-400 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                                <span>Lelang Ruko</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('auctions.index', ['asset_type' => 'kendaraan']) }}" class="text-slate-400 flex items-center gap-2 hover:text-orange-400 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                                <span>Lelang Kendaraan</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('home') }}" class="text-slate-400 flex items-center gap-2 hover:text-orange-400 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                                <span>Kembali ke Beranda</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Auction Info -->
                <div>
                    <h4 class="text-lg font-bold text-white mb-6">Informasi Lelang</h4>
                    <div class="space-y-4">
                        <!-- Live Auction Count -->
                        <div class="bg-gradient-to-r from-orange-500/20 to-red-500/20 rounded-xl p-4 border border-orange-500/30">
                            <div class="flex justify-between">
                                <div>
                                    <p class="text-orange-400 text-sm font-medium">Lelang Aktif</p>
                                    <p class="text-2xl font-bold text-white">
                                        {{ \App\Models\Auction::getCachedActiveCount() }}
                                    </p>
                                </div>
                                <div class="w-12 h-12 bg-orange-500/30 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Operating Hours -->
                        <div class="bg-slate-800/50 rounded-xl p-4 border border-slate-700">
                            <h5 class="text-white font-semibold mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Jam Operasional
                            </h5>
                            <div class="text-sm text-slate-300 space-y-1">
                                <div class="flex justify-between">
                                    <span>Senin - Jumat</span>
                                    <span>08:00 - 16:00</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Sabtu</span>
                                    <span>08:00 - 12:00</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Minggu</span>
                                    <span class="text-red-400">Tutup</span>
                                </div>
                            </div>
                        </div>

                        <!-- Emergency Contact -->
                        <div class="bg-red-500/20 rounded-xl p-4 border border-red-500/30">
                            <h5 class="text-white font-semibold mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.664-.833-2.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                </svg>
                                Kontak Darurat
                            </h5>
                            <p class="text-sm text-slate-300 mb-1">
                                Untuk bantuan mendesak terkait lelang
                            </p>
                            @if($company->phone)
                            <a href="tel:{{ $company->phone }}" class="text-red-300 font-semibold text-sm hover:text-red-200 transition-colors">
                                {{ $company->phone }}
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="border-t border-slate-700">
            <div class="max-w-7xl mx-auto px-4 py-6">
                <div class="flex flex-col items-center gap-4">
                    <div class="text-center">
                        <p class="text-slate-400 text-sm">
                            &copy; {{ date('Y') }} {{ $company->name ?? 'BPRS Bangka Belitung' }}. Semua hak dilindungi.
                        </p>
                        <p class="text-slate-600 text-xs mt-1">
                            Platform Lelang Agunan Resmi dan Terpercaya
                        </p>
                    </div>

                    <!-- Social Media & Links -->
                    <div class="flex items-center gap-6">
                        <div class="flex items-center gap-4">
                            @if($company->website)
                            <a href="{{ $company->website }}" target="_blank" class="text-slate-400 hover:text-orange-400 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"/>
                                </svg>
                            </a>
                            @endif

                            @if($company->email)
                            <a href="mailto:{{ $company->email }}" class="text-slate-400 hover:text-orange-400 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </a>
                            @endif
                        </div>

                        <div class="text-xs text-slate-600 flex items-center gap-2">
                            <span>Powered by</span>
                            <span class="text-orange-500 font-semibold">BPRS Technology</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
