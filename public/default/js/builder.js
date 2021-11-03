$(document).ready(function () {
    $("#type-table, #type-schema").on('click', function () {
        $("#wish-view-update").attr("disabled", false);
        $("#wish-view-grid").attr("disabled", false);
    });
    
    $("#type-create").on('click', function () {
        $("#wish-view-update").prop('checked',false);
        $("#wish-view-grid").prop('checked',false);
        $("#wish-view-update").attr("disabled", true);
        $("#wish-view-grid").attr("disabled", true);
    });
});
