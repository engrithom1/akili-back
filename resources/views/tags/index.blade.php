@extends('layouts.admin')

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tags</h1>
    <a href="{{ route('tags.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-plus text-white-50"></i>Create Tag</a>
</div>

<!--message-->
@if (session()->has('message'))
<div class="alert alert-success">
    {{session('message')}}
</div>
@endif
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Available Tags</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Products</th>
                        <th>Creator</th>
                        <th>Actions</th>

                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Products</th>
                        <th>Creator</th>
                        <th>Actions</th>

                    </tr>
                </tfoot>
                <tbody>

                    @foreach ($tags as $tag)
                    <tr>
                        <td>{{ $tag->name }}</td>
                        <td>23</td>
                        <td>Edinburgh</td>
                        <td>
                            <form method="POST" action="{{ route('tags.destroy',$tag->id) }}">
                                @csrf
                                @method('DELETE')
                                <a href="{{ route('tags.edit', $tag->id) }}" class="btn btn-success">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <span> </span>
                                <button class="btn btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
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