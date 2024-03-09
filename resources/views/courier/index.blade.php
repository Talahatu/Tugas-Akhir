@extends('layouts.courier')
@section('pageTitle')
    <?php setlocale(LC_TIME, 'id_ID.utf8', 'Indonesian_indonesia.1252'); ?>
    <section class="page-title bg-dark">
        <div class="container">
            <div class="page-title-row">
                <div class="page-title-content">
                    <span class="text-light">Uang Saku</span>
                    <h1 class="text-white">Rp
                        {{ number_format(Auth::guard('courier')->user()->operationalFee, 0, ',', '.') }}
                    </h1>
                    <button class="button button-border button-rounded button-dirtygreen mt-2">Tarik Uang</button>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('content')
    <div id="map" style="height: 360px" class="mb-4"></div>
    <div class="ongoing-order">
        <h1>Pesanan Sedang Diambil</h1>
        <div class="row g-4 mb-5 mt-0 text-center section p-4 rounded">
            <span>Belum ada pesanan diambil</span>
        </div>
    </div>
    <div class="new-order">
        <h1>Pesanan Baru</h1>
        <div class="row g-4 mb-5 mt-0 section p-4 rounded text-center">
            @if (count($newDeliveries) == 0)
                <span>Tidak ada pesanan baru</span>
            @endif
            @foreach ($newDeliveries as $delivery)
                <article class="entry event col-12 mb-4">
                    <div
                        class="grid-inner bg-white row g-0 p-3 border-0 rounded-5 shadow-sm h-shadow all-ts h-translate-y-sm">
                        <div class="col-md-8 p-4">
                            <div class="entry-meta no-separator mb-1 mt-0">
                                <ul>
                                    <li>
                                        <span
                                            class="text-uppercase fw-medium">{{ strftime('%A, %d %B %Y', strtotime($delivery->start_date)) }}</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="entry-title">
                                <h3 class="text-start"><a>{{ $delivery->order->orderID }}</a></h3>
                            </div>
                            <div class="entry-meta no-separator">
                                <ul>
                                    <li><a class="fw-normal"><i class="uil uil-map-marker"></i>
                                            {{ $delivery->order->destination_address }}</a></li>
                                </ul>
                            </div>
                            <div class="entry-content my-3 text-start">
                                <button
                                    class="button button-border button-rounded button-aqua button-fill btnDetailDelivery"
                                    data-bs-toggle="modal" data-bs-target="#exampleModal"
                                    data-di="{{ $delivery->order_id }}"><i
                                        class="fa-solid fa-book"></i><span>Details</span></button>
                                <button class="button button-border button-rounded button-green button-fill"
                                    data-di="{{ $delivery->order_id }}"><i class="fa-solid fa-truck-fast"></i><span>Take
                                        Order</span></button>
                            </div>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <hr style="margin-top: 0px">
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="orderNumber" class="col-sm-3 col-form-label">Nomor Pesanan</label>
                        <div class="col-sm-9">
                            <label for="orderNumber" class="col-form-label">:&nbsp;OD1294374837</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="destination" class="col-sm-3 col-form-label">Alamat Toko</label>
                        <div class="col-sm-9">
                            <label for="destination" class="col-form-label">:&nbsp;Jalan Ahmad Yani</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="destination" class="col-sm-3 col-form-label">Alamat Tujuan</label>
                        <div class="col-sm-9">
                            <label for="destination" class="col-form-label">:&nbsp;Jalan Ahmad Yani</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('js/courier-home.js') }}"></script>
@endsection
