<div class="card">
    <div class="card-header d-flex align-items-center">
        <strong class="mb-0">{{ $author->name }}</strong>

        <form action="{{ route('admin.authors.destroy', $author->id) }}" method="POST" class="mb-0">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger">Delete author</button>
        </form>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.authors.update', $author->id) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="{{ $author->name }}">
            </div>
            <div class="form-group">
                <label>Image</label>
                <input type="text" name="image" class="form-control" value="{{ $author->image }}">
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="5">{{ $author->description }}</textarea>
            </div>
            <button type="submit" class="btn btn-sm btn-primary">Update</button>
        </form>
    </div>
</div>
