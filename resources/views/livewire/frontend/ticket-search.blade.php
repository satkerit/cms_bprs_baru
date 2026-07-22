<div>
    <!-- Header with Emblem -->
    <div class="text-center mb-8">
        <div class="w-20 h-20 mx-auto mb-6">
            <div class="w-full h-full bg-gradient-to-r from-emerald-600 to-emerald-700 rounded-full flex items-center justify-center">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
        </div>
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Cek Status Tiket</h2>
        <p class="text-gray-500 text-sm mx-auto">Masukkan nomor tiket Anda untuk melacak status penanganan laporan</p>
    </div>

    <!-- Search Form -->
    <div class="max-w-xl mx-auto mb-12">
        <div class="relative">
            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" wire:model.live="ticketNumber" class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-600 pl-10"
                placeholder="Masukkan nomor tiket Anda (cth: TKT-XXX-XXXXXX)"
                @input="$wire.search()">
            @if($ticketNumber)
            <button wire:click="$set('ticketNumber', '')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 bg-transparent border-0 cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            @endif
        </div>
        <p class="text-xs text-gray-500 mt-2">Ketik nomor tiket untuk langsung mencari</p>
    </div>

    <!-- Loading State -->
    @if($loading)
        <div class="text-center py-12">
            <div class="w-12 h-12 border-4 border-emerald-600 border-t-transparent rounded-full animate-spin mx-auto mb-4"></div>
            <p class="text-gray-500">Mencari tiket...</p>
        </div>
    @endif

    <!-- Error State -->
    @if($error)
        <div class="text-center py-12">
            <div class="w-20 h-20 mx-auto mb-6">
                <div class="w-full h-full bg-red-50 rounded-full flex items-center justify-center">
                    <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
            </div>
            <h4 class="text-lg font-bold text-red-600 mb-2">Tiket Tidak Ditemukan</h4>
            <p class="text-red-500 text-sm mb-6">{{ $error }}</p>
            <button wire:click="$set('ticketNumber', '')" class="text-gray-500 bg-gray-100 border-0 px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-gray-200 transition-colors cursor-pointer">
                <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                Coba Lagi
            </button>
        </div>
    @endif

    <!-- Result Found -->
    @if($result && !$loading && !$error)
        <div class="max-w-2xl mx-auto">
            <!-- Status Progress -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    @php $currentIndex = array_search($result['status'], array_keys($statuses)); @endphp
                    @foreach($statuses as $key => $label)
                        @php
                            $isActive = array_search($key, array_keys($statuses)) <= $currentIndex;
                            $isCurrent = $key === $result['status'];
                        @endphp
                        <div class="flex flex-col items-center {{ $loop->last ? '' : 'flex-1' }}">
                            <div class="flex items-center w-full">
                                <div class="w-8 h-8 flex items-center justify-center rounded-full {{ $isActive ? 'bg-emerald-600 text-white' : 'bg-gray-200 text-gray-400' }} {{ $isCurrent ? 'ring-4 ring-emerald-500/25' : '' }}">
                                    @if($isActive && !$isCurrent)
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    @else
                                        <span class="text-xs font-bold">{{ $loop->iteration }}</span>
                                    @endif
                                </div>
                                @if(!$loop->last)
                                    <div class="flex-1 h-1 mx-2 rounded-full max-w-[60px] {{ $index < $currentIndex ? 'bg-emerald-600' : 'bg-gray-200' }}"></div>
                                @endif
                            </div>
                            <span class="text-xs mt-2 {{ $isActive ? 'text-emerald-600 font-medium' : 'text-gray-500' }}">{{ $label }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Ticket Info Card -->
            <div class="bg-white border border-gray-200 rounded-xl p-6 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Nomor Tiket</p>
                        <p class="font-bold text-gray-900 font-mono text-lg">{{ $result['ticket_number'] }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Status</p>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                            @switch($result['status'])
                                @case('pending')
                                    bg-yellow-50 text-yellow-700
                                    @break
                                @case('in_review')
                                    bg-blue-50 text-blue-700
                                    @break
                                @case('in_progress')
                                    bg-purple-50 text-purple-700
                                    @break
                                @case('resolved')
                                    bg-emerald-50 text-emerald-600
                                    @break
                                @case('closed')
                                    bg-gray-50 text-gray-700
                                    @break
                                @default
                                    bg-gray-50 text-gray-700
                            @endswitch
                        ">
                            {{ $result['status_label'] ?? $statuses[$result['status']] ?? 'Unknown' }}
                        </span>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Tanggal Dibuat</p>
                        <p class="font-semibold text-gray-900">{{ $result['created_at'] }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Kategori</p>
                        <p class="font-semibold text-gray-900">{{ $result['category'] ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Subject Card -->
            <div class="bg-white border border-gray-200 rounded-xl p-6 mb-6">
                <p class="text-xs text-gray-500 mb-1">Subjek Laporan</p>
                <p class="font-semibold text-gray-900">{{ $result['subject'] }}</p>
            </div>

            <!-- Resolved Info (if resolved) -->
            @if($result['status'] === 'resolved' || $result['status'] === 'closed')
                <div class="p-4 bg-emerald-50 rounded-lg border border-emerald-100 mb-6">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-emerald-50 flex items-center justify-center rounded-full shrink-0">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-emerald-600 text-xs">Resolusi</p>
                            <p class="text-emerald-600 mt-1">{{ $result['resolution'] }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Timeline -->
            @if(count($result['timeline'] ?? []) > 0)
                <div class="bg-white border border-gray-200 rounded-xl p-6 mb-6">
                    <h4 class="font-bold text-gray-900 mb-4">Riwayat Penanganan</h4>
                    <div class="space-y-4">
                        @foreach($result['timeline'] as $event)
                            <div class="flex gap-4">
                                <div class="relative flex flex-col items-center">
                                    <div class="w-3 h-3 rounded-full {{ $loop->first ? 'bg-emerald-500' : 'bg-gray-300' }}"></div>
                                    @if(!$loop->last)
                                        <div class="w-0.5 flex-1 bg-gray-200 mt-1"></div>
                                    @endif
                                </div>
                                <div class="flex-1 pb-4">
                                    <p class="font-semibold text-gray-900 text-sm">{{ $event['title'] }}</p>
                                    <p class="text-xs text-gray-500 mt-0.5">{{ $event['description'] ?? '' }}</p>
                                    <p class="text-xs text-gray-400 mt-1">{{ $event['date'] ?? '' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Resolved Info Card (alternative layout) -->
            @if($result['status'] === 'resolved' || $result['status'] === 'closed')
                <div class="flex items-center gap-3 p-4 bg-emerald-50 rounded-lg mb-6">
                    <div class="w-10 h-10 bg-emerald-50 flex items-center justify-center rounded-full">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Tanggal Selesai</p>
                        <p class="font-semibold text-emerald-600">{{ $result['resolved_at'] }}</p>
                    </div>
                </div>
            @endif

            <!-- CTA -->
            <div class="text-center">
                <p class="text-xs text-gray-500 mb-4">Ada pertanyaan lebih lanjut? Hubungi kami</p>
                <div class="flex justify-center gap-3">
                    <a href="tel:{{ config('app.support_phone', '+621234567890') }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 transition-colors">
                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        Hubungi Kami
                    </a>
                    <a href="mailto:{{ config('app.support_email', 'support@example.com') }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 transition-colors">
                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        Email
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
