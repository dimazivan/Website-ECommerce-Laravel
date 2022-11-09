var FormRepeaterNew = function () {
    return {
        //main function to initiate the module
        init: function () {
            $("body").on("change keyup", "#cbname, #cbsup, #qty, #price", function () {
                var price = $('#price').val();
                var qty = $('#qty').val();
                var sub = parseInt(price) * parseInt(qty);
                    
                var sub = $('#sub').val(sub);
                // console.log(total);
            });

            // Ambil Data Ajax
            $('#cbname').on('change', function(){
            // ambil data dari elemen option yang dipilih
            const price = $('#cbname option:selected').data('price');
            
            // tampilkan data ke element
            $('[name=price]').val(price);
            });

            // Save Data With AJAX

        }
    };
}();

jQuery(document).ready(function() {
    FormRepeaterNew.init();
});