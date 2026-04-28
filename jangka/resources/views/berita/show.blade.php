@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $item->judul }}</h1>
    <p class="text-muted">Dipublikasikan pada {{ $item->created_at->format('d M Y') }}</p>
    <hr>
    <div>
        {!! nl2br(e($item->isi)) !!}
    </div>
    <hr>
    <a href="{{ route('berita.index') }}" class="btn btn-secondary">← Kembali ke Daftar Berita</a>
</div>
@endsection
