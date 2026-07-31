{{-- ═══ BOARD MEMBER CARD — Premium Edition ═══ --}}
<article class="group relative w-36 sm:w-40 md:w-44 lg:w-48 flex-shrink-0 flex flex-col rounded-2xl overflow-hidden
                shadow-md hover:shadow-xl hover:shadow-emerald-500/20 hover:-translate-y-1.5
                transition-all duration-500 ease-[cubic-bezier(0.32,0.72,0,1)] touch-manipulation cursor-pointer"
         x-data
         @click="$dispatch('open-modal', { member: @js($member->toArray() + ['photo_url' => \App\Helpers\StorageHelper::url($member->photo)]) })">

    {{-- Photo area — square with overlay --}}
    <div class="relative aspect-[3/4] overflow-hidden rounded-2xl ring-2 ring-emerald-500/30 group-hover:ring-emerald-500/70 transition-all duration-500">

        {{-- Background gradient (fallback / base) --}}
        <div class="absolute inset-0 bg-gradient-to-br from-emerald-800 via-emerald-700 to-emerald-900"></div>

        {{-- Pattern decoration --}}
        <div class="absolute inset-0 opacity-10"
             style="background-image: radial-gradient(circle at 20% 20%, white 1px, transparent 1px), radial-gradient(circle at 80% 80%, white 1px, transparent 1px); background-size: 24px 24px;"></div>

        {{-- Photo --}}
        @if($member->photo)
        <div class="absolute inset-0">
            <x-optimized-image
                src="{{ \App\Helpers\StorageHelper::url($member->photo) }}"
                alt="{{ $member->name }}"
                class="w-full h-full object-cover object-top scale-100 group-hover:scale-105
                       transition-transform duration-700 ease-[cubic-bezier(0.32,0.72,0,1)]
                       group-hover:brightness-110 group-hover:contrast-105"
                :lazy="$index >= 3"
                :priority="$index < 3"
                aspect-ratio="3/4"
            />
        </div>
        @else
        {{-- Placeholder avatar --}}
        <div class="absolute inset-0 flex items-end justify-center pb-8">
            <div class="w-28 h-28 rounded-full bg-white/20 backdrop-blur-sm ring-4 ring-white/30 flex items-center justify-center">
                <svg class="w-14 h-14 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
        </div>
        @endif

        {{-- Permanent gradient overlay (bottom) --}}
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>

        {{-- Hover overlay (top tint) --}}
        <div class="absolute inset-0 bg-emerald-600/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

        {{-- Name + position — always visible at bottom --}}
        <div class="absolute inset-x-0 bottom-0 p-5">
            {{-- Position badge --}}
            <div class="mb-2">
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider
                             bg-emerald-500/90 backdrop-blur-sm text-white shadow-sm">
                    {{ $member->position }}
                </span>
            </div>

            {{-- Name --}}
            <h3 class="text-base font-bold text-white leading-snug line-clamp-2 group-hover:text-emerald-200 transition-colors duration-300">
                {{ $member->name }}
            </h3>

            {{-- Bio teaser — slides up on hover --}}
            <div class="overflow-hidden max-h-0 group-hover:max-h-16 transition-all duration-500 ease-[cubic-bezier(0.32,0.72,0,1)]">
                <p class="text-white/75 text-xs leading-relaxed mt-1.5 line-clamp-2">
                    {{ Str::limit(strip_tags($member->biography ?? 'Anggota manajemen BPRS Bangka Belitung'), 80) }}
                </p>
            </div>
        </div>

        {{-- "Lihat Profil" CTA — slides in on hover --}}
        <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 translate-x-2 group-hover:translate-x-0 transition-all duration-400">
            <div class="w-9 h-9 rounded-full bg-white/95 backdrop-blur-sm flex items-center justify-center shadow-lg">
                <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                </svg>
            </div>
        </div>
    </div>
</article>
