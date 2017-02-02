/**
 * Created by mohamed on 2017/01/29.
 */
/* print button */
$('#btnPrint').on('click', function () {
    $('#mycontainer').removeClass('hidden-print');

    window.print();
});