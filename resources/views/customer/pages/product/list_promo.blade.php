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
                <h1>List Promo</h1>
                <nav class="d-flex align-items-center">
                    <a href="/">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="#">Promo</a>
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
                    <h4>Promo Avaiable</h4>
                    @forelse($promo as $item)
                    <div class="comment-list">
                        <div class="single-comment justify-content-between d-flex">
                            <div class="user justify-content-between d-flex">
                                <div class="desc">
                                    <h5>
                                        <a href="#">
                                            {{ $item->name }}
                                            <small style="color:green;">
                                                ({{ $item->umkm_name }})
                                            </small>
                                        </a>
                                    </h5>
                                    <p class="date">Berlaku mulai :&nbsp;{{ $item->create_date }}</p>
                                    @if($item->jumlah <= 100) <p class="comment">
                                        Kode : "{{ $item->kode }}"<br>
                                        Potongan senilai :&nbsp; {{ $item->jumlah }}&nbsp;%
                                        </p>
                                        @else
                                        <p class="comment">
                                            Kode : "{{ $item->kode }}"<br>
                                            Potongan senilai :&nbsp;Rp. {{number_format($item->jumlah,2,',','.')}}
                                        </p>
                                        @endif
                                </div>
                            </div>
                            <div class="reply-btn">
                                <input type="text" value="{{ $item->kode }}" id="code{{ $item->kode }}" class="kupon"
                                    hidden>
                                <!-- <span id='c' class="code"><span>{{ $item->code }}</span></span> -->
                                <!-- <code>{{ $item->kode }}</code> -->
                                <!-- <button class="btn-reply text-uppercase" id="copy">Copy Code</button> -->
                                <!-- <button class="btn-reply text-uppercase" onclick="copyToClipboard(this)">
                                    Copy Code
                                </button> -->
                                <button class="btn-reply text-uppercase tombol-code">Copy Code</button>
                                <!-- <button class="btn-reply text-uppercase tombol-code"
                                    onclick="copyToClipboard('#{{ $item->kode }}')">
                                    Copy Code
                                </button> -->
                                <!-- <button class="btn-reply text-uppercase" onclick="copycode(id = ${{ $item->kode }});">
                                    Copy Code
                                </button> -->
                                <!-- <button class="fw-code-copy-button">Copy Code</button> -->
                                <!-- <span class="fw-code-copy-button">Copy Code</span> -->
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="comment-list">
                        <div class="single-comment justify-content-between d-flex">
                            <p>Tidak Ada Promo</p>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function copycode(id) {
        var copyText = document.getElementById("code" + id);

        copyText.select();
        copyText.setSelectionRange(0, 99999);

        navigator.clipboard.writeText(copyText.value);

        alert("Copied the code: " + copyText.value);
    }

    // function copymycode(id) {
    //     var r = document.createRange();
    //     r.selectNode(document.getElementById(id));
    //     window.getSelection().removeAllRanges();
    //     window.getSelection().addRange(r);
    //     document.execCommand('copy');
    //     window.getSelection().removeAllRanges();
    // }

    // function copyToClipboard(element) {
    //     var $temp = $("<input>");
    //     $("body").append($temp);
    //     $temp.val($(element).text()).select();
    //     document.execCommand("copy");
    //     $temp.remove();
    // }

    // new Clipboard(".fw-code-copy-button", {
    //     text: function(trigger) {
    //         return $(trigger).parent().find('code').first().text().trim();
    //     }
    // });

    // document.querySelector('#copy').addEventListener('click', () => {
    //     navigator.clipboard.writeText(document.querySelector('#code').value)
    //         .then(() => {
    //             alert('Code coupon copied.');
    //         })
    //         .catch(() => {
    //             Alert('Failed to copy ');
    //         });
    // });

    // function copyToClipboard(element) {
    //     var $temp = $("<input>");
    //     $("body").append($temp);
    //     $temp.val($(element).parents('.reply-btn').find('.code span').text()).select();
    //     document.execCommand("copy");
    //     $temp.remove();
    // }
</script>
@endsection