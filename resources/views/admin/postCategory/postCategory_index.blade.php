@extends('admin.admin_layouts')
@section('admin_content')
    <div class="sl-mainpanel">
      <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{ route('admin.home') }}">Deshboard</a>
        <span class="breadcrumb-item active">PostCategory</span>
      </nav>
      <div class="sl-pagebody">
        <div class="card pd-20 pd-sm-40">
          <h6 class="card-body-title">PostCategory LIST
              <a href="" class="btn pd-x-20 btn-warning" data-toggle="modal" data-target="#modaldemo3" style="float: right;margin-bottom: 20px;">Add New</a>
          </h6>
          <div class="table-wrapper">
            <table id="datatable1" class="table display responsive nowrap">
              <thead>
                <tr>
                  <th class="wd-15p">ID</th>
                  <th class="wd-15p">Category Name (English)</th>
                  <th class="wd-15p">Category Name (Bangla)</th>
                  <th class="wd-20p">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($postCategory as $key => $row)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $row->category_name_en }}</td>
                    <td>{{ $row->category_name_bn }}</td>
                    <td>
                        <a href="{{ route('admin.postCategory.edit', $row->id) }}" class="btn btn-sm btn-info" title="Edit"><i class="fa fa-edit"></i></a>
                        <button title="Delete" type="button" class="btn btn-sm btn-danger" title="Delete">
                            <i onclick="deleteItem({{ $row->id }})" class="fa fa-trash"></i>
                        </button>
                        <form id="delete_form_{{ $row->id }}" method="POST" action="{{ route('admin.postCategory.destroy', $row->id) }}">
                          @csrf
                          @method('DELETE')
                        </form>
                    </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div><!-- table-wrapper -->
        </div><!-- card -->
      </div><!-- sl-pagebody -->
    </div><!-- sl-mainpanel -->

 <!-- MODAL -->
        <div id="modaldemo3" class="modal fade">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content tx-size-sm">
              <div class="modal-header pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Post Category Add</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              @if ($errors->any())
                  <div class="alert alert-danger">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif
            <form method="POST" action="{{ route('admin.postCategory.store') }}">
              @csrf
              <div class="modal-body pd-20">
                <div class="form-group">
                  <label for="category_name_en">Category Name (English)</label>
                  <input type="text" class="form-control" name="category_name_en" id="category_name_en" aria-describedby="emailHelp" placeholder="Enter Category Name (English)">
                </div>
                <div class="form-group">
                  <label for="category_name_bn">Category Name (Bangla)</label>
                  <input type="text" class="form-control" name="category_name_bn" id="category_name_bn" aria-describedby="emailHelp" placeholder="Enter Category Name (Bangla)">
                </div>
              </div><!-- modal-body -->
                <div class="modal-footer">
                  <button type="submit" class="btn btn-info pd-x-20">Submit</button>
                  <button type="button" class="btn btn-secondary pd-x-20" data-dismiss="modal">Close</button>
                </div>
              </form>
            </div>
          </div><!-- modal-dialog -->
        </div><!-- modal -->
 
@endsection