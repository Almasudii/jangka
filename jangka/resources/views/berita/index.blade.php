{{-- resources/views/berita/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Berita</h1>
    <a href="{{ route('admin.berita.create') }}" class="btn btn-primary">Tambah Berita</a>
    <hr>

    @foreach($berita as $item)
        <div class="card mb-3">
            <div class="card-body">
                <h2 class="card-title">
                    <a href="{{ route('berita.show', $item->id) }}">{{ $item->judul }}</a>
                </h2>
                <p class="card-text">{{ Str::limit($item->isi, 150) }}</p>
                <a href="{{ route('berita.show', $item->id) }}" class="btn btn-sm btn-info">Baca Selengkapnya</a>
            </div>
        </div>
    @endforeach

    {{-- Pagination --}}
    <div>
        {{ $berita->links() }}
    </div>
</div>
@endsection
