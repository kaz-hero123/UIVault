@extends('layouts.app', [
    'bodyClass' => 'bg-background text-on-background font-body-md antialiased h-screen overflow-hidden flex',
    'noPadding' => true,
    'hideTopbar' => true
])

@section('title', 'Edit Inspiration')

@section('content')
<div class="flex-1 flex h-screen bg-background w-full">
    <livewire:edit-inspiration :inspiration="$inspiration" />
</div>
@endsection
