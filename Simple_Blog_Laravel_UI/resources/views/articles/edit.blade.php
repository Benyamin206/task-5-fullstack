@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Edit Article</h1>

    <form action="{{ route('articles.update', $article->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" class="form-control" id="title" value="{{ old('title', $article->title) }}" required>
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea name="content" class="form-control" id="content" rows="5" required>{{ old('content', $article->content) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select name="category_id" class="form-control" id="category_id" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" 
                        {{ old('category_id', $article->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" name="image" class="form-control" id="image">
            
            @if($article->image)
                <div class="mt-3">
                    <img src="{{ Storage::url($article->image) }}" alt="Current Image" width="150">
                    <p>Current Image</p>
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection

