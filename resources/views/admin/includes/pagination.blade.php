@if ($paginator->hasPages())
<div class="col-md-5">
    <div class="col-md-2">
        <select class="form-control input-sm ct-select-role" data-placeholder="" style="width: 100%;" name="per_page" onchange="window.location.href=this.value;">
            @foreach([20, 40, 60, 80, 100] as $perPage)
                <option {{ (int)Request::input('per_page', null) === $perPage ? 'selected' : '' }} value="">{{$perPage}}</option>
            @endforeach
        </select>                    
    </div>
</div>
<div class="col-md-7">
        <ul class="pagination pagination-sm no-margin pull-right" style="justify-content: flex-end">
        <!-- Previous Page Link -->
        @if ($paginator->onFirstPage())
        <li class="page-item disabled"><span class="page-link pjax-container">&laquo;</span></li>
        @else
        <li class="page-item"><a class="page-link pjax-container" href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a></li>
        @endif

        <!-- Pagination Elements -->
        @foreach ($elements as $element)
        <!-- "Three Dots" Separator -->
        @if (is_string($element))
        <li class="page-item disabled"><span class="page-link pjax-container">{{ $element }}</span></li>
        @endif

        <!-- Array Of Links -->
        @if (is_array($element))
        @foreach ($element as $page => $url)
        @if ($page == $paginator->currentPage())
        <li class="page-item active"><span class="page-link pjax-container">{{ $page }}</span></li>
        @else
        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
        @endif
        @endforeach
        @endif
        @endforeach

        <!-- Next Page Link -->
        @if ($paginator->hasMorePages())
        <li class="page-item"><a class="page-link pjax-container" href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a></li>
        @else
        <li class="page-item disabled"><span class="page-link pjax-container">&raquo;</span></li>
        @endif
    </ul>
</div>
@endif
