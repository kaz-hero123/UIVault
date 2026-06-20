@extends('layouts.app')

@section('title', 'Edit Inspiration')

@section('content')
<div>
    <h1 class="text-xl font-bold mb-4 text-gray-900">Edit Inspiration</h1>
    <livewire:edit-inspiration :inspiration="$inspiration" />
</div>
@endsection
