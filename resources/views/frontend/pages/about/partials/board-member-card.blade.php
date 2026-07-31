{{-- ═══ BOARD MEMBER CARD — Org Chart edition ═══ --}}
<article class="group w-full max-w-[220px] sm:w-52 lg:w-56 flex flex-col bg-card dark:bg-slate-800/80 rounded-2xl border border-border/80 dark:border-slate-700/70 overflow-hidden
                        shadow-card hover:shadow-2xl hover:shadow-emerald-500/10 hover:-translate-y-2 transition-all duration-500 ease-[cubic-bezier(0.32,0.72,0,1)]
                        hover-shine touch-manipulation">
    {{-- Photo — portrait 3/4 --}}
    <div class="relative aspect-[3/4] overflow-hidden bg-muted dark:bg-slate-800 image-zoom">
        @if($member->photo)
        <x-optimized-image
            src="{{ \App\Helpers\StorageHelper::url($member->photo) }}"
            alt="{{ $member->name }}"
            class="w-full h-full object-cover object-top"
            :lazy="$index >= 3"
            :priority="$index < 3"
            aspect-ratio="3/4"
        />
        @else
        <div class="w-full h-full bg-gradient-to-br from-yellow-50 via-emerald-50 to-emerald-100 dark:from-slate-800 dark:via-slate-800 dark:to-slate-900 flex items-center justify-center">
            <div class="text-center p-4">
                <div class="w-16 h-16 bg-white/80 dark:bg-slate-700/60 rounded-full flex items-center justify-center mx-auto mb-2 text-emerald-600 dark:text-emerald-400 ring-1 ring-emerald-100 dark:ring-slate-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <span class="text-[10px] font-semibold text-emerald-600 dark:text-emerald-400 uppercase tracking-widest">No Photo</span>
            </div>
        </div>
        @endif

        {{-- Gradient overlay on hover --}}
        <div class="absolute inset-0 bg-gradient-to-t from-emerald-950/85 via-emerald-950/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

        {{-- Quick bio on hover --}}
        <div class="absolute inset-x-0 bottom-0 p-4 translate-y-full group-hover:translate-y-0 transition-transform duration-500 ease-[cubic-bezier(0.32,0.72,0,1)]">
            <div class="flex items-center gap-2 text-white/90 text-[10px] font-semibold uppercase tracking-widest mb-1.5">
                <span class="w-6 h-px bg-gold-400"></span>
                Profil Singkat
            </div>
            <p class="text-white/85 text-xs leading-relaxed line-clamp-2">
                {{ Str::limit(strip_tags($member->biography ?? 'Anggota manajemen BPRS Bangka Belitung'), 90) }}
            </p>
        </div>
    </div>

    {{-- Body --}}
    <div class="p-4 sm:p-5 text-center flex flex-col flex-1">
        <h3 class="text-sm sm:text-[15px] font-bold text-foreground dark:text-slate-100 leading-snug mb-2 line-clamp-2
                   group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors duration-300">
            {{ $member->name }}
        </h3>
        <span class="inline-flex items-center justify-center self-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider
                     bg-emerald-50 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300 ring-1 ring-emerald-100 dark:ring-emerald-800/50 mb-3.5">
            {{ $member->position }}
        </span>

        <button
            type="button"
            x-data
            @click="$dispatch('open-modal', { member: @js($member->toArray() + ['photo_url' => \App\Helpers\StorageHelper::url($member->photo)]) })"
            class="mt-auto inline-flex items-center justify-center gap-1.5 w-full min-h-[40px] px-4 py-2 rounded-xl text-xs font-bold
                   bg-black text-white dark:bg-white dark:text-slate-900
                   hover:bg-emerald-600 dark:hover:bg-emerald-500 hover:shadow-lg hover:shadow-emerald-500/25 active:scale-95
                   transition-all duration-300 touch-manipulation"
            aria-label="Lihat profil {{ $member->name }}"
        >
            Selengkapnya
            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
            </svg>
        </button>
    </div>
</article>
