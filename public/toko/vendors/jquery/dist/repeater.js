var FormRepeater = function () {
    return {
        //main function to initiate the module
        init: function () {
        $(".tambah").on("click", function() {
            // alert('test');
            var tambah = $(".item-clone").clone();
            tambah.removeClass("item-clone");
            tambah.appendTo('#form-repeater');
        }) 

            $("body").on("click", ".remove-repeater", function () {
                // alert('tod');
                if (confirm('Apakah anda yakin ?')) {
                    $(this).parents(".master-clone").remove();
                }
                // $(this).parents('.items').remove()
                // var remove = $(".item-clone").remove();
                // remove.removeClass("item-clone");
                // console.log('test');
        })
        }
    };
}();

jQuery(document).ready(function() {
    FormRepeater.init();
});