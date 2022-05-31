@extends('layouts.admin')

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Permissions</h1>
</div>

<!--message-->
@if (session()->has('message'))
<div class="alert alert-success">
    {{session('message')}}
</div>
@endif
@if (session()->has('error'))
<div class="alert alert-danger">
    {{session('error')}}
</div>
@endif
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Available User roles</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Roles</th>
                        <th>Users</th>
                        <th>Actions</th>

                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Roles</th>
                        <th>Users</th>
                        <th>Actions</th>

                    </tr>
                </tfoot>
                <tbody>

                    @foreach ($roles as $role)
                    <tr>

                        <td>{{ $role->id }}</td>
                        <td>{{ $role->level }}</td>
                        <td>{{ count($role->users) }}</td>

                        <td>
                            <form method="POST" action="">
                                @csrf
                                @method('DELETE')
                                <a href="" class="btn btn-success">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <span> </span>
                                @if (Auth::user()->level_id == 3)
                                <button class="btn btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                                @endif

                            </form>
                        </td>

                    </tr>
                    @endforeach

                </tbody>
            </table>

        </div>

    </div>
</div>



@endsection