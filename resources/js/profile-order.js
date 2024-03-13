import $ from "jquery";
import moment from "moment/moment";
import "moment/locale/id";

$(function () {
    $(".nav-link-profile").removeClass("active");
    $("#v-tabs-order-tab-lg").addClass("active");
    $("#v-tabs-order-tab").addClass("active");

    const csrfToken = $('meta[name="csrf-token"]').attr("content");

    let formatter = new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 0,
        maximumFractionDigits: 0,
    });

    const baseUrl = window.location.protocol + "//" + window.location.host;

    $(document).on("click", ".btn-profile-order-detail", function () {
        const orderID = $(this).attr("data-di");
        $("#modalTitle").html("Rincian Pesanan");
        $("#modalFooter").html(`
        <button type="button" class="btn btn-secondary btnCloseModal" data-bs-dismiss="modal">Tutup</button>`);
        $.ajax({
            type: "POST",
            url: "/profile/order/detail",
            data: {
                _token: csrfToken,
                orderID: orderID,
            },
            success: function (response) {
                const order = response;
                let riwayatPesanan = `
                    <tr>
                        <td>${moment(order.order_date).format(
                            "dddd, D MMMM YYYY"
                        )}</td>
                        <td>Pesanan pertama kali dibuat</td>
                    </tr>`;

                let products = ``;
                if (order.accept_date) {
                    riwayatPesanan += `
                        <tr>
                            <td>${moment(order.accept_date).format(
                                "dddd, D MMMM YYYY"
                            )}</td>
                            <td>Pesanan diterima oleh seller</td>
                        </tr>
                    `;
                }
                if (order.cancel_date) {
                    riwayatPesanan += `
                        <tr>
                            <td>${moment(order.cancel_date).format(
                                "dddd, D MMMM YYYY"
                            )}</td>
                            <td>Pesanan dibatalkan oleh seller</td>
                        </tr>
                    `;
                }
                if (order.deliveries.length > 0) {
                    const delivery = order.deliveries;
                    riwayatPesanan += `
                        <tr>
                            <td>${moment(delivery.start_date).format(
                                "dddd, D MMMM YYYY"
                            )}</td>
                            <td>Pesanan telah ditugaskan kepada kurir</td>
                        </tr>
                    `;

                    if (delivery.pickup_date != null) {
                        riwayatPesanan += `
                        <tr>
                            <td>${moment(order.pickup_date).format(
                                "dddd, D MMMM YYYY"
                            )}</td>
                            <td>Pesanan telah diambil dari toko dan sedang dalam perjalanan menuju ${
                                order.destination_address
                            }</td>
                        </tr>
                        `;

                        if (delivery.arrive_date != null) {
                            riwayatPesanan += `
                                <tr>
                                    <td>${moment(order.arrive_date).format(
                                        "dddd, D MMMM YYYY"
                                    )}</td>
                                    <td>Pesanan telah sampai di tujuan pada ${
                                        order.destination_address
                                    }.</td>
                                </tr>
                            `;
                        }
                    }
                }

                for (const iterator of order.details) {
                    products += `
                        <tr>
                            <td><img src="${baseUrl}/productimages/${iterator.product.images[0].name}" style="width:40px;height:40px;object-fit:cover;"></img></td>
                            <td>${iterator.product.name}</td>
                            <td>${iterator.qty}</td>
                            <td>${iterator.price}</td>
                        </tr>
                    `;
                }

                $("#modalBody").html(`
                <div class="row">
                        <div class="form-group col-6">
                            <label for="orderNumber"><b>Order ID:&nbsp;</b></label>
                            <div>
                                <label for="orderNumber">${
                                    order.orderID
                                }</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="orderNumber"><b>Nama Toko:&nbsp;</b></label>
                            <div>
                                <label for="orderNumber">${
                                    order.shop.name
                                }</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="orderNumber"><b>Kontak Toko:&nbsp;</b></label>
                            <div>
                                <label for="orderNumber">${
                                    order.shop.phoneNumber
                                }</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="orderNumber"><b>Jenis Pembayaran:&nbsp;</b></label>
                            <div>
                                <label for="orderNumber">${
                                    order.payment_method == "cod"
                                        ? "Bayar di tempat (COD)"
                                        : "Saldo"
                                }</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="orderNumber"><b>Alamat Toko:&nbsp;</b></label>
                            <div>
                                <label for="orderNumber">${
                                    order.shop.address
                                }</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="orderNumber"><b>Alamat Tujuan:&nbsp;</b></label>
                            <div>
                                <label for="orderNumber">${
                                    order.destination_address
                                }</label>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h1>Riwayat Pesanan</h1>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${riwayatPesanan}
                        </tbody>
                    </table>
                    <hr>
                    <h1>Barang Pesanan</h1>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Gambar</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${products}
                            </tbody>
                        </table>
                    </div>
                    <div class="order-info text-end mt-2">
                        <h5>${formatter.format(order.subtotal)}</h5>
                        <h5>${formatter.format(order.shippingFee)}</h5>
                        <h2>${formatter.format(order.total)}</h2>
                    </div>
                `);
            },
        });
    });
});
