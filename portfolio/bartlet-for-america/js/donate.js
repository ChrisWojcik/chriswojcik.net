$(document).ready(function() {
    $('#otheramount').change(function() {
        $('#amount-list').find("input:checked").prop('checked',false);
    });
    $('#amount-list input:radio').change(function() {
        $('#otheramount').val('');
    });
});