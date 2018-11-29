$(document).ready(function () {

    // Login submit
    $('#login-form').submit(function (event) {
        event.preventDefault();
        let login = {
            'user': $('#login-form #inputUser').val(),
            'pass': $('#login-form #inputPass').val()
        };
        let message = $('#login-message');

        // send request
        $.ajax({
            url:    '/api/login',
            method: 'POST',
            data: login,
            beforeSend: function(){
                // TODO: remove and create element
                message.text("Loading....");
                message.addClass("alert-warning");
                message.removeClass("d-none");
            },
            success: function(response){
                message.addClass("alert-success");
                message.text("Success, Redirecting...");
                // redirect
                window.location.href = '/dashboard/jobs';
            },
            error: function(error){
                message.addClass("alert-danger");
                message.text( error.responseJSON.Message );
            },
            complete: function(response){
                message.removeClass("alert-warning");
                console.log( response );
            }
        }); // end ajax
    
    });


});
