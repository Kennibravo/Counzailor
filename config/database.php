<?php
// mysql://b1d8eb5ef5c949:ef2666a5@us-cdbr-east-04.cleardb.com/heroku_9311dc1e385daf4?reconnect=true
return [

   'default' => 'mysql',

   'connections' => [
        'mysql' => [
            'driver'    => 'mysql',
            'host'      => env('DB_HOST', 'us-cdbr-east-04.cleardb.com'),
            'port'      => env('DB_PORT', 3306),
            'database'  => env('DB_DATABASE', 'heroku_9311dc1e385daf4'),
            'username'  => env('DB_USERNAME', 'b1d8eb5ef5c949'),
            'password'  => env('DB_PASSWORD', 'ef2666a5'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
         ],

        'mysql2' => [
            'driver'    => 'mysql',
            'host'      => env('DB2_HOST'),
            'port'      => env('DB_PORT'),
            'database'  => env('DB2_DATABASE'),
            'username'  => env('DB2_USERNAME'),
            'password'  => env('DB2_PASSWORD'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
        ],
    ],
];
