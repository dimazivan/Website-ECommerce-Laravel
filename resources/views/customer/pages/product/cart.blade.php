@extends('customer.layouts.app')
@section('title')
{{ $title }}
@endsection
@section('content')
<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Shopping Cart</h1>
                <nav class="d-flex align-items-center">
                    <a href="/">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="#">Cart</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

<!--================Cart Area =================-->
<section class="cart_area">
    <div class="container">
        <div class="cart_inner">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Product Name (Umkm Name)</th>
                            <th scope="col">Price<small>/pcs</small></th>
                            <th scope="col" width="15%">Quantity (Pcs)</th>
                            <th scope="col" width="20%">SubTotal</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <form class="" action="{{ route('upd.cart') }}" method="post" validate
                            enctype="multipart/form-data">
                            @csrf
                            @forelse($page as $item)
                            <tr>
                                <td>
                                    <div class="media">
                                        <div class="d-flex">
                                            <img src="{{ url('/data_produk/'.$item->pict_products) }}"
                                                alt="{{ $item->pict_products }}"
                                                style="width:75px;height:75px;object-fit:cover;object-position:center">
                                        </div>
                                        <div class="media-body">
                                            <p><strong>{{ $item->products_name }}</strong>&nbsp;
                                                (<span style="color:green;">
                                                    {{ $item->umkm_name }}
                                                </span>)<br>
                                                <span>Ukuran&ensp;:</span>&ensp;{{ $item->size }}<br>
                                                <span>Warna&ensp;:</span>&ensp;{{ $item->color }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <h5>Rp. {{number_format($item->price,2,',','.')}}</h5>
                                </td>
                                <td>
                                    <div class="product_count">
                                        <input type="number" name="qty[]" maxlength="3" min="1" max="999"
                                            value="{{ $item->qty }}"
                                            onkeydown="return /[0-9, ,backspace,delete]/i.test(event.key)"> Pcs
                                    </div>
                                </td>
                                <td>
                                    <h5>Rp. {{number_format($item->subtotal,2,',','.')}}</h5>
                                </td>
                                <td>
                                    <!-- Delete -->
                                    <h5><a href="{{ route('del.cart', [$item->id]) }}">
                                            <i class="fa fa-times fa-lg"></i>
                                        </a>
                                    </h5>
                                </td>
                            </tr>
                            <input type="text" name="id[]" value="{{ $item->id }}" hidden>
                            <input type="text" name="created_at[]" value="{{ $item->created_at }}" hidden>
                            <input type="text" name="product_id[]" value="{{ $item->products_id }}" hidden>
                            <input type="text" name="detail_products_id[]" value="{{ $item->detail_products_id }}"
                                hidden>
                            <input type="text" name="product_name[]" value="{{ $item->products_name }}" hidden>
                            <input type="text" name="product_size[]" value="{{ $item->size }}" hidden>
                            <input type="text" name="product_category[]" value="{{ $item->category }}" hidden>
                            <input type="text" name="product_color[]" value="{{ $item->color }}" hidden>
                            <input type="text" name="product_price[]" value="{{ $item->price }}" hidden>
                            <input type="text" name="product_sub[]" value="{{ $item->subtotal }}" hidden>
                            <!-- <input type="text" name="product_qty[]" value="{{ $item->qty }}"hidden> -->
                            <input type="text" name="product_umkm_id[]" value="{{ $item->umkms_id }}" hidden>
                            <input type="text" name="product_umkm_name[]" value="{{ $item->umkm_name }}" hidden>
                            @empty
                            <tr>
                                <td colspan="6">
                                    <p>Keranjang Anda Kosong...</p>
                                </td>
                            </tr>
                            @endforelse
                            @if(!empty($page[0]))
                            <tr class="bottom_button">
                                <td>
                                    <input type="submit" value="Update Cart" class="btn gray_btn">
                                </td>
                                <td colspan="3">
                                    @if(!empty($promo[0]))
                                    <b>
                                        Kode Promo : "{{ $promo[0]->kode_promo }}" ({{ $promo[0]->nama_promo }})<br>
                                        <span style="color:green;">
                                            @if($item->jumlah <= 100) Potongan : {{ $promo[0]->jumlah_promo }}%
                                                @else
                                                Potongan : Rp. {{number_format($promo[0]->jumlah_promo,2,',','.')}}
                                                @endif

                                        </span>
                                    </b>
                                    @endif
                                </td>
                                <td>
                                    <div class="cupon_text d-flex align-items-right float-right">
                                        <input type="text" name="code_coupon" placeholder="Kode Promo (Angka)"
                                            onkeydown="return /[0-9, ,backspace,delete]/i.test(event.key)">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                                <td>
                                    <h5>Total</h5>
                                </td>
                                <td>
                                    <h5>Rp. {{number_format($total,2,',','.')}}</h5>
                                </td>
                            </tr>
                            @endif
                            <tr class="out_button_area">
                                <td colspan="5">
                                    <div class="checkout_btn_inner d-flex align-items-center float-right">
                                        @if(!empty($page[0]))
                                        <a class="gray_btn" href="/shop" target="_blank">Continue Shopping</a>
                                        <a class="primary-btn" href="/cart/create">Proceed to checkout</a>
                                        @else
                                        <a class="gray_btn" href="/shop">Back to Shop</a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        </form>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- <script>
        function fungsihidden() {
            var x = document.getElementById("close");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        }
    </script> -->
</section>

<!--================End Cart Area =================-->

@endsection