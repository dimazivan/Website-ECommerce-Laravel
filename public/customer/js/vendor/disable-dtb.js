var Disbledtb = function () {
    return {
        //main function to initiate the module
        init: function () {
            // $('#datatable-buttons').dataTable({
            //     "destroy": true,
            //     "order": [[3, 'asc']]
            // });

            // $("#datatable-buttons").dataTable().clear();
            // $("#datatable-buttons").dataTable().destroy();
            // $("#datatable-buttons").dataTable().remove();
            // $("#datatable-buttons").dataTable().empty();
        }
    };
}();

jQuery(document).ready(function() {
    Disbledtb.init();
});