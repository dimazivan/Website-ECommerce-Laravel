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
                    <h4>Portal Pembayaran Avaiable</h4>
                    @forelse($pembayaran as $item)
                    <div class="comment-list">
                        <div class="single-comment justify-content-between d-flex">
                            <div class="user justify-content-between d-flex">
                                <div class="desc">
                                    <div class="desc">
                                        <h5><a href="#">{{ $item->name }}&nbsp;({{ $item->umkm_name }})</a></h5>
                                        @if($item->created_date != null)
                                        <p class="date">Berlaku mulai :&nbsp;{{ $item->create_date }}</p>
                                        @endif
                                        <p class="comment">
                                            Nomor Rekening :&nbsp;{{ $item->number }}
                                        </p>
                                        <p class="comment">
                                            A/N :&nbsp;{{ $item->name_account }}
                                        </p>
                                        <p class="comment">
                                            Jenis Pembayaran :&nbsp;{{ $item->type }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="reply-btn">
                                <input type="text" value="{{ $item->number }}" id="code{{ $item->number }}"
                                    class="kupon" hidden>
                                <button class="btn-reply text-uppercase tombol-code">Copy Number</button>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="comment-list">
                        <div class="single-comment justify-content-between d-flex">
                            <p>Tidak Ada Portal Pembayaran</p>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function copycode() {
        /* Get the text field */
        var copyText = document.getElementById("code");

        /* Select the text field */
        copyText.select();
        copyText.setSelectionRange(0, 99999); /* For mobile devices */

        /* Copy the text inside the text field */
        navigator.clipboard.writeText(copyText.value);

        /* Alert the copied text */
        alert("Copied the code: " + copyText.value);
    }

    function copymycode(id) {
        var r = document.createRange();
        r.selectNode(document.getElementById(id));
        window.getSelection().removeAllRanges();
        window.getSelection().addRange(r);
        document.execCommand('copy');
        window.getSelection().removeAllRanges();
    }

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