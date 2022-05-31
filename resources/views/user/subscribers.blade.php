@extends('layouts.admin')

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Subscribers</h1>

    <form method="GET" action="{{ route('subscribers') }}">
        <div class="form-row align-items-center">
            <div class="col-auto">
                <input type="search" name="search" class="form-control mb-2" id="inlineFormInput">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary mb-2">Search</button>
            </div>
        </div>
    </form>
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
        <h6 class="m-0 font-weight-bold text-primary">Available Subscribers</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Fullname</th>
                        <th>Phonenumber</th>
                        <th>Region</th>
                        <th>Actions</th>

                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Fullname</th>
                        <th>Phonenumber</th>
                        <th>Region</th>
                        <th>Actions</th>

                    </tr>
                </tfoot>
                <tbody>

                    @foreach ($subscribers as $subscriber)
                    <tr>

                        <td>{{ $subscriber->name }}</td>
                        <td>{{ ($subscriber->fullname) ? $subscriber->fullname : 'null' }}</td>
                        <td>{{ $subscriber->phonenumber }}</td>
                        <td>{{ $subscriber->region ? $subscriber->region : 'null' }}</td>
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
        {{ $subscribers->links('pagination::bootstrap-4') }}
    </div>
</div>



@endsection