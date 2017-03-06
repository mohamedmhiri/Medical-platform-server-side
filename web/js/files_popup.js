/**
 * Created by mohamed on 2016/11/13.
 */
$('.trigger').on('click', function() {
    $('.modal-wrapper').toggleClass('open');
    $('.page-wrapper').toggleClass('blur-it');
    return false;
});