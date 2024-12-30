@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Articles</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('articles.create') }}" class="btn btn-primary mb-3">Create New Article</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Title</th>
                <th>Pemilik</th>
                <th>Category</th>
                <th>Content</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($articles as $article)
                <tr>
                    <td>{{ $article->title }}</td>
                    <td>{{$article->user->name}}</td>
                    <td>{{ $article->category->name }}</td>
                    <td>{{$article->content}}</td>
                    <td>
                        @if($article->image)
                            <img src="{{ Storage::url($article->image) }}" alt="Image" width="100">
                        @else
                            No image
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('articles.destroy', $article->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
