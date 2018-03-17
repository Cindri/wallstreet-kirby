<?php
require_once __ROOT__ . '/controllers/Newsletter/NewsletterController.php';

c::set('routes', [
    // Ajax-Route für Galerien
    [
        'pattern' => '(?:(en)/)?(:any)/(:any)/ajax',
        'action' => function($lang, $galleriesUid, $galleryUid) {
            if (empty($lang)) {
                $lang = 'de';
            }
            $data = [
                'ajax' => true
            ];
            $page = site()->visit($galleriesUid . '/' . $galleryUid, $lang);
            return [$page, $data];
        }
    ],
    // Newsletter-Routes
    [
        'pattern' => '(?:([a-z]{2})/?)?newsletter/(:alpha)/(:any?)',
        'action' => function($lang, $action, $data = null) {
            if (empty($lang)) {
                $lang = 'de';
            }
            $action = trim($action) . 'Action';
            // Controller laden
            $controller = new NewsletterController($lang, $data);
            if (method_exists($controller, $action)) {
                return $controller->{$action}();
            }
            return site()->visit('error', $lang);
        },
        'method' => 'GET|POST'
    ]
]);