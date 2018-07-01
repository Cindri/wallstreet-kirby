<?php

define('__ROOT__', dirname(dirname(__FILE__)));

/*

---------------------------------------
License Setup
---------------------------------------

Please add your license key, which you've received
via email after purchasing Kirby on http://getkirby.com/buy

It is not permitted to run a public website without a
valid license key. Please read the End User License Agreement
for more information: http://getkirby.com/license

*/

c::set('license', 'K2-PRO-f67008aa16f6cc80204e754e973aa12b');

c::set('markdown.extra', true);

c::set('debug', true);



// Einstellungen Newsletter-System

c::set('owner', [
    'mail' => 'info@wallstreet-hamilton.de',
    'company' => 'Wallstreet im Hamilton',
    'prename' => 'Frank',
    'surname' => 'Schweikart'
]);

c::set('admin', [
    'mail' => 'd.peter@panten.de',
    'company' => 'Panten GmbH',
    'prename' => 'David',
    'surname' => 'Peter'
]);

/*

---------------------------------------
Kirby Configuration
---------------------------------------

By default you don't have to configure anything to
make Kirby work. For more fine-grained configuration
of the system, please check out http://getkirby.com/docs/advanced/options

*/

c::set('languages', [
    [
        'code'    => 'de',
        'name'    => 'Deutsch',
        'locale'  => 'de_DE',
        'url'     => '/',
        'default' => true
    ],
    [
        'code'    => 'en',
        'name'    => 'English',
        'locale'  => 'en_US',
        'url'     => '/en'
    ]
]);

include('routes.php');

include('hooks.php');
