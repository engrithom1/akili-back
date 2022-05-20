@extends('layouts.admin')

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Products</h1>
    <a href="{{ route('product.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-plus text-white-50"></i> Create Product</a>
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
        <h6 class="m-0 font-weight-bold text-primary">Available Products</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Dis</th>
                        <th>Views</th>
                        <th>Creator</th>
                        <th>Actions</th>

                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Dis</th>
                        <th>Views</th>
                        <th>Creator</th>
                        <th>Actions</th>

                    </tr>
                </tfoot>
                <tbody>

                    @foreach ($products as $product)
                    <tr>
                        <td>
                            <button class="small-image" image={{ $product->thumb }}>
                                <img src="{{ asset('images/'.$product->thumb) }}" width="30px" height="30px" alt="">
                            </button>
                            {{ $product->name }}
                        </td>
                        <td>{{ $product->category->name }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->discount->percent.' %' }}</td>
                        <td>{{ $product->views }}</td>
                        <td>{{ $product->user->name }}</td>
                        <td>
                            <form method="POST" action="{{ route('product.destroy',$product->id) }}">
                                @csrf
                                @method('DELETE')
                                <a href="{{ route('product.edit', $product->id) }}" class="btn btn-success">
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