var CopyCode = function () {
    return {
        //main function to initiate the module
        init: function () {
            $("body").on("click", ".tombol-code", function () {
                // alert('tod');
                var code = $(this).parents('.reply-btn').find('.kupon').val();
                // var code = $(this).parents(".kupon").val();

                navigator.clipboard.writeText(code);
                alert("Copied the code: " + code);
            })

            // function copyToClipboard(element) {
            //     var $temp = $("<input>");
            //     $("body").append($temp);
            //     $temp.val($(element).text()).select();
            //     document.execCommand("copy");
            //     $temp.remove();
            // }
        }
    };
}();

jQuery(document).ready(function() {
    CopyCode.init();
});