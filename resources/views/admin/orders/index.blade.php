@extends('layouts.admin')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <hr>
                    <div class="row col-md-12">
                        <div class="col-md-12">
                            <div class="container">
                                <form method="GET" action="{{ route('admin.orders.index') }}" class="mb-4">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="phone">Phone Number</label>
                                                <input type="text" name="phone" class="form-control" value="{{ request()->phone }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="username">User Name</label>
                                                <input type="text" name="username" class="form-control" value="{{ request()->username }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="status">Status</label>
                                                <select name="status" class="form-control">
                                                    <option value="">Select Status</option>
                                                    @foreach (App\Enums\OrderStatus::cases() as $status)
                                                    <option value="{{ $status->value }}" {{ request()->status == $status->value ? 'selected' : '' }}> {{ ucfirst($status->value) }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Search</button>
                                    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Reset</a>
                                </form>
                            </div>
                            <table class="table table-striped table-bordered">
                                <thead class="header-table">
                                    <tr>
                                        <th class="text-center">Order ID</th>
                                        <th class="text-center">User</th>
                                        <th class="text-center">Address</th>
                                        <th class="text-center">Phone</th>
                                        <th class="text-center">Created time</th>
                                        <th class="text-center">Total Price</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td class="text-center">{{ $order->id }}</td>
                                            <td class="text-center">{{ $order->user->name }}</td>
                                            <td class="text-center">{{ $order->address->address }}</td>
                                            <td class="text-center">{{ $order->address->phone_number }}</td>
                                            <td class="text-center">{{ $order->created_at }}</td>
                                            <td class="text-center">${{ $order->total_price }}</td>
                                            <td class="text-center">{{ ucfirst($order->order_status->value) }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                                                <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row col-md-12">
                        @if (count($orders))
                            {{ $orders->links('admin.includes.pagination') }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
