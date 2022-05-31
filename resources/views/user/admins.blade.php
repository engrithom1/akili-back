@extends('layouts.admin')

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Admins</h1>
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
        <h6 class="m-0 font-weight-bold text-primary">Available Admins</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Fullname</th>
                        <th>Phonenumber</th>
                        <th>Role</th>
                        @if (Auth::user()->level_id == 3)
                        <th>Actions</th>
                        @endif

                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Fullname</th>
                        <th>Phonenumber</th>
                        <th>Role</th>
                        @if (Auth::user()->level_id == 3)
                        <th>Actions</th>
                        @endif
                    </tr>
                </tfoot>
                <tbody>

                    @foreach ($admins as $admin)
                    <tr>

                        <td>{{ $admin->name }}</td>
                        <td>{{ ($admin->fullname) ? $admin->fullname : 'null' }}</td>
                        <td>{{ $admin->phonenumber }}</td>
                        <td>{{ $admin->level_id == 2 ? 'Admin' : 'SuperAdmin' }}</td>
                        @if (Auth::user()->level_id == 3)
                        <td>
                            <form method="POST" action="">
                                @csrf
                                @method('DELETE')
                                <a href="" class="btn btn-success">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <span> </span>

                                <button class="btn btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>

                            </form>
                        </td>
                        @endif

                    </tr>
                    @endforeach

                </tbody>
            </table>

        </div>

    </div>
</div>



@endsection