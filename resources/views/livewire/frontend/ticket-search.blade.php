<div>
    {{-- ═══ HEADER ═══ --}}
    <div class="mb-6">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-xl flex items-center justify-center shrink-0 shadow-md shadow-emerald-500/20">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-lg font-bold text-foreground dark:text-white leading-tight">Lacak Status Pengaduan</h2>
                <p class="text-sm text-secondary mt-0.5">Masukkan nomor tiket yang Anda terima setelah mendaftar</p>
            </div>
        </div>
    </div>

    {{-- ═══ SEARCH INPUT ═══ --}}
    <div class="relative flex gap-3 items-center">
        <div class="relative flex-1">
            <svg class="w-5 h-5 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text"
                   wire:model.live="ticketNumber"
                   @input="$wire.search()"
                   placeholder="cth: TKT-ABC-123456"
                   class="w-full h-12 pl-12 pr-10 rounded-xl border border-border dark:border-slate-600 bg-white dark:bg-slate-800
                          text-sm text-foreground dark:text-white placeholder:text-slate-400
                          focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all">
            @if($ticketNumber)
                <button wire:click="$set('ticketNumber', '')"
                        class="absolute right-3 top-1/2 -translate-y-1/2 p-1 rounded-lg text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700 transition-all bg-transparent border-0 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            @endif
        </div>
    </div>
    <p class="text-xs text-secondary mt-2">Format: TKT-XXX-XXXXXX</p>

    {{-- ═══ LOADING ═══ --}}
    @if($loading)
        <div class="mt-6 flex items-center justify-center gap-3 py-8">
            <div class="w-6 h-6 border-2 border-emerald-500 border-t-transparent rounded-full animate-spin"></div>
            <span class="text-sm text-secondary">Mencari tiket...</span>
        </div>
    @endif

    {{-- ═══ ERROR ═══ --}}
    @if($error && !$loading)
        <div class="mt-6 flex items-start gap-3 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700/50 rounded-2xl">
            <div class="w-9 h-9 bg-red-100 dark:bg-red-900/50 rounded-xl flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
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
        <div class="mt-6 space-y-4">

            {{-- Tiket header --}}
            <div class="rounded-2xl bg-gradient-to-br from-emerald-600 to-emerald-700 p-5 text-white shadow-lg shadow-emerald-500/20">
                <div class="flex items-start justify-between gap-3 flex-wrap">
                    <div>
                        <p class="text-emerald-200 text-xs font-semibold uppercase tracking-wider mb-1">Nomor Tiket</p>
                        <p class="font-black text-xl tracking-wider font-mono">{{ $result['ticket_number'] ?? $ticketNumber }}</p>
                    </div>
                    @php
                        $statusColors = [
                            'pending'     => 'bg-amber-400/20 text-amber-200 border-amber-400/30',
                            'in_review'   => 'bg-blue-400/20 text-blue-200 border-blue-400/30',
                            'in_progress' => 'bg-violet-400/20 text-violet-200 border-violet-400/30',
                            'resolved'    => 'bg-emerald-400/20 text-emerald-100 border-emerald-400/30',
                            'closed'      => 'bg-slate-400/20 text-slate-200 border-slate-400/30',
                        ];
                        $statusColor = $statusColors[$result['status']] ?? 'bg-white/20 text-white border-white/20';
                    @endphp
                    <span class="px-3 py-1.5 rounded-xl text-xs font-bold border {{ $statusColor }}">
                        {{ $statuses[$result['status']] ?? $result['status'] }}
                    </span>
                </div>
                @if(isset($result['subject']))
                    <p class="mt-3 text-emerald-100 text-sm leading-relaxed border-t border-white/10 pt-3">{{ $result['subject'] }}</p>
                @endif
            </div>

            {{-- Progress steps --}}
            @php $currentIndex = array_search($result['status'], array_keys($statuses)); @endphp
            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-border dark:border-slate-700 p-5">
                <p class="text-xs font-semibold text-secondary uppercase tracking-wider mb-4">Progres Penanganan</p>
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

            {{-- Detail info --}}
            <div class="grid grid-cols-2 gap-3">
                @if(isset($result['category']))
                    <div class="bg-slate-50 dark:bg-slate-800/60 rounded-xl p-4 border border-border dark:border-slate-700">
                        <p class="text-xs text-secondary mb-1">Kategori</p>
                        <p class="text-sm font-semibold text-foreground dark:text-white">{{ $result['category'] }}</p>
                    </div>
                @endif
                @if(isset($result['created_at']))
                    <div class="bg-slate-50 dark:bg-slate-800/60 rounded-xl p-4 border border-border dark:border-slate-700">
                        <p class="text-xs text-secondary mb-1">Tanggal Laporan</p>
                        <p class="text-sm font-semibold text-foreground dark:text-white">{{ $result['created_at'] }}</p>
                    </div>
                @endif
            </div>

            {{-- Resolved --}}
            @if($result['status'] === 'resolved' || $result['status'] === 'closed')
                <div class="flex items-center gap-3 p-4 bg-emerald-50 dark:bg-emerald-900/30 rounded-xl border border-emerald-200 dark:border-emerald-700/50">
                    <div class="w-9 h-9 bg-emerald-100 dark:bg-emerald-900/50 rounded-xl flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
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
                <div class="bg-white dark:bg-slate-800 rounded-2xl border border-border dark:border-slate-700 p-5">
                    <p class="text-xs font-semibold text-secondary uppercase tracking-wider mb-4">Riwayat Penanganan</p>
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

            {{-- Reset button --}}
            <button wire:click="$set('ticketNumber', '')"
                    class="w-full flex items-center justify-center gap-2 py-2.5 rounded-xl text-sm font-semibold
                           text-secondary hover:text-foreground dark:hover:text-white
                           bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700
                           border-0 cursor-pointer transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                Cari Tiket Lain
            </button>
        </div>
    @endif
</div>
