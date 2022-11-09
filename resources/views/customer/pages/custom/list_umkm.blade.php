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
                <h1>List UMKM</h1>
                <nav class="d-flex align-items-center">
                    <a href="/">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="#">UMKM</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

<section class="blog_area single-post-area section_gap">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 posts-list">
                <div class="comments-area" style="margin-top:0px;">
                    <h4>UMKM Avaiable</h4>
                    @forelse($umkm as $item)
                    <div class="comment-list">
                        <div class="single-comment justify-content-between d-flex">
                            <div class="user justify-content-between d-flex">
                                <div class="desc">
                                    <h5>
                                        <a href="{{ route('contact.show',[$item->id_umkm]) }}" target="_blank">
                                            {{ $item->umkm_name }}&nbsp;({{ $item->alias }}),&nbsp;
                                            <span hidden>
                                                {{ $waktu = Carbon\Carbon::now()->addHours($item->jumlah); }}
                                            </span>
                                            @if($item->jumlah >= 24)
                                            <small>
                                                Jam Operasi Toko : ( {{
                                                \Carbon\Carbon::createFromFormat('H:i:s',$item->open_time)
                                                ->format('h:i A') }} - {{
                                                \Carbon\Carbon::createFromFormat('H:i:s',$item->close_time)
                                                ->format('h:i A') }} )<br>
                                                Durasi Pengerjaan : {{ $item->jumlah/24 }}
                                                &nbsp;Hari {{ $item->jumlah%24 }}&nbsp;Jam
                                            </small>
                                            @else
                                            <small>
                                                Jam Operasi Toko : ( {{
                                                \Carbon\Carbon::createFromFormat('H:i:s',$item->open_time)
                                                ->format('h:i A') }} - {{
                                                \Carbon\Carbon::createFromFormat('H:i:s',$item->close_time)
                                                ->format('h:i A') }} )<br>
                                                Durasi Pengerjaan : {{ $item->jumlah%24 }}&nbsp;Jam
                                            </small>
                                            @endif
                                        </a>
                                    </h5>
                                    <input type="text" value="{{ $item->umkm_name }}" name="umkm_name" hidden>
                                    <p class="date">Estimasi Selesai : {{ $waktu }}</p>
                                    <p class="comment">
                                        Kontak UMKM :&nbsp;
                                        <span class="fa fa-phone">
                                            <a href="https://wa.me/{{ $item->phone }}" target="_blank">
                                                {{ $item->phone }}
                                            </a>
                                        </span>
                                    </p>
                                </div>
                            </div>
                            @if(auth()->user())
                            <div class="reply-btn">
                                <a href="/custom/order/{{ Crypt::encrypt($item->umkm_name) }}"
                                    class="btn-reply text-uppercase">
                                    Order Now!
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="comment-list">
                        <div class="single-comment justify-content-between d-flex">
                            <p>Tidak Ada UMKM</p>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>
@endsection