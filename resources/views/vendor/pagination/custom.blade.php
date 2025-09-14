@if ($paginator->hasPages())
    <ul class="pagination flex gap-2 justify-center mt-4">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="disabled px-3 py-1 bg-gray-200 rounded">&laquo;</li>
        @else
            <li>
                <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-1 bg-blue-500 text-white rounded">&laquo;</a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="disabled px-3 py-1 bg-gray-200 rounded">{{ $element }}</li>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active px-3 py-1 bg-blue-700 text-white rounded">{{ $page }}</li>
                    @else
                        <li>
                            <a href="{{ $url }}" class="px-3 py-1 bg-gray-300 rounded hover:bg-blue-500 hover:text-white">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li>
                <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-1 bg-blue-500 text-white rounded">&raquo;</a>
            </li>
        @else
            <li class="disabled px-3 py-1 bg-gray-200 rounded">&raquo;</li>
        @endif
    </ul>
@endif
