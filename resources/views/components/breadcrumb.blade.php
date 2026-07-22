@props(['items' => []])
<nav aria-label="Breadcrumb" class="mb-4">
    <ol class="flex items-center space-x-2 text-sm text-gray-600">
        @foreach($items as $item)
            <li>
                @if(!$loop->last && isset($item['url']))
                    <a href="{{ $item['url'] }}" class="text-emerald-600 hover:text-emerald-700 hover:underline">
                        {{ $item['label'] }}
                    </a>
                    <span class="mx-2 text-gray-400">/</span>
                @else
                    <span class="text-gray-900 font-medium" aria-current="page">{{ $item['label'] }}</span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
