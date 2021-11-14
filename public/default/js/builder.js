$(document).ready(function () {
    $("#wish-view-grid").prop("disabled", true);
        
    $('#type-table').on('click', function(){
        $('#tables').prop('disabled', false);
        $('#schemas').prop('disabled', true);
        $('#create').prop('disabled', true);
        
        $("#wish-view-update").prop("disabled", false);
    });
    $('#type-schema').on('click', function(){
        $('#tables').prop('disabled', true);
        $('#schemas').prop('disabled', false);
        $('#create').prop('disabled', true);
        
        $("#wish-view-update").prop("disabled", false);
    });
    $('#type-create').on('click', function(){
        $('#tables').prop('disabled', true);
        $('#schemas').prop('disabled', true);
        $('#create').prop('disabled', false);
        console.log($('#schemas').prop('disabled'));
        
        $("#wish-view-update").prop('checked',false).prop("disabled", true);
    });
});
