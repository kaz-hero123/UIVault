@extends('layouts.app')

@section('title', 'Upload')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-8">
        <h1 class="font-display-lg text-display-lg text-on-surface mb-2">Upload Inspirations</h1>
        <p class="font-body-md text-body-md text-on-surface-variant">
            Max <strong>{{ $maxFiles }}</strong> files &middot; 10MB limit &middot; JPEG, PNG, GIF, WebP
        </p>
    </div>

    @if ($errors->any())
        <div class="mb-6 p-4 bg-error-container text-on-error-container rounded-xl border border-error/20 text-sm shadow-sm flex items-start gap-3">
            <span class="material-symbols-outlined text-[20px] mt-0.5">error</span>
            <ul class="list-disc pl-4 space-y-1">
                @foreach ($errors->all() as $error)
                    <li class="font-body-md text-body-md">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-surface-container-low rounded-2xl border border-border-quiet p-8 shadow-sm">
        <form action="{{ route('upload.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-8">
            @csrf

            <!-- Upload Area -->
            <div class="flex flex-col gap-3">
                <label for="images" class="font-label-md text-label-md text-on-surface">Select Files</label>
                
                <div class="relative group cursor-pointer">
                    <input
                        type="file"
                        id="images"
                        name="images[]"
                        multiple
                        accept="image/jpeg,image/png,image/gif,image/webp"
                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                    />
                    
                    <div class="border-2 border-dashed border-outline-variant group-hover:border-primary group-hover:bg-primary-container/10 transition-all duration-300 group-hover:scale-[1.01] group-hover:shadow-sm rounded-xl p-12 flex flex-col items-center justify-center text-center gap-3">
                        <span class="material-symbols-outlined text-[48px] text-outline-variant group-hover:text-primary transition-all duration-300 group-hover:-translate-y-1">cloud_upload</span>
                        <div>
                            <span class="font-title-md text-title-md text-on-surface block mb-1">Click to browse or drag files here</span>
                            <span class="font-body-sm text-body-sm text-on-surface-variant">Support JPG, PNG, GIF, WebP format</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-4 border-t border-quiet">
                <button type="submit" class="w-full bg-primary text-on-primary py-4 rounded-xl hover:bg-primary-container hover:text-on-primary-container font-title-md text-title-md transition-all duration-300 shadow-sm hover:shadow-md active:scale-[0.98] flex items-center justify-center gap-2 group">
                    <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform duration-300">send</span>
                    <span>Upload to Inbox</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
