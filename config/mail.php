<?php

return [

    /*
    |--------------------------------------------------------------------------
    | MAIL Driver
    |--------------------------------------------------------------------------
    |
    | Laravel supports both SMTP and PHP's "MAIL" function as drivers for the
    | sending of e-MAIL. You may specify which one you're using throughout
    | your application here. By default, Laravel is setup for SMTP MAIL.
    |
    | Supported: "smtp", "sendMAIL", "MAILgun", "MAIL", "ses",
    |            "sparkpost", "log", "array"
    |
    */

    'driver' => env('MAIL_DRIVER', 'smtp'),

    /*
    |--------------------------------------------------------------------------
    | SMTP Host Address
    |--------------------------------------------------------------------------
    |
    | Here you may provide the host address of the SMTP server used by your
    | applications. A default option is provided that is compatible with
    | the MAILgun MAIL service which will provide reliable deliveries.
    |
    */

    'host' => env('MAIL_HOST', 'smtp.mailgun.org'),

    /*
    |--------------------------------------------------------------------------
    | SMTP Host Port
    |--------------------------------------------------------------------------
    |
    | This is the SMTP port used by your application to deliver e-MAILs to
    | users of the application. Like the host we have set this value to
    | stay compatible with the MAILgun e-MAIL application by default.
    |
    */

    'port' => env('MAIL_PORT', 587),

    /*
    |--------------------------------------------------------------------------
    | Global "From" Address
    |--------------------------------------------------------------------------
    |
    | You may wish for all e-MAILs sent by your application to be sent from
    | the same address. Here, you may specify a name and address that is
    | used globally for all e-MAILs that are sent by your application.
    |
    */

    'from' => [
        'address' => env('MAIL_ADDRESS', 'elementalbolivia@gmail.com'),
        'name' => env('MAIL_NAME', 'Elemental'),
    ],

    /*
    |--------------------------------------------------------------------------
    | E-MAIL Encryption Protocol
    |--------------------------------------------------------------------------
    |
    | Here you may specify the encryption protocol that should be used when
    | the application send e-MAIL messages. A sensible default using the
    | transport layer security protocol should provide great security.
    |
    */

    'encryption' => env('MAIL_ENCRYPTION', 'tls'),

    /*
    |--------------------------------------------------------------------------
    | SMTP Server Username
    |--------------------------------------------------------------------------
    |
    | If your SMTP server requires a username for authentication, you should
    | set it here. This will get used to authenticate with your server on
    | connection. You may also set the "password" value below this one.
    |
    */

    'username' => env('MAIL_USERNAME'),

    'password' => env('MAIL_PASSWORD'),

    /*
    |--------------------------------------------------------------------------
    | SendMAIL System Path
    |--------------------------------------------------------------------------
    |
    | When using the "sendMAIL" driver to send e-MAILs, we will need to know
    | the path to where SendMAIL lives on this server. A default path has
    | been provided here, which will work well on most of your systems.
    |
    */

    'sendmail' => '/usr/sbin/sendmail -bs',

    /*
    |--------------------------------------------------------------------------
    | Markdown MAIL Settings
    |--------------------------------------------------------------------------
    |
    | If you are using Markdown based eMAIL rendering, you may configure your
    | theme and component paths here, allowing you to customize the design
    | of the eMAILs. Or, you may simply stick with the Laravel defaults!
    |
    */

    'markdown' => [
        'theme' => 'default',

        'paths' => [
            resource_path('views/vendor/mail'),
        ],
    ],

];
