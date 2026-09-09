@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="  ">
        <h1 class="mb-4">@lang('messages.create_new_thread')</h1>
        <form action="{{ route('threads.thread.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">@lang('messages.title')</label>
                <input type="text" name="title" id="title" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="body" class="form-label">@lang('messages.body')</label>
                <textarea name="body" id="body" class="form-control" rows="5" required></textarea>
            </div>

            <div class="mb-3">
            

                <label for="name" class="form-label">@lang('messages.upload_picture')</label>
                
                
                <input type="file" name="threads_image" id="threads_image" class="form-control" type="file" accept="image/*"></input>
            </div>

            <button type="submit" class="btn btn-primary">@lang('messages.create_thread')</button>
        </form>
    </div>
</div>
@endsection