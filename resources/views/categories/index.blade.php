@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-end mb-2">
    <a href="{{ route('categories.create') }}" class="btn btn-success float-right">Add Category</a>
</div>
<div class="card card-default">
    <div class="card-header">
        Categories
    </div>
    <card class="body">
        @if($categories->count() > 0)
        <table class="table">
            <thead>
                <th>Name</th>
                <th>Posts Count</th>
                <th class="text-right">Actions</th>
            </thead>
            <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->posts->count() }}</td>
                        <td class="text-right">
                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-info btn-sm mr-2">Edit</a>
                            <a onclick="handleDelete({{ $category->id }})" style="color: white" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="" method="POST" id="deleteCategoryForm">
                    @csrf
                    @method('DELETE')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModal">Delete Category</h5>
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
            <h3 class="text-center">No Categories Yet</h3>
        @endif
    </card>
</div>

@endsection

@section('scripts')
    <script>
        function handleDelete(id) {
            var form = document.getElementById('deleteCategoryForm')
            form.action = '/categories/' + id
            $('#deleteModal').modal('show');
        }
    </script>
@endsection