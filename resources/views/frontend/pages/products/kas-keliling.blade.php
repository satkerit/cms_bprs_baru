<x-frontend-layout>
    <x-slot name="title">Kas Keliling - {{ $product->name ?? 'BPRS Bangka Belitung' }}</x-slot>

    <!-- Hero -->
    <section class="relative pt-24 sm:pt-28 md:pt-32 pb-12 sm:pb-16 md:pb-20 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-emerald-600 via-emerald-500 to-emerald-600">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23ffffff&quot; fill-opacity=&quot;0.03&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-50"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-2xl font-bold sm:text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4 sm:mb-6 tracking-tight">Layanan Kas Keliling</h1>
            <p class="text-sm sm:text-lg md:text-xl text-white/80 mx-auto px-4">
                Layanan jemput tabungan dan pembiayaan syariah yang mendekatkan Anda dengan transaksi perbankan.
            </p>
        </div>
    </section>

    <!-- Content -->
    <section class="py-12 sm:py-16 md:py-20 bg-muted/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($schedules->count() > 0)
                <!-- Schedule Information -->
                <div class="mb-8 sm:mb-12">
                    <h2 class="text-lg font-semibold sm:text-2xl font-bold text-foreground mb-3 sm:mb-4 text-center">Jadwal Kas Keliling</h2>
                    <p class="text-sm sm:text-base text-muted-foreground text-center mb-6 sm:mb-8">Berikut adalah jadwal layanan kas keliling BPRS Bangka Belitung.</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                        @foreach($schedules as $schedule)
                            <div class="bg-card rounded-lg sm:rounded-lg shadow-gray-200/50 border border-border p-4 sm:p-6 hover:shadow-sm hover:-translate-y-1 transition-all duration-300 group touch-manipulation active:scale-[0.99]">
                                <div class="flex items-start gap-3 sm:gap-4 mb-3 sm:mb-4">
                                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-emerald-50 to-emerald-50 rounded-lg flex items-center justify-center text-emerald-600 shrink-0">
                                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-sm sm:text-base font-bold text-foreground group-hover:text-emerald-600 transition-colors">{{ $schedule->location }}</h3>
                                    </div>
                                </div>

                                <div class="space-y-1.5 sm:space-y-2 text-xs sm:text-sm mb-3 sm:mb-4">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-muted-foreground shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span class="font-semibold">{{ $schedule->day_name }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-muted-foreground shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span>{{ $schedule->start_time ? \Carbon\Carbon::parse($schedule->start_time)->format('H:i') : '-' }} - {{ $schedule->end_time ? \Carbon\Carbon::parse($schedule->end_time)->format('H:i') : '-' }}</span>
                                    </div>
                                </div>

                                @if($schedule->notes)
                                    <p class="text-xs sm:text-sm text-muted-foreground italic border-t border-border pt-3">{{ $schedule->notes }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($product)
                <div class="text-center">
                    <h2 class="text-lg font-semibold sm:text-2xl font-bold text-foreground mb-4 sm:mb-6">Informasi Produk Kas Keliling</h2>
                    <div class="bg-card rounded-lg sm:rounded-lg shadow-gray-200/50 border border-border p-4 sm:p-6 md:p-8 max-w-3xl mx-auto">
                        <div class="prose prose-sm sm:prose-base prose-amber max-w-none text-left text-muted-foreground">
                            {!! $product->description ? nl2br(e($product->description)) : '<p>Informasi produk kas keliling belum tersedia.</p>' !!}
                        </div>
                    </div>
                    @if($product->brochure_file)
                        <div class="mt-6 sm:mt-8">
                            <a href="{{ \App\Helpers\StorageHelper::url($product->brochure_file) }}"
                               target="_blank"
                               class="inline-flex items-center justify-center px-6 sm:px-8 py-3 sm:py-4 bg-gradient-to-r from-emerald-600 to-emerald-700 text-white font-bold rounded-lg hover:shadow-md hover:shadow-emerald-500/30 transition-all duration-300 min-h-[48px] touch-manipulation active:scale-95">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                                Download Brosur Kas Keliling
                            </a>
                        </div>
                    @endif
                </div>
            @endif

            @if($schedules->count() === 0)
                <div class="text-center py-16 sm:py-20 bg-card rounded-lg border border-border">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 bg-muted rounded-full flex items-center justify-center mx-auto mb-4 sm:mb-6">
                        <svg class="w-10 h-10 sm:w-12 sm:h-12 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                        </svg>
                    </div>
                    <h3 class="text-base sm:text-lg font-bold text-foreground mb-2">Belum Ada Jadwal</h3>
                    <p class="text-sm sm:text-base text-muted-foreground">Jadwal kas keliling belum tersedia untuk saat ini.</p>
                </div>
            @endif
        </div>
    </section>
</x-frontend-layout>
