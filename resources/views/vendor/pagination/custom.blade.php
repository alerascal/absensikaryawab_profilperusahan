@if ($paginator->hasPages())
    <div class="flex flex-col items-center gap-4 mt-6">

        <!-- Pagination -->
        <ul class="pagination flex gap-2 justify-center items-center">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="disabled px-3 py-2 bg-gray-200 rounded-lg text-gray-500">&laquo;</li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}{{ request('search') ? '&search=' . request('search') : '' }}"
                       class="px-3 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">&laquo;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="disabled px-3 py-2 bg-gray-200 rounded-lg">{{ $element }}</li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="px-3 py-2 bg-blue-700 text-white rounded-lg">{{ $page }}</li>
                        @else
                            <li>
                                <a href="{{ $url }}{{ request('search') ? '&search=' . request('search') : '' }}"
                                   class="px-3 py-2 bg-gray-100 rounded-lg hover:bg-blue-500 hover:text-white">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}{{ request('search') ? '&search=' . request('search') : '' }}"
                       class="px-3 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">&raquo;</a>
                </li>
            @else
                <li class="disabled px-3 py-2 bg-gray-200 rounded-lg text-gray-500">&raquo;</li>
            @endif
        </ul>

        <!-- Info Halaman -->
        <p class="text-sm text-gray-600">
            Menampilkan 
            <span class="font-semibold">{{ $paginator->firstItem() }}</span> - 
            <span class="font-semibold">{{ $paginator->lastItem() }}</span> 
            dari 
            <span class="font-semibold">{{ $paginator->total() }}</span> data
        </p>
    </div>
@endif
