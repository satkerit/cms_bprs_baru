<div>
    {{-- ═══ SEARCH INPUT ═══ --}}
    <div class="relative flex gap-3 items-center">
        <div class="relative flex-1">
            <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text"
                   wire:model.live="ticketNumber"
                   @input="$wire.search()"
                   placeholder="TKT-XXX-XXXXXX"
                   aria-label="Nomor tiket"
                   class="w-full h-12 pl-10 pr-10 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900
                          font-mono text-sm text-foreground dark:text-white placeholder:text-slate-400 placeholder:font-sans
                          focus:outline-none focus:ring-2 focus:ring-emerald-500/25 focus:border-emerald-600 transition-colors">
            @if($ticketNumber)
                <button wire:click="$set('ticketNumber', '')"
                        class="absolute right-3 top-1/2 -translate-y-1/2 p-1 rounded-lg text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700 transition-all bg-transparent border-0 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            @endif
        </div>
    </div>
    <p class="text-xs text-secondary mt-2">Format nomor tiket: <span class="font-mono">TKT-XXX-XXXXXX</span>. Nomor tertera pada email konfirmasi setelah pengiriman.</p>

    {{-- ═══ LOADING ═══ --}}
    @if($loading)
        <div class="mt-6 flex items-center justify-center gap-3 py-8">
            <div class="w-6 h-6 border-2 border-emerald-500 border-t-transparent rounded-full animate-spin"></div>
            <span class="text-sm text-secondary">Mencari tiket...</span>
        </div>
    @endif

    {{-- ═══ ERROR ═══ --}}
    @if($error && !$loading)
        <div class="mt-6 flex items-start gap-3 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700/50 rounded-lg">
            <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <div class="flex-1 min-w-0">
                <p class="font-semibold text-red-700 dark:text-red-400 text-sm">Tiket Tidak Ditemukan</p>
                <p class="text-red-600 dark:text-red-500 text-xs mt-0.5">{{ $error }}</p>
            </div>
            <button wire:click="$set('ticketNumber', '')"
                    class="shrink-0 p-1.5 rounded-lg text-red-400 hover:text-red-600 hover:bg-red-100 dark:hover:bg-red-900/50 transition-all bg-transparent border-0 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    @endif

    {{-- ═══ RESULT ═══ --}}
    @if($result && !$loading && !$error)
        <div class="mt-6 space-y-5">

            {{-- Header tiket — baris dokumen --}}
            <div class="flex items-start justify-between gap-3 flex-wrap border-b border-border dark:border-slate-700 pb-4">
                <div>
                    <p class="font-mono text-[10px] uppercase tracking-[0.25em] text-slate-400 dark:text-slate-500 mb-1">Nomor Tiket</p>
                    <p class="font-mono text-xl sm:text-2xl font-bold text-emerald-700 dark:text-emerald-400 tracking-wider">{{ $result['ticket_number'] ?? $ticketNumber }}</p>
                </div>
                @php
                    $statusColors = [
                        'pending'     => 'bg-amber-50 text-amber-700 border-amber-200 dark:bg-amber-900/20 dark:text-amber-300 dark:border-amber-700/40',
                        'in_review'   => 'bg-blue-50 text-blue-700 border-blue-200 dark:bg-blue-900/20 dark:text-blue-300 dark:border-blue-700/40',
                        'in_progress' => 'bg-violet-50 text-violet-700 border-violet-200 dark:bg-violet-900/20 dark:text-violet-300 dark:border-violet-700/40',
                        'resolved'    => 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-900/20 dark:text-emerald-300 dark:border-emerald-700/40',
                        'closed'      => 'bg-slate-100 text-slate-600 border-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:border-slate-600',
                    ];
                    $statusColor = $statusColors[$result['status']] ?? 'bg-white text-foreground border-border dark:bg-slate-800 dark:text-slate-200 dark:border-slate-600';
                @endphp
                <span class="px-3 py-1.5 rounded-lg text-xs font-bold border {{ $statusColor }}">
                    {{ $statuses[$result['status']] ?? $result['status'] }}
                </span>
            </div>

            @if(isset($result['subject']))
                <p class="text-sm text-foreground dark:text-slate-200 leading-relaxed">{{ $result['subject'] }}</p>
            @endif

            {{-- Progres penanganan --}}
            @php $currentIndex = array_search($result['status'], array_keys($statuses)); @endphp
            <div class="border border-border dark:border-slate-700 p-5">
                <p class="font-mono text-[10px] uppercase tracking-[0.25em] text-slate-400 dark:text-slate-500 mb-4">Progres Penanganan</p>
                <div class="flex items-center">
                    @foreach($statuses as $key => $label)
                        @php
                            $idx       = array_search($key, array_keys($statuses));
                            $isActive  = $idx <= $currentIndex;
                            $isCurrent = $key === $result['status'];
                        @endphp
                        <div class="flex items-center {{ $loop->last ? '' : 'flex-1' }}">
                            <div class="flex flex-col items-center gap-1.5">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold transition-all
                                    {{ $isActive
                                        ? 'bg-emerald-600 text-white shadow-md shadow-emerald-500/25'
                                        : 'bg-slate-100 dark:bg-slate-700 text-slate-400' }}
                                    {{ $isCurrent ? 'ring-4 ring-emerald-500/20 scale-110' : '' }}">
                                    @if($isActive && !$isCurrent)
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    @else
                                        {{ $loop->iteration }}
                                    @endif
                                </div>
                                <span class="text-[10px] font-medium text-center leading-tight w-14
                                    {{ $isCurrent ? 'text-emerald-600 dark:text-emerald-400' : 'text-secondary' }}">
                                    {{ $label }}
                                </span>
                            </div>
                            @if(!$loop->last)
                                <div class="flex-1 h-0.5 mb-5 mx-1 rounded-full {{ $isActive ? 'bg-emerald-500' : 'bg-slate-200 dark:bg-slate-600' }}"></div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Detail — baris definisi --}}
            @if(isset($result['category']) || isset($result['created_at']))
            <dl class="border border-border dark:border-slate-700 divide-y divide-border dark:divide-slate-700">
                @if(isset($result['category']))
                <div class="flex items-baseline justify-between gap-4 px-4 py-3">
                    <dt class="text-xs text-secondary">Kategori</dt>
                    <dd class="text-sm font-semibold text-foreground dark:text-white text-right">{{ $result['category'] }}</dd>
                </div>
                @endif
                @if(isset($result['created_at']))
                <div class="flex items-baseline justify-between gap-4 px-4 py-3">
                    <dt class="text-xs text-secondary">Tanggal Laporan</dt>
                    <dd class="text-sm font-semibold text-foreground dark:text-white text-right">{{ $result['created_at'] }}</dd>
                </div>
                @endif
            </dl>
            @endif

            {{-- Selesai --}}
            @if($result['status'] === 'resolved' || $result['status'] === 'closed')
                <div class="flex items-start gap-3 p-4 bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-700/50 rounded-lg">
                    <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="min-w-0">
                        <p class="text-xs text-emerald-600 dark:text-emerald-400 font-semibold">Pengaduan Selesai</p>
                        @if(isset($result['resolved_at']))
                            <p class="text-sm font-bold text-emerald-700 dark:text-emerald-300 mt-0.5">{{ $result['resolved_at'] }}</p>
                        @endif
                        @if(isset($result['resolution']))
                            <p class="text-xs text-emerald-600 dark:text-emerald-500 mt-1 leading-relaxed">{{ $result['resolution'] }}</p>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Timeline --}}
            @if(count($result['timeline'] ?? []) > 0)
                <div class="border border-border dark:border-slate-700 p-5">
                    <p class="font-mono text-[10px] uppercase tracking-[0.25em] text-slate-400 dark:text-slate-500 mb-4">Riwayat Penanganan</p>
                    <div class="space-y-0">
                        @foreach($result['timeline'] as $event)
                            <div class="flex gap-3">
                                <div class="flex flex-col items-center">
                                    <div class="w-3 h-3 rounded-full mt-0.5 shrink-0 {{ $loop->first ? 'bg-emerald-500' : 'bg-slate-300 dark:bg-slate-600' }}"></div>
                                    @if(!$loop->last)
                                        <div class="w-px flex-1 bg-slate-200 dark:bg-slate-700 my-1"></div>
                                    @endif
                                </div>
                                <div class="pb-4 flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-foreground dark:text-white">{{ $event['title'] }}</p>
                                    @if(!empty($event['description']))
                                        <p class="text-xs text-secondary mt-0.5 leading-relaxed">{{ $event['description'] }}</p>
                                    @endif
                                    @if(!empty($event['date']))
                                        <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">{{ $event['date'] }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Reset --}}
            <button wire:click="$set('ticketNumber', '')"
                    class="w-full flex items-center justify-center gap-2 py-2.5 rounded-lg text-sm font-semibold
                           text-secondary hover:text-foreground dark:hover:text-white
                           bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700
                           border-0 cursor-pointer transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                Cari Tiket Lain
            </button>
        </div>
    @endif
</div>
