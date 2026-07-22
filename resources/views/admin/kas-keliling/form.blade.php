<div class="space-y-6">
 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
 <!-- Tanggal -->
 <div>
 <label for="schedule_date" class="block text-[11px] font-semibold text-zinc-700 mb-2">
 Tanggal Jadwal <span class="text-red-600">*</span>
 </label>
 <input type="date" name="schedule_date" id="schedule_date" 
 value="{{ old('schedule_date', isset($kasKeliling) && $kasKeliling->schedule_date ? $kasKeliling->schedule_date->format('Y-m-d') : '') }}"
 min="{{ date('Y-m-d') }}"
 class="w-full px-4 py-2.5 border border-zinc-300 rounded-xl focus:ring-2 @error('schedule_date') border-red-500 @enderror" 
 required>
 @error('schedule_date')
 <p class="mt-1.5 text-[13px] text-red-600">{{ $message }}</p>
 @else
 <p class="mt-1.5 text-[13px] text-zinc-500">Tanggal tidak boleh kurang dari hari ini</p>
 @enderror
 </div>

 <!-- Lokasi -->
 <div>
 <label for="location" class="block text-[11px] font-semibold text-zinc-700 mb-2">
 Lokasi/Tujuan <span class="text-red-600">*</span>
 </label>
 <input type="text" name="location" id="location" 
 value="{{ old('location', $kasKeliling->location ?? '') }}"
 list="location-suggestions"
 class="w-full px-4 py-2.5 border border-zinc-300 rounded-xl focus:ring-2 @error('location') border-red-500 @enderror" 
 required placeholder="Contoh: Pasar Pagi Sungailiat">
 <datalist id="location-suggestions">
 <option value="Pasar Pagi Sungailiat">
 <option value="Kelurahan Pemali">
 <option value="Pasar Belinyu">
 <option value="Pasar Koba">
 <option value="Kelurahan Sungailiat">
 <option value="Pasar Mentok">
 <option value="Kelurahan Toboali">
 <option value="Pasar Pangkalpinang">
 </datalist>
 @error('location')
 <p class="mt-1.5 text-[13px] text-red-600">{{ $message }}</p>
 @enderror
 </div>
 </div>

 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
 <!-- Jam Mulai -->
 <div>
 <label for="start_time" class="block text-[11px] font-semibold text-zinc-700 mb-2">
 Jam Mulai <span class="text-red-600">*</span>
 </label>
 <input type="time" name="start_time" id="start_time" 
 value="{{ old('start_time', isset($kasKeliling) && $kasKeliling->start_time ? \Carbon\Carbon::parse($kasKeliling->start_time)->format('H:i') : '') }}"
 class="w-full px-4 py-2.5 border border-zinc-300 rounded-xl focus:ring-2 @error('start_time') border-red-500 @enderror" 
 required>
 @error('start_time')
 <p class="mt-1.5 text-[13px] text-red-600">{{ $message }}</p>
 @enderror
 </div>

 <!-- Jam Selesai -->
 <div>
 <label for="end_time" class="block text-[11px] font-semibold text-zinc-700 mb-2">
 Jam Selesai <span class="text-red-600">*</span>
 </label>
 <input type="time" name="end_time" id="end_time" 
 value="{{ old('end_time', isset($kasKeliling) && $kasKeliling->end_time ? \Carbon\Carbon::parse($kasKeliling->end_time)->format('H:i') : '') }}"
 class="w-full px-4 py-2.5 border border-zinc-300 rounded-xl focus:ring-2 @error('end_time') border-red-500 @enderror" 
 required>
 @error('end_time')
 <p class="mt-1.5 text-[13px] text-red-600">{{ $message }}</p>
 @enderror
 <div id="time-duration" class="mt-1.5 text-[13px] text-zinc-500 hidden"></div>
 </div>
 </div>

 <!-- Fasilitas -->
 <div>
 <label for="facility" class="block text-[11px] font-semibold text-zinc-700 mb-2">
 Fasilitas yang Tersedia
 </label>
 <div class="mb-2">
 <div class="flex flex-wrap gap-2">
 <button type="button" class="facility-tag px-3 py-1 text-[13px] bg-zinc-50 text-zinc-700 rounded-lg" data-facility="Setoran Tabungan">
 Setoran Tabungan
 </button>
 <button type="button" class="facility-tag px-3 py-1 text-[13px] bg-zinc-50 text-zinc-700 rounded-lg" data-facility="Pembayaran Angsuran">
 Pembayaran Angsuran
 </button>
 <button type="button" class="facility-tag px-3 py-1 text-[13px] bg-zinc-50 text-zinc-700 rounded-lg" data-facility="Penarikan Tunai">
 Penarikan Tunai
 </button>
 <button type="button" class="facility-tag px-3 py-1 text-[13px] bg-zinc-50 text-zinc-700 rounded-lg" data-facility="Pembukaan Rekening">
 Pembukaan Rekening
 </button>
 <button type="button" class="facility-tag px-3 py-1 text-[13px] bg-zinc-50 text-zinc-700 rounded-lg" data-facility="Transfer">
 Transfer
 </button>
 </div>
 <p class="text-[13px] text-zinc-500 mt-1">Klik untuk menambahkan ke daftar fasilitas</p>
 </div>
 <textarea name="facility" id="facility" rows="3" 
 class="w-full px-4 py-2.5 border border-zinc-300 rounded-xl focus:ring-2 resize-none @error('facility') border-red-500 @enderror" 
 placeholder="Contoh: Setoran Tabungan, Pembayaran Angsuran, Penarikan Tunai">{{ old('facility', $kasKeliling->facility ?? '') }}</textarea>
 @error('facility')
 <p class="mt-1.5 text-[13px] text-red-600">{{ $message }}</p>
 @else
 <p class="mt-1.5 text-[13px] text-zinc-500">Pisahkan dengan koma (,) untuk multiple fasilitas</p>
 @enderror
 </div>

 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
 <!-- Nama PIC -->
 <div>
 <label for="pic_name" class="block text-[11px] font-semibold text-zinc-700 mb-2">
 Nama PIC (Person In Charge)
 </label>
 <input type="text" name="pic_name" id="pic_name" 
 value="{{ old('pic_name', $kasKeliling->pic_name ?? '') }}"
 class="w-full px-4 py-2.5 border border-zinc-300 rounded-xl focus:ring-2 @error('pic_name') border-red-500 @enderror" 
 placeholder="Nama petugas">
 @error('pic_name')
 <p class="mt-1.5 text-[13px] text-red-600">{{ $message }}</p>
 @enderror
 </div>

 <!-- Nomor PIC -->
 <div>
 <label for="pic_phone" class="block text-[11px] font-semibold text-zinc-700 mb-2">
 Nomor Telepon PIC
 </label>
 <input type="text" name="pic_phone" id="pic_phone" 
 value="{{ old('pic_phone', $kasKeliling->pic_phone ?? '') }}"
 class="w-full px-4 py-2.5 border border-zinc-300 rounded-xl focus:ring-2 @error('pic_phone') border-red-500 @enderror" 
 placeholder="08xx-xxxx-xxxx"
 pattern="[0-9+\-\s()]+"
 title="Hanya angka, tanda +, -, spasi, dan tanda kurung yang diperbolehkan">
 @error('pic_phone')
 <p class="mt-1.5 text-[13px] text-red-600">{{ $message }}</p>
 @else
 <p class="mt-1.5 text-[13px] text-zinc-500">Format: 08xx-xxxx-xxxx atau +62xxx-xxxx-xxxx</p>
 @enderror
 </div>
 </div>

 <!-- Catatan -->
 <div>
 <label for="notes" class="block text-[11px] font-semibold text-zinc-700 mb-2">
 Catatan Tambahan
 </label>
 <textarea name="notes" id="notes" rows="3" 
 class="w-full px-4 py-2.5 border border-zinc-300 rounded-xl focus:ring-2 resize-none @error('notes') border-red-500 @enderror" 
 placeholder="Catatan atau informasi tambahan (opsional)">{{ old('notes', $kasKeliling->notes ?? '') }}</textarea>
 @error('notes')
 <p class="mt-1.5 text-[13px] text-red-600">{{ $message }}</p>
 @enderror
 </div>

 <!-- Status Aktif -->
 <div class="flex items-center">
 <input type="checkbox" name="is_active" id="is_active" value="1" 
 {{ old('is_active', isset($kasKeliling) ? $kasKeliling->is_active : true) ? 'checked' : '' }}
 class="rounded border-zinc-300 text-sky-600">
 <label for="is_active" class="ml-2 text-[11px] text-zinc-700">Aktif</label>
 </div>

 <!-- Buttons -->
 <div class="flex gap-3 pt-4">
 <x-admin.button type="submit">
 {{ isset($kasKeliling) ? 'Perbarui' : 'Simpan' }}
 </x-admin.button>
 <x-admin.button href="{{ route('admin.kas-keliling.index') }}" variant="secondary">
 Batal
 </x-admin.button>
 </div>
