@extends('layouts.app', ['hideTopbar' => true])

@section('title', 'Explorer')

@section('content')
<div class="h-full">
    <livewire:explorer-grid />
</div>
@endsection
