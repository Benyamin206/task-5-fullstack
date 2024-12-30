{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}


@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>{{ __('You are logged in!') }}</p>

                    <!-- Tombol untuk menuju ke halaman daftar kategori -->
                    <a href="{{ route('categories.index') }}" class="btn btn-primary mt-3">
                        HALAMAN KATEGORI
                    </a>
                    <a href="{{ route('articles.index') }}" class="btn btn-success mt-3">
                        HALAMAN ARTIKEL
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

