
let connection;
let host    = 'http://localhost:1934';
// let host  = 'http://1d95adcc.ngrok.io';
setConnection( host, true );


/**
 * 
 * @param {String} hostUrl 
 * @param {boolean} retry 
 */
function setConnection(hostUrl, retry){

    // setting up
    let connection = new signalR.HubConnectionBuilder()
        .withUrl(hostUrl + '/NotificationHub')
        .configureLogging(signalR.LogLevel.Information)
        .build();

    // Connect
    connection.start()
        .then( function () {
            console.log("Connected");
        })
        .catch(function ( err ) {
            console.error( err.toString() +" - "+ host );
            // re-try connection
            if( retry ){
                console.log('trying to connect to ' + host);
                setConnection(host, false);
            }
        });

    //Listen notifications
    connection.on("NotificationPrint", ( url ) => {
        console.log("Recibido");
        $('#notificaciones').append('<div class="item-mensaje">' +url+ '</div>')
    });
}

