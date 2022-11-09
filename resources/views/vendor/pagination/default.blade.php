@if ($paginator->hasPages())
{{-- Previous Page link --}}
@if ($paginator->onFirstPage())
<a class="disabled" aria-disabled="true" aria-label="@lang('pagination.previous')"><i class="fa fa-long-arrow-left"
        aria-hidden="true"></i>
</a>
@else
<a href="{{ $paginator->previousPageUrl() }}" aria-label="@lang('pagination.previous')"><i class="fa fa-long-arrow-left"
        aria-hidden="true"></i></a>
@endif

{{-- Pagination Elements --}}
@foreach ($elements as $element)
{{-- "Three Dots" Separator --}}
@if (is_string($element))
<a href="#" class="dot-dot"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
@endif

{{-- Array Of links --}}
@if (is_array($element))
@foreach ($element as $page => $url)
@if ($page == $paginator->currentPage())
<a href="#" class="active">{{ $page }}</a>
@else
<a href="{{ $url }}">{{ $page }}</a>
@endif
@endforeach
@endif
@endforeach

{{-- Next Page link --}}
@if ($paginator->hasMorePages())
<a href="{{ $paginator->nextPageUrl() }}" aria-label="@lang('pagination.next')"><i class="fa fa-long-arrow-right"
        aria-hidden="true"></i></a>
@else
<a class="disabled" aria-disabled="true" aria-label="@lang('pagination.next')"><i class="fa fa-long-arrow-right"
        aria-hidden="true"></i>
</a>
@endif
@endif