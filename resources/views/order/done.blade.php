@extends('layouts.admin')

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Orders</h1>
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
        <h6 class="m-0 font-weight-bold text-primary">Done Orders</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>OrderId</th>
                        <th>Total</th>
                        <th>Send By</th>
                        <th>Phonenumber</th>
                        <th>status</th>

                        <th>Actions</th>

                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>OrderId</th>
                        <th>Total</th>
                        <th>Send By</th>
                        <th>Phonenumber</th>
                        <th>status</th>

                        <th>Actions</th>

                    </tr>
                </tfoot>
                <tbody>

                    @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->total }}</td>
                        <td>{{ $order->fullname }}</td>
                        <td>{{ $order->phonenumber}}</td>
                        <td>{{ $order->status }}</td>

                        <td>
                            <form method="POST" action="{{ route('order.destroy',$order->id) }}">
                                @csrf
                                @method('DELETE')
                                <a href="{{ route('order.show', $order->id) }}" class="btn btn-success">
                                    <i class="fas fa-eye"></i>
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