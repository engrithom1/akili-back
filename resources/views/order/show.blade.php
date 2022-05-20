@extends('layouts.admin')

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Orders No {{ $oda->id }}</h1>
    <a href="{{ route('order.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-arrow-left text-white-50"></i> Back</a>
</div>

<!--message-->
@if (session()->has('message'))
<div class="alert alert-danger">
    {{session('message')}}
</div>
@endif
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Orders Details</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>CurrentPrice</th>
                        <th>SellPrice</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Item</th>
                        <th>CurrentPrice</th>
                        <th>SellPrice</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </tfoot>
                <tbody>

                    @foreach ($orders as $order)
                    <tr>
                        <td>
                            </button>
                            <button class="small-image" image={{ $order->thumb }}>
                                <img src="{{ asset('images/'.$order->thumb) }}" width="30px" height="30px" alt="">
                            </button>
                            {{ $order->name }}
                        </td>
                        <td>{{ $order->price }}</td>
                        <td>{{ $order->now_price }}</td>
                        <td>{{ $order->quantity}}</td>
                        <td>{{ $order->now_price * $order->quantity }}</td>
                    </tr>
                    @endforeach

                </tbody>
            </table>

        </div>

        <div class="container">

            <div class="row">
                <div class="col-sm-12 col-md-5">
                    <h4><strong>Order Summary</strong></h4>
                    <hr />
                    <h5>TotalPrice : {{ $oda->total }}</h5>
                    <h5>Status : {{ $oda->status }}</h5>
                    <p><strong>Description: </strong>{{$oda->user_desc}}</p>
                    <h5>Submited at : {{ $oda->created_at }}</h5>
                </div>
                <div class="col-sm-12 col-md-7">
                    <form action="{{ route('order.update',$oda->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <input type="hidden" name="status" id="status_input">
                            <label for="admin_desc">Reasons for action</label>
                            <textarea required name="admin_desc" id="admin_desc" class="form-control" cols="30"
                                rows="3"></textarea>
                        </div>
                        @if ($oda->status == 'received')
                        <input type="submit" onclick="done()" value="Done" class="btn btn-success">
                        <input type="submit" onclick="rejected()" value="Rejected" class="btn btn-warning">
                        @endif
                        @if (Auth::user()->level_id == 3 && $oda->status != 'received')
                        <input type="submit" onclick="restore()" value="Restore" class="btn btn-secondary">
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

<script>
    var done = function(){
        document.getElementById('status_input').value = 'done';
    }

    var rejected = function(){
        document.getElementById('status_input').value = 'rejected';
    }

    var restore = function(){
        document.getElementById('status_input').value = 'received';
    }
</script>