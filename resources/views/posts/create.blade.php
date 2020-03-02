@extends('layouts.app')

@section('content')

    <div class="card card-default">
    <div class="card-header"> {{ isset($post) ? 'Edit Post' : 'Create Post' }}</div>

        <div class="card-body">
            <form action="{{ isset($post) ? route('posts.update', $post->id) : route('posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($post))
                    @method('PUT')
                @endif
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ isset($post) ? $post->title : '' }}">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" cols="3" rows="3" id="description" class="form-control">{{ isset($post) ? $post->description : '' }}</textarea>
                    
                </div>
                <div class="form-group">
                    <label for="content">Content</label>
                    <input id="content" type="hidden" name="content" value="{{ isset($post) ? $post->content : '' }}">
                    <trix-editor input="content"></trix-editor>
                </div>
                <div class="form-group">
                    <label for="publish_at">Published At</label>
                    <input type="text" name="publish_at" id="publish_at" class="form-control" value="{{ isset($post) ? $post->publish_at : '' }}">
                </div>
                @if(isset($post))
                    <div class="form-group">
                        <img src="{{ asset('storage/' . $post->image) }}" style="width: 100%">
                    </div>
                @endif
                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" name="image" id="image" class="form-control">
                </div>

                <div class="form-group">
                    <label for="category">Category</label>
                    <select name="category" id="category" class="form-control">
                        @foreach ($categories as $category)
                        <option
                          value="{{ $category->id  }}"
                          @if (isset($post))
                            @if ($category->id == $post->category_id)
                            selected
                            @endif
                          @endif>
                            {{ $category->name }}
                        </option>
                        @endforeach

                    </select>
                </div>

                @if ($tags->count() > 0)
                <div class="form-group">
                    <label for="tags">Tags</label>
                    <select name="tags[]" id="tags" class="form-control" multiple>
                        @foreach ($tags as $tag)
                            <option value="{{ $tag->id }}">
                                {{  $tag->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @endif

                <div class="form-group">
                    <button type="submit" class="btn btn-success">{{ isset($post) ? 'Update Post' : 'Create Post' }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.1/trix.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr('#publish_at', {
            enableTime: true
        })
    </script>

@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.1/trix.css" rel="stylesheet">
@endsection