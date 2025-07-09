@extends('layouts.admin')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <hr>
                    <div class="row col-md-12">
                        <div class="col-md-12">
                            <div class="container">
                                <form method="GET" action="{{ route('admin.authors.index') }}" class="mb-4">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="name">Search author by name</label>
                                                <input type="text" name="name" class="form-control" value="{{ request()->name ?? '' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-primary">Search</button>
                                            <a href="{{ route('admin.authors.index') }}" class="btn btn-secondary">Clear</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <table class="table table-bordered table-striped" id="authors-table">
                                        <thead class="header-table">
                                            <tr>
                                                <th class="text-center col-md-1">#</th>
                                                <th class="text-center">Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!is_null($authors) && count($authors))
                                                @foreach ($authors as $key => $author)
                                                    <tr style="cursor: pointer;" data-author-id="{{ $author->id }}">
                                                        <td class="text-center">{{ $key+1 }}</td>

                                                        @php
                                                            $keyword = request()->name;
                                                            $highlightedName = $author->name;

                                                            if ($keyword && stripos($author->name, $keyword) !== false) {
                                                                $highlightedName = preg_replace(
                                                                    '/' . preg_quote($keyword, '/') . '/i',
                                                                    '<span class="highlighted-search-keywords">$0</span>',
                                                                    $author->name
                                                                );
                                                            }
                                                        @endphp

                                                        <td class="text-center">{!! $highlightedName !!}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="8" class=" text-center">Data Not Found</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-8">
                                    <div id="author-detail"
                                         class="bg-white border rounded shadow p-3"
                                         style="position: fixed; top: 80px; right: 30px; width: 50%; max-height: calc(100vh - 100px); overflow-y: auto; z-index: 1030;">
                                        <p class="text-muted fst-italic text-center">Information of author will be show here.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row col-md-12">
                        @if (count($authors))
                            {{ $authors->render('admin.includes.pagination') }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    document.querySelectorAll("#authors-table tbody tr").forEach(row => {
        row.addEventListener("click", function() {
            const authorId = this.dataset.authorId;
            fetch(`/admin/authors/${authorId}`)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('author-detail').innerHTML = html;
                });
        });
    });
</script>

@endsection
