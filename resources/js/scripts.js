$(function() {


    /**
     * Driver
     */
    var init = function() {

        fade_out_alerts();

    };


    /**
     * Flash alert notifications
     */
    var fade_out_alerts = function() {

        $('.alert').not('.alert-important').delay(3000).slideUp(300);

    };


    // let's get it started
    init();

});
