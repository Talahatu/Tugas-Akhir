@extends('layouts.seller')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/courier.css') }}">
@endsection
@section('content-wrapper')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">My Couriers</h3>
        </div>
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="btn-group mb-4" role="group" aria-label="Basic mixed styles example">
                        <a type="button" class="btn btn-success create-new-button" id="addNewCourier"
                            href="{{ route('courier.create') }}"><i class="mdi mdi-plus"></i>Add new courier</a>
                    </div>
                    <table id="myTable" class="display table table-hover responsive nowrap"
                        style="width: 100% !important">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Operational Fee</th>
                                <th>Delivery Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 0; $i < count($couriers); $i++)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $couriers[$i]->name }}</td>
                                    <td>{{ $couriers[$i]->operationalFee }}</td>
                                    <td>{{ count($couriers[$i]->deliveries) <= 0 ? 'Available' : 'On Delivery' }}</td>
                                    <td><button class="btn btn-outline-success">Saku</button></td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('js/courier.js') }}"></script>
@endsection
