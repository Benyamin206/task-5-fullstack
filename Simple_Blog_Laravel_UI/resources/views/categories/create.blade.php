@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Create New Category</h1>

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Category Name</label>
            <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Create</button>
    </form>
</div>
@endsection
