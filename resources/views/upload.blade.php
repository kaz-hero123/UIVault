@extends('layouts.app')

@section('title', 'Upload')

@section('content')
<div class="max-w-lg mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-xl font-bold mb-4">Upload Gambar</h1>

    <p class="text-sm text-gray-500 mb-4">
        Maks <strong>{{ $maxFiles }}</strong> file per upload &middot; Maks 10MB per file &middot; Format: JPEG, PNG, GIF, WebP
    </p>

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-50 text-red-700 rounded border border-red-200 text-sm">
            <ul class="list-disc pl-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('upload.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label for="images" class="block text-sm font-medium text-gray-700 mb-1">Pilih Gambar</label>
            <input
                type="file"
                id="images"
                name="images[]"
                multiple
                accept="image/jpeg,image/png,image/gif,image/webp"
                class="block w-full text-sm border border-gray-300 rounded p-2"
            />
        </div>

        <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded hover:bg-indigo-700 font-medium">
            Upload ke Inbox
        </button>
    </form>
</div>
@endsection
