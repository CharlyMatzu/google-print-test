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
                message.text( error.responseText );
            },
            complete: function(response){
                message.removeClass("alert-warning");
                console.log( response );
            }
        }); // end ajax
    
    });

    $('.btn-set-printer').on('click', function (event) {
        let printerId = $(event.target).data('printer-id');

        // send request
        $.ajax({
            url:    '/api/print/set',
            method: 'POST',
            data: { 'printerId': printerId },
            beforeSend: function(){
                $('.btn-set-printer').attr("disabled", true)
            },
            success: function(response){
                location.reload();
            },
            error: function(error){
                // console.log(error);
            },
            complete: function(response){
                console.log( response );
            }
        }); // end ajax
    })

});

// TEMP
function simulate() {
    let document = $('#inputDoc').val();
    sendNotify( document );
}


function sendNotify(documentURL) {
    if( documentURL === undefined )
        alert("Document URL missing");

    let status = $('#signalr-status');
    // send request
    $.ajax({
        url:    '/api/print/submit',
        method: 'POST',
        data: { 'document': documentURL },
        beforeSend: function(){
            status.html('<p class="alert alert-warning">SENDING</p>');
        },
        success: function(response){
            status.html('<p class="alert alert-success">SUCCESS. Refresh Page to</p>');
        },
        error: function(error){
            status.html('<p class="alert alert-danger">ERROR. '+ error.responseText +'</p>');
        },
        complete: function(response){
            console.log( response );
            setTimeout( () => { status.html(""); }, 5000);
        }
    }); // end ajax

}