</div>

@push('scripts')
<script nonce="{{ $nonce }}">
document.addEventListener('DOMContentLoaded', function() {
 const startTimeInput = document.getElementById('start_time');
 const endTimeInput = document.getElementById('end_time');
 const timeDurationDiv = document.getElementById('time-duration');
 const facilityTextarea = document.getElementById('facility');
 const facilityTags = document.querySelectorAll('.facility-tag');

 // Time duration calculator
 function calculateDuration() {
 if (startTimeInput.value && endTimeInput.value) {
 const start = new Date(`2000-01-01T${startTimeInput.value}:00`);
 const end = new Date(`2000-01-01T${endTimeInput.value}:00`);
 
 if (end > start) {
 const diffMs = end - start;
 const diffHours = Math.floor(diffMs / (1000 * 60 * 60));
 const diffMinutes = Math.floor((diffMs % (1000 * 60 * 60)) / (1000 * 60));
 
 let durationText = `Durasi: ${diffHours} jam`;
 if (diffMinutes > 0) {
 durationText += ` ${diffMinutes} menit`;
 }
 
 timeDurationDiv.textContent = durationText;
 timeDurationDiv.classList.remove('hidden');
 
 // Warning for long duration
 if (diffHours > 8) {
 timeDurationDiv.classList.add('text-amber-600');
 timeDurationDiv.textContent += ' (Durasi cukup panjang)';
 } else {
 timeDurationDiv.classList.remove('text-amber-600');
 }
 } else {
 timeDurationDiv.classList.add('hidden');
 }
 } else {
 timeDurationDiv.classList.add('hidden');
 }
 }

 startTimeInput.addEventListener('change', calculateDuration);
 endTimeInput.addEventListener('change', calculateDuration);

 // Initial calculation
 calculateDuration();

 // Facility tags
 facilityTags.forEach(tag => {
 tag.addEventListener('click', function() {
 const facility = this.dataset.facility;
 const currentValue = facilityTextarea.value.trim();
 
 if (currentValue === '') {
 facilityTextarea.value = facility;
 } else {
 // Check if facility already exists
 const facilities = currentValue.split(',').map(f => f.trim());
 if (!facilities.includes(facility)) {
 facilityTextarea.value = currentValue + ', ' + facility;
 }
 }
 
 // Visual feedback
 this.classList.add('bg-blue-100', 'text-amber-700');
 setTimeout(() => {
 this.classList.remove('bg-blue-100', 'text-amber-700');
 }, 300);
 });
 });

 // Phone number formatting
 const phoneInput = document.getElementById('pic_phone');
 phoneInput.addEventListener('input', function() {
 // Remove any non-digit, non-plus, non-dash, non-space, non-parentheses characters
 this.value = this.value.replace(/[^0-9+\-\s()]/g, '');
 });
});
</script>
@endpush
