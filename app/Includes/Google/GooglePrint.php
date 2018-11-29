<?php namespace App\Includes\Google;


class GooglePrint
{

    const SCOPE = 'https://www.googleapis.com/auth/cloudprint';

    //--------- DEVICE STATES
    // Device is ready to accept jobs. Self-testing, low power and all other
    // states in which the device can start processing newly submitted jobs
    // without user intervention should be mapped into this state.
    const IDLE = 0;

    // Processing jobs (e.g. printing).
    const PROCESSING = 1;

    // Device cannot process jobs. User should fix the problem to resume the
    // processing (e.g. printer is out of paper).
    const STOPPED = 2;
    // Device cloud connectivity state.
    const ONLINE = 'ONLINE';
    const UNKNOWN = 'UNKNOWN';
    const OFFLINE = 'OFFLINE';
    const DORMANT = 'DORMANT';

    // Print Job UI State
    const DRAFT         = 0;
    const QUEUED        = 1;
    const IN_PROGRESS   = 2;
    const PAUSED        = 3;
    const DONE          = 4;
    const CANCELLED     = 5;
    const ERROR         = 6;
    const EXPIRED       = 7;

    //-------------------- Document type and Formats
    const URL   = "url";
    const PDF   = "application/pdf";
    const JPEG  = "image/jpeg";
    const PNG   = "image/png";
    const HTML  = "text/html";
    const PLAIN = "text/plain";
    const POSTSCRIPT = "application/postscript";


    // COLOR
    const STANDARD_COLOR = 0;
    const STANDARD_MONOCHROME = 1;
    const CUSTOM_COLOR = 2;
    const CUSTOM_MONOCHROME = 3;
    const AUTO = 4;


    public static function makeTicket($color, $copies){
        return [
            "version" => "1.0",
            "print"   => [
                "vendor_ticket_item" => [],
                "color"  => ["type"   => $color],
                "copies" => ["copies" => $copies]
            ]
        ];
    }




}