@extends('layouts.main')

@section('container')

<div class="mx-3 container-fluid mb-5">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 mt-2 pb-2 mb-3 border-bottom header">
      <h3>Category List</h3>
  </div>

  @include('partials.alert')

  @error('name')
    <div class="alert alert-danger alert-dismissible fade show col" role="alert">
        {!! $message !!}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @enderror

  @error('slug')
    <div class="alert alert-danger alert-dismissible fade show col" role="alert">
        {!! $message !!}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @enderror

  <button class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
    <i class="bi bi-plus-circle"></i> Add Category
  </button>

  @if($categories->count())
    <table class="table table-bordered align-middle text-center" id="category-table" style="border-color:rgb(194, 194, 194);">
      <thead>
        <tr>
          <th scope="col" class="table-primary align-middle text-center">#</th>
          <th scope="col" class="table-primary align-middle text-center">Name</th>
          <th scope="col" class="table-primary align-middle text-center">Total Items</th>
          <th scope="col" class="table-primary align-middle text-center">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($categories as $category)
          <tr>
            <td scope="row" class="text-center">{{ $loop->iteration }}</td>
            <td>{{ $category->name }}</td>
            <td data-order="{{ $category->products->count() }}" class="text-center">
              {{ $category->products->count() }}
            </td>
            <td scope="col" class="d-flex justify-content-center">
              <button href="#" class="btn btn-warning editButton" data-bs-toggle="modal" data-bs-target="#editCategoryModal{{ $category->id }}">
                <i class="bi bi-pencil-square"></i>
              </button>

              <div class="modal fade text-start" id="editCategoryModal{{ $category->id }}" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form class="myForm" id="editCategoryForm" method="POST" action="/category/{{ $category->slug }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                          <label for="editName" class="form-label">Name</label>
                          <input type="text" class="form-control editName" id="editName" name="name" value="{{ $category->name }}" required>
                        </div>
                        <div class="mb-3">
                          <label for="editSlug" class="form-label">Slug</label>
                          <input type="text" class="form-control editSlug" id="editSlug" name="slug" value="{{ $category->slug }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary submitButton">Update Category</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

              <form action="/category/{{ $category->slug }}" method="POST">
                @method('delete')
                @csrf
                <button class="btn btn-danger mx-2 deleteButton">
                  <i class="bi bi-trash3"></i>
                </button>
              </form>
            </td>
          </tr>
        @endforeach
    </tbody>
  </table>
  @else
  <h3 class="text-center">No data.</h3>
  @endif
</div>

<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addCategoryModalLabel">Add Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="myForm" id="addCategoryForm" method="POST" action="/category">
          @csrf
          <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
          </div>
          <div class="mb-3">
            <label for="slug" class="form-label">Slug</label>
            <input type="text" class="form-control" id="slug" name="slug" required>
          </div>
          <button type="submit" class="btn btn-primary submitButton">Add Category</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function () {
    $('#category-table').DataTable({
      "columnDefs": [
        { "type": "num", "targets": 2 },
        { "orderable": false, "targets": 3 }
      ]
    });

    $('.editName').on('keyup', function() {
      let preslug = $(this).val();
      preslug = preslug.replace(/ /g, "-");
      $('.editSlug').val(preslug.toLowerCase());
    });

    $('#name').on('keyup', function() {
      let preslug = $(this).val();
      preslug = preslug.replace(/ /g, "-");
      $('#slug').val(preslug.toLowerCase());
    });
  });

  // $('#addCategoryForm').submit(function(event) {
  //   event.preventDefault();

  //   $.ajax({
  //     url: $(this).attr('action'),
  //     method: 'POST',
  //     data: $(this).serialize(),
  //     success: function(response) {
  //       $('#addCategoryModal').modal('hide');
  //       location.reload();
  //     },
  //     error: function(xhr, status, error) {
  //       console.error(xhr.responseText);
  //     }
  //   });
  // });
</script>
      
@endsection