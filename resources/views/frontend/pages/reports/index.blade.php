<x-frontend-layout>
    <x-slot:title>Laporan - {{ config('app.name') }}</x-slot:title>

    <!-- Hero Section -->
    <section class="relative pt-8 sm:pt-10 md:pt-12 pb-16 sm:pb-20 overflow-hidden">
        <div class="absolute inset-0 hero-gradient">
            <div class="absolute inset-0 bg-grid-pattern opacity-50"></div>
            <div class="absolute top-20 left-10 w-72 h-72 bg-emerald-400/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-10 right-10 w-96 h-96 bg-emerald-400/20 rounded-full blur-3xl"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white mb-4 leading-tight tracking-tight">Laporan & Publikasi</h1>
            <p class="text-sm sm:text-lg md:text-xl text-emerald-100 mx-auto px-4 max-w-5xl">Transparansi dan akuntabilitas adalah komitmen kami. Akses laporan keuangan, tahunan, dan tata kelola perusahaan secara mudah.</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 md:py-16 bg-muted/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
                @foreach($categories as $category)
                    @php
                        $slug = $category->slug;
                        $color = $colors[$slug] ?? 'emerald';
                        $iconPath = $icons[$slug] ?? '';
                        $routeName = 'reports.' . str_replace('_', '-', $slug);

                        $colorClasses = [
                            'emerald' => ['bg' => 'from-emerald-50 to-emerald-100', 'text' => 'text-emerald-600', 'hover' => 'hover:border-emerald-200', 'ring' => 'ring-emerald-500/20'],
                            'amber' => ['bg' => 'from-amber-50 to-amber-100', 'text' => 'text-amber-600', 'hover' => 'hover:border-amber-200', 'ring' => 'ring-amber-500/20'],
                            'blue' => ['bg' => 'from-blue-50 to-blue-100', 'text' => 'text-blue-600', 'hover' => 'hover:border-blue-200', 'ring' => 'ring-blue-500/20'],
                            'violet' => ['bg' => 'from-violet-50 to-violet-100', 'text' => 'text-violet-600', 'hover' => 'hover:border-violet-200', 'ring' => 'ring-violet-500/20'],
                        ];
                        $c = $colorClasses[$color] ?? $colorClasses['emerald'];
                    @endphp
                    <a href="{{ route($routeName) }}"
                       class="group bg-card rounded-2xl border border-border p-6 sm:p-8 hover:shadow-lg hover:-translate-y-1.5 {{ $c['hover'] }} transition-all duration-300 text-center card-hover relative overflow-hidden">
                        <!-- Subtle gradient decoration -->
                        <div class="absolute -top-12 -right-12 w-24 h-24 rounded-full bg-gradient-to-br {{ $c['bg'] }} opacity-30 group-hover:opacity-60 group-hover:scale-150 transition-all duration-500"></div>

                        <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br {{ $c['bg'] }} rounded-2xl flex items-center justify-center mx-auto mb-4 sm:mb-6 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300 relative">
                            <svg class="w-8 h-8 sm:w-10 sm:h-10 {{ $c['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                {!! $iconPath !!}
                            </svg>
                        </div>
                        <h3 class="text-lg sm:text-xl font-bold text-foreground mb-2 sm:mb-3 group-hover:text-{{ $color }}-600 transition-colors">{{ $category->title ?? $category->name }}</h3>
                        @if($category->description)
                            <p class="text-sm text-muted-foreground leading-relaxed">{{ $category->description }}</p>
                        @endif
                        <div class="mt-4 sm:mt-6 inline-flex items-center gap-1.5 text-sm font-semibold {{ $c['text'] }} opacity-0 group-hover:opacity-100 transition-all duration-300 -translate-y-1 group-hover:translate-y-0">
                            Lihat Laporan
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
</x-frontend-layout>
