<?php

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

require_once('site/controllers/Newsletter/NewsletterController.php');

c::set('license', 'put your license key here');

c::set('debug', true);

c::set('markdown.extra', true);

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

$routes = [
    [
        'pattern' => '(?:([a-z]{2})/?)?newsletter/(:alpha)/(:any?)',
        'action' => function($lang, $action, $data = null) {
            // Action
            $action = strtolower(trim($action));
            // Controller laden
            $controller = new NewsletterController($lang, $data);
            if (method_exists($controller, $action)) {
                return $controller->{$action}();
            }
            return site()->visit('error', $lang);
        },
        'method' => 'GET|POST'
    ]
];

c::set('routes', $routes);
include('routes.php');
