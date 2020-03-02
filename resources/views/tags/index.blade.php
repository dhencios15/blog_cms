@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-end mb-2">
    <a href="{{ route('tags.create') }}" class="btn btn-success float-right">Add tag</a>
</div>
<div class="card card-default">
    <div class="card-header">
        tags
    </div>
    <card class="body">
        @if($tags->count() > 0)
        <table class="table">
            <thead>
                <th>Name</th>
                <th>Posts Count</th>
                <th class="text-right">Actions</th>
            </thead>
            <tbody>
                @foreach($tags as $tag)
                    <tr>
                        <td>{{ $tag->name }}</td>
                        <td>{{ $tag->posts->count() }}</td>
                        <td class="text-right">
                            <a href="{{ route('tags.edit', $tag->id) }}" class="btn btn-info btn-sm mr-2">Edit</a>
                            <a onclick="handleDelete({{ $tag->id }})" style="color: white" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="" method="POST" id="deletetagForm">
                    @csrf
                    @method('DELETE')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModal">Delete tag</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p class="text-center">Are you sure do you want to delete </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                            <button type="submit" class="btn btn-danger">Yes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @else
            <h3 class="text-center">No tags Yet</h3>
        @endif
    </card>
</div>

@endsection

@section('scripts')
    <script>
        function handleDelete(id) {
            var form = document.getElementById('deletetagForm')
            form.action = '/tags/' + id
            $('#deleteModal').modal('show');
        }
    </script>
@endsection