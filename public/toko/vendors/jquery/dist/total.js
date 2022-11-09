var total = function () {
    return {
        init: function () {
            $("body").on("change keyup", "#sub, #ongkir, #pajak", function () {
                // alert('tod');
                var sub = $('#sub').val();
                var ongkir = $('#ongkir').val();
                var pajak = $('#pajak').val();
                var total = parseInt(sub) + parseInt(ongkir) + parseInt(pajak);
                    
                var totald = $('#total').val(total);
                // console.log(total);
            });
        }
    };
}();

jQuery(document).ready(function() {
    total.init();
});