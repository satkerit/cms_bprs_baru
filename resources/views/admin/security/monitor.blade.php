@extends('admin.layouts.app')

@section('title', 'Security Monitoring')

@section('content')
 <div class="space-y-6">
 {{-- Header --}}
 <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
 <div>
 <h1 class="text-5xl font-bold text-gray-900 flex items-center gap-2">
 <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-red-600" fill="none" viewBox="0 0 24 24"
 stroke="currentColor">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
 d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
 </svg>
 Security Monitoring
 </h1>
 <p class="mt-1 text-xs text-gray-500">
 Pantau dan kelola percobaan serangan terhadap sistem
 </p>
 </div>
 <div class="flex gap-2">
 <a href="{{ route('admin.security-monitor.export') }}?days=7"
 class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-xs font-medium rounded-lg">
 <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
 stroke="currentColor">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
 d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
 </svg>
 Export CSV
 </a>
 <button data-action="open-block-modal"
 class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-xs font-medium rounded-lg">
 <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
 stroke="currentColor">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
 d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
 </svg>
 Blokir IP
 </button>
 </div>
 </div>

 {{-- Real-time Stats Cards --}}
 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
 {{-- Threats Today --}}
 <div class="bg-white rounded-lg border p-6">
 <div class="flex items-center justify-between">
 <div>
 <p class="text-xs font-medium text-gray-500">Ancaman Hari Ini</p>
 <p class="text-4xl font-bold text-red-600 mt-1">
 {{ $realTimeStats['threats_today'] }}</p>
 </div>
 <div class="p-3 bg-red-100 rounded-full">
 <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none"
 viewBox="0 0 24 24" stroke="currentColor">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
 d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
 </svg>
 </div>
 </div>
 </div>

 {{-- Blocked Today --}}
 <div class="bg-white rounded-lg border p-6">
 <div class="flex items-center justify-between">
 <div>
 <p class="text-xs font-medium text-gray-500">IP Diblokir Hari Ini</p>
 <p class="text-4xl font-bold text-amber-600 mt-1">
 {{ $realTimeStats['blocked_today'] }}</p>
 </div>
 <div class="p-3 bg-amber-100 rounded-full">
 <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-600"
 fill="none" viewBox="0 0 24 24" stroke="currentColor">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
 d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
 </svg>
 </div>
 </div>
 </div>

 {{-- Active Blocks --}}
 <div class="bg-white rounded-lg border p-6">
 <div class="flex items-center justify-between">
 <div>
 <p class="text-xs font-medium text-gray-500">Blokir Aktif</p>
 <p class="text-4xl font-bold text-yellow-600 mt-1">
 {{ $realTimeStats['active_blocks'] }}</p>
 </div>
 <div class="p-3 bg-amber-100 rounded-full">
 <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600"
 fill="none" viewBox="0 0 24 24" stroke="currentColor">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
 d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
 </svg>
 </div>
 </div>
 </div>

 {{-- Total 7 Days --}}
 <div class="bg-white rounded-lg border p-6">
 <div class="flex items-center justify-between">
 <div>
 <p class="text-xs font-medium text-gray-500">Total 7 Hari</p>
 <p class="text-4xl font-bold text-sky-600 mt-1">{{ $stats['total'] }}</p>
 </div>
 <div class="p-3 bg-sky-100 rounded-full">
 <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-sky-600" fill="none"
 viewBox="0 0 24 24" stroke="currentColor">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
 d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
 </svg>
 </div>
 </div>
 </div>
 </div>

 {{-- Charts Row --}}
 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
 {{-- Threats by Type --}}
 <div class="bg-white rounded-lg border p-6">
 <h3 class="text-3xl font-semibold text-gray-900 mb-4">Ancaman Berdasarkan Tipe</h3>
 <div class="space-y-3">
 @forelse($stats['by_type'] as $type => $count)
 @php
 $typeInfo = \App\Models\SecurityLog::THREAT_TYPES[$type] ?? ['label' => $type, 'level' => 'medium'];
 $percentage = $stats['total'] > 0 ? round(($count / $stats['total']) * 100) : 0;
 @endphp
 <div>
 <div class="flex justify-between text-xs mb-1">
 <span class="text-gray-900">{{ $typeInfo['label'] }}</span>
 <span class="font-medium text-gray-900">{{ $count }}</span>
 </div>
 <div class="w-full bg-gray-200 rounded-full h-2.5">
 <div class="h-2.5 rounded-full {{ match ($typeInfo['level']) { 'critical' => 'bg-red-600', 'high' => 'bg-amber-1000', 'medium' => 'bg-amber-1000', default => 'bg-sky-500' } }}" style="width: {{ $percentage }}%"></div>
 </div>
 </div>
 @empty
 <p class="text-gray-500 text-center py-4">Tidak ada data ancaman</p>
 @endforelse
 </div>
 </div>

 {{-- Top Attacking IPs --}}
 <div class="bg-white rounded-lg border p-6">
 <h3 class="text-3xl font-semibold text-gray-900 mb-4">Top 10 IP Penyerang</h3>
 <div class="space-y-2">
 @forelse($stats['top_ips'] as $ip => $count)
 <div class="flex items-center justify-between p-2 bg-gray-50 rounded-lg">
 <div class="flex items-center gap-2">
 <code class="text-xs font-mono text-gray-900">{{ $ip }}</code>
 @if(\App\Models\BlockedIp::isBlocked($ip))
 <span
 class="px-2 py-0.5 text-xs bg-red-100 text-red-600 rounded-full">Diblokir</span>
 @endif
 </div>
 <div class="flex items-center gap-2">
 <span class="text-xs font-bold text-gray-900">{{ $count }}x</span>
 <button data-action="view-ip-threats" data-ip="{{ $ip }}"
 class="p-1 text-gray-500"
 title="Lihat Detail">
 <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
 stroke="currentColor">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
 d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
 d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
 </svg>
 </button>
 </div>
 </div>
 @empty
 <p class="text-gray-500 text-center py-4">Tidak ada data IP</p>
 @endforelse
 </div>
 </div>
 </div>

 {{-- Currently Blocked IPs --}}
 @if($blockedIps->count() > 0)
 <div class="bg-white rounded-lg border p-6">
 <div class="flex items-center justify-between mb-4">
 <h3 class="text-3xl font-semibold text-gray-900">IP yang Sedang Diblokir</h3>
 <button data-action="clear-expired-blocks"
 class="text-xs text-sky-600">
 Hapus Blokir Kadaluarsa
 </button>
 </div>                <div class="overflow-x-auto">                        <table class="w-full">
                        <thead class="bg-zinc-50/80">
                            <tr>
                                <th class="px-4 py-3.5 text-left text-[11px] font-semibold text-zinc-600 uppercase tracking-wider">
                                    IP Address</th>
                                <th class="px-4 py-3.5 text-left text-[11px] font-semibold text-zinc-600 uppercase tracking-wider">
                                    Alasan</th>
                                <th class="px-4 py-3.5 text-left text-[11px] font-semibold text-zinc-600 uppercase tracking-wider">
                                    Status</th>
                                <th class="px-4 py-3.5 text-left text-[11px] font-semibold text-zinc-600 uppercase tracking-wider">
                                    Berakhir</th>
                                <th class="px-4 py-3.5 text-left text-[11px] font-semibold text-zinc-600 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100/80">
                            @foreach($blockedIps as $blocked)
                            <tr class="table-row-hover">
                                <td class="table-cell-text">
                                    <code class="text-[13px] font-mono text-zinc-900">{{ $blocked->ip_address }}</code>
                                </td>
                                <td class="table-cell-text text-zinc-500">
                                    {{ $blocked->reason }}
                                </td>
                                <td class="table-cell-text">
                                    @if($blocked->is_permanent)
                                    <span class="px-2.5 py-1 text-[11px] font-medium bg-red-50 text-red-700 rounded-lg">Permanen</span>
                                    @else
                                    <span class="px-2.5 py-1 text-[11px] font-medium bg-amber-50 text-amber-700 rounded-lg">Sementara</span>
                                    @endif
                                </td>
                                <td class="table-cell-text text-zinc-500">
                                    {{ $blocked->is_permanent ? 'Selamanya' : ($blocked->blocked_until ? $blocked->blocked_until->diffForHumans() : '-') }}
                                </td>
                                <td class="table-cell-text">
                                    <button data-action="unblock-ip" data-ip="{{ $blocked->ip_address }}"
                                        class="table-action-btn text-green-600 hover:text-green-700 hover:bg-green-50">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
 </div>
 @endif

 {{-- Recent Threats Table --}}
 <div class="bg-white rounded-lg border">
 <div class="p-6 border-b">
 <h3 class="text-3xl font-semibold text-gray-900">Log Ancaman Terbaru</h3>
 </div>            <div class="overflow-x-auto">                    <table class="w-full">
                    <thead class="bg-zinc-50/80">
                        <tr>
                            <th class="px-4 py-3.5 text-left text-[11px] font-semibold text-zinc-600 uppercase tracking-wider">
                                Waktu</th>
                            <th class="px-4 py-3.5 text-left text-[11px] font-semibold text-zinc-600 uppercase tracking-wider">
                                IP Address</th>
                            <th class="px-4 py-3.5 text-left text-[11px] font-semibold text-zinc-600 uppercase tracking-wider">
                                Tipe Ancaman</th>
                            <th class="px-4 py-3.5 text-left text-[11px] font-semibold text-zinc-600 uppercase tracking-wider">
                                Level</th>
                            <th class="px-4 py-3.5 text-left text-[11px] font-semibold text-zinc-600 uppercase tracking-wider">
                                URL</th>
                            <th class="px-4 py-3.5 text-left text-[11px] font-semibold text-zinc-600 uppercase tracking-wider">
                                Status</th>
                            <th class="px-4 py-3.5 text-left text-[11px] font-semibold text-zinc-600 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100/80">
                        @forelse($threats as $threat)
                        <tr class="table-row-hover">
                            <td class="table-cell-text text-zinc-500">
                                {{ $threat->created_at->format('d/m/Y H:i:s') }}
                            </td>
                            <td class="table-cell-text">
                                <code class="text-[13px] font-mono text-zinc-900">{{ $threat->ip_address }}</code>
                            </td>
                            <td class="table-cell-text">
                                <span class="font-medium text-zinc-900">{{ $threat->getThreatInfo()['label'] }}</span>
                            </td>
                            <td class="table-cell-text">
                                <span class="inline-flex items-center px-2.5 py-1 text-[11px] font-medium rounded-lg {{ $threat->getThreatBadgeClass() }}">
                                    {{ \App\Models\SecurityLog::THREAT_LEVELS[$threat->threat_level]['label'] ?? $threat->threat_level }}
                                </span>
                            </td>
                            <td class="table-cell-text text-zinc-500" title="{{ $threat->request_url }}">
                                {{ Str::limit($threat->request_url, 50) }}
                            </td>
                            <td class="table-cell-text">
                                @if($threat->was_blocked)
                                <span class="inline-flex items-center px-2.5 py-1 text-[11px] font-medium bg-red-50 text-red-700 rounded-lg">Diblokir</span>
                                @else
                                <span class="inline-flex items-center px-2.5 py-1 text-[11px] font-medium bg-zinc-50 text-zinc-500 rounded-lg">Tercatat</span>
                                @endif
                            </td>
                            <td class="table-cell-text">
                                <a href="{{ route('admin.security-monitor.show', $threat) }}"
                                    class="table-action-btn text-sky-600 hover:text-sky-700 hover:bg-sky-50">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-zinc-900">Sistem Aman!</p>
                                        <p class="text-[13px] text-zinc-500 mt-1">Tidak ada ancaman yang terdeteksi.</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

 @if($threats->hasPages())
 <div class="p-4 border-t">
 {{ $threats->links() }}
 </div>
 @endif
 </div>
 </div>

 {{-- Block IP Modal --}}
 <div id="blockIpModal" class="hidden">
 <div class="flex items-center justify-center px-4">
 <div class="fixed bg-black" data-action="close-block-modal"></div>
 <div class="bg-white rounded-lg max-w-md w-full p-6">
 <h3 class="text-3xl font-semibold text-gray-900 mb-4">Blokir IP Address</h3>
 <form id="blockIpForm" data-action="submit-block-ip">
 <div class="space-y-4">
 <div>
 <label class="block text-xs font-medium text-gray-900 mb-1">IP
 Address</label>
 <input type="text" name="ip_address" required
 class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-white text-gray-900"
 placeholder="192.168.1.1">
 </div>
 <div>
 <label class="block text-xs font-medium text-gray-900 mb-1">Alasan</label>
 <input type="text" name="reason"
 class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-white text-gray-900"
 placeholder="Alasan pemblokiran">
 </div>
 <div>
 <label class="block text-xs font-medium text-gray-900 mb-1">Durasi
 (jam)</label>
 <input type="number" name="duration" value="24" min="1" max="8760"
 class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-white text-gray-900">
 </div>
 <div class="flex items-center">
 <input type="checkbox" name="permanent" id="permanent"
 class="rounded border-gray-300 bg-white text-sky-600 h-4 w-4">
 <label for="permanent" class="ml-2 text-xs text-gray-900">Blokir
 Permanen</label>
 </div>
 </div>
 <div class="mt-6 flex justify-end gap-3">
 <button type="button" data-action="close-block-modal"
 class="px-4 py-2 text-xs font-medium text-gray-500 rounded-lg">
 Batal
 </button>
 <button type="submit"
 class="px-4 py-2 text-xs font-medium text-white bg-red-600 rounded-lg">
 Blokir
 </button>
 </div>
 </form>
 </div>
 </div>
 </div>

 @push('scripts')
 <script nonce="{{ $nonce }}">
 document.addEventListener('DOMContentLoaded', function() {
 document.querySelectorAll('[data-action="open-block-modal"]').forEach(function(btn) {
 btn.addEventListener('click', function() {
 document.getElementById('blockIpModal').classList.remove('hidden');
 });
 });

 document.querySelectorAll('[data-action="close-block-modal"]').forEach(function(btn) {
 btn.addEventListener('click', function() {
 document.getElementById('blockIpModal').classList.add('hidden');
 document.getElementById('blockIpForm').reset();
 });
 });

 document.querySelectorAll('[data-action="submit-block-ip"]').forEach(function(form) {
 form.addEventListener('submit', async function(e) {
 e.preventDefault();
 const formData = new FormData(this);
 try {
 const response = await fetch('{{ route("admin.security-monitor.block-ip") }}', {
 method: 'POST',
 headers: {
 'X-CSRF-TOKEN': '{{ csrf_token() }}',
 'Accept': 'application/json',
 'Content-Type': 'application/json',
 },
 body: JSON.stringify({
 ip_address: formData.get('ip_address'),
 reason: formData.get('reason'),
 duration: parseInt(formData.get('duration')),
 permanent: formData.get('permanent') === 'on',
 }),
 });
 const result = await response.json();
 if (result.success) {
 alert(result.message);
 document.getElementById('blockIpModal').classList.add('hidden');
 document.getElementById('blockIpForm').reset();
 location.reload();
 } else {
 alert(result.message || 'Gagal memblokir IP');
 }
 } catch (error) {
 alert('Terjadi kesalahan: ' + error.message);
 }
 });
 });

 document.querySelectorAll('[data-action="unblock-ip"]').forEach(function(btn) {
 btn.addEventListener('click', async function() {
 const ip = this.getAttribute('data-ip');
 if (!confirm('Yakin ingin membuka blokir IP ' + ip + '?')) return;
 try {
 const response = await fetch('{{ url("admin/security-monitor/unblock") }}/' + ip, {
 method: 'DELETE',
 headers: {
 'X-CSRF-TOKEN': '{{ csrf_token() }}',
 'Accept': 'application/json',
 },
 });
 const result = await response.json();
 if (result.success) {
 alert(result.message);
 location.reload();
 } else {
 alert(result.message || 'Gagal membuka blokir IP');
 }
 } catch (error) {
 alert('Terjadi kesalahan: ' + error.message);
 }
 });
 });

 document.querySelectorAll('[data-action="clear-expired-blocks"]').forEach(function(btn) {
 btn.addEventListener('click', async function() {
 if (!confirm('Hapus semua blokir yang sudah kadaluarsa?')) return;
 try {
 const response = await fetch('{{ route("admin.security-monitor.clear-expired") }}', {
 method: 'POST',
 headers: {
 'X-CSRF-TOKEN': '{{ csrf_token() }}',
 'Accept': 'application/json',
 },
 });
 const result = await response.json();
 if (result.success) {
 alert(result.message);
 location.reload();
 } else {
 alert(result.message || 'Gagal menghapus blokir');
 }
 } catch (error) {
 alert('Terjadi kesalahan: ' + error.message);
 }
 });
 });

 document.querySelectorAll('[data-action="view-ip-threats"]').forEach(function(btn) {
 btn.addEventListener('click', function() {
 const ip = this.getAttribute('data-ip');
 window.location.href = '{{ url("admin/security-monitor") }}?ip=' + ip;
 });
 });
 });
 </script>
 @endpush
@endsection
