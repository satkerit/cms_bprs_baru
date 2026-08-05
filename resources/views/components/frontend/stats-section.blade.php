@props(['companyInfo'])

<!-- Stats Section -->
@php
    $hasStats = $companyInfo && (
        ($companyInfo->stat_years_experience && $companyInfo->stat_years_experience > 0) ||
        ($companyInfo->stat_branch_offices && $companyInfo->stat_branch_offices > 0) ||
        ($companyInfo->stat_total_assets && $companyInfo->stat_total_assets !== 'N/A') ||
        ($companyInfo->stat_cash_offices && $companyInfo->stat_cash_offices > 0) ||
        ($companyInfo->stat_mobile_cash_offices && $companyInfo->stat_mobile_cash_offices > 0)
    );
@endphp
@if($hasStats)
<div class="overflow-hidden relative py-6">
    <!-- Subtle background -->
    <div class="absolute inset-0 pointer-events-none" aria-hidden="true">
        <div class="absolute top-0 left-1/4 w-64 h-64 rounded-full bg-emerald-50 blur-[72px]"></div>
        <div class="absolute bottom-0 right-1/4 w-64 h-64 rounded-full bg-emerald-50 blur-[72px]"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap justify-center items-start gap-8 md:gap-16 max-w-4xl mx-auto">
            <!-- Tahun Pengalaman -->
            @if($companyInfo->stat_years_experience && $companyInfo->stat_years_experience > 0)
            <div class="text-center stats-card fade-in-section min-w-[140px]"
                 x-intersect="$el.classList.add('is-visible')">
                <div class="w-12 h-12 rounded flex items-center justify-center mx-auto mb-3 bg-emerald-50 text-emerald-600 border border-emerald-200">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="text-3xl font-bold text-foreground mb-1 tracking-tight">
                    <span x-data="statsCounter"
                          data-target="{{ $companyInfo->stat_years_experience }}"
                          data-suffix="+"
                          x-text="value + suffix">0+</span>
                </div>
                <p class="text-xs font-semibold text-secondary uppercase tracking-wider">Tahun Pengalaman</p>
            </div>
            @endif

            <!-- Kantor Cabang -->
            @if($companyInfo->stat_branch_offices && $companyInfo->stat_branch_offices > 0)
            <div class="text-center stats-card fade-in-section min-w-[140px]"
                 x-intersect="$el.classList.add('is-visible')">
                <div class="w-12 h-12 rounded flex items-center justify-center mx-auto mb-3 bg-emerald-50 text-emerald-600 border border-emerald-200">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <div class="text-3xl font-bold text-foreground mb-1 tracking-tight">
                    <span x-data="statsCounter"
                          data-target="{{ $companyInfo->stat_branch_offices }}"
                          data-suffix=""
                          x-text="value + suffix">0</span>
                </div>
                <p class="text-xs font-semibold text-secondary uppercase tracking-wider">Kantor Cabang</p>
            </div>
            @endif

            <!-- Total Aset -->
            @if($companyInfo->stat_total_assets && $companyInfo->stat_total_assets !== 'N/A')
            <div class="text-center stats-card fade-in-section min-w-[140px]"
                 x-intersect="$el.classList.add('is-visible')">
                <div class="w-12 h-12 rounded flex items-center justify-center mx-auto mb-3 bg-emerald-50 text-emerald-600 border border-emerald-200">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="text-3xl font-bold text-foreground mb-1 tracking-tight">{{ $companyInfo->stat_total_assets }}</div>
                <p class="text-xs font-semibold text-secondary uppercase tracking-wider">Total Aset</p>
            </div>
            @endif

            <!-- Kantor Kas -->
            @if($companyInfo->stat_cash_offices && $companyInfo->stat_cash_offices > 0)
            <div class="text-center stats-card fade-in-section min-w-[140px]"
                 x-intersect="$el.classList.add('is-visible')">
                <div class="w-12 h-12 rounded flex items-center justify-center mx-auto mb-3 bg-emerald-50 text-emerald-600 border border-emerald-200">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                    </svg>
                </div>
                <div class="text-3xl font-bold text-foreground mb-1 tracking-tight">
                    <span x-data="statsCounter"
                          data-target="{{ $companyInfo->stat_cash_offices }}"
                          data-suffix=""
                          x-text="value + suffix">0</span>
                </div>
                <p class="text-xs font-semibold text-secondary uppercase tracking-wider">Kantor Kas</p>
            </div>
            @endif

            <!-- Kantor Kas Keliling -->
            @if($companyInfo->stat_mobile_cash_offices && $companyInfo->stat_mobile_cash_offices > 0)
            <div class="text-center stats-card fade-in-section min-w-[140px]"
                 x-intersect="$el.classList.add('is-visible')">
                <div class="w-12 h-12 rounded flex items-center justify-center mx-auto mb-3 bg-emerald-50 text-emerald-600 border border-emerald-200">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                    </svg>
                </div>
                <div class="text-3xl font-bold text-foreground mb-1 tracking-tight">
                    <span x-data="statsCounter"
                          data-target="{{ $companyInfo->stat_mobile_cash_offices }}"
                          data-suffix=""
                          x-text="value + suffix">0</span>
                </div>
                <p class="text-xs font-semibold text-secondary uppercase tracking-wider">Kas Keliling</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endif
