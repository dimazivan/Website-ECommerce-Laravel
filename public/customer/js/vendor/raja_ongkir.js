var RajaOngkir = function () {
    return {
        //main function to initiate the module
        init: function () {
            // Ambil Data Ajax
            $('#cbumkm').on('change', function(){
                // ambil data dari elemen option yang dipilih
                const province = $('#cbumkm option:selected').data('province');
                const city = $('#cbumkm option:selected').data('city');
                
                // tampilkan data ke element
                $('[name=provinsiasal]').val(province);
                $('[name=kotaasal]').val(city);
                console.log(province);
                console.log(city);
            });

            // Ambil Kota
            // var BASE_URL = 'http://localhost:8000';
            $('#cbprovinsitujuan').on('change', function () {
                // alert('ahay');
                let provinceId = $(this).val();
                console.log(provinceId);
                if (provinceId) {
                    jQuery.ajax({
                        url: '/ongkir/' + provinceId,
                        // url: BASE_URL + "/ongkir/provinsi/" + provinceId,
                        // url: '/ongkir/provinsi/' + provinceId,
                        // url: "{{ route('ongkir.show',"+ provinceId +") }}",
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            $('#cbkotatujuan').empty();
                            $.each(data, function(id, nama) {
                                $('select[name="cbkotatujuan"]').append(
                                    '<option value="' + id + '">' + nama +
                                    '</option>');
                            });
                        },
                    });
                    // console.log(data);
                    // console.log(key);
                    // console.log(value);
                } else {
                    $('#cbkotatujuan').empty();
                }
            });
        }
    };
}();

jQuery(document).ready(function() {
    RajaOngkir.init();
});