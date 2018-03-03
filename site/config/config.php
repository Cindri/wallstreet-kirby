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
        'default' => true,
        'locale'  => 'de_DE',
        'url'     => '/',
    ],
    [
        'code'    => 'en',
        'name'    => 'English',
        'locale'  => 'en_US',
        'url'     => '/en',
    ]
]);

$site = site();
/** @var Page $galleryPage */
$galleryPage = $site->pages()->find('galerien');


$routes = [];

foreach ($site->languages() as $language) {

    // Normale Route
    $pattern = $galleryPage->urlKey($language->code()) . '/(:any)';
    $action = function($gallery) use ($galleryPage, $language) {
        $l10nPage = $galleryPage->urlKey();
        $data = [
            'selectedGallery' => $gallery,
            'ajax' => false
        ];
        site()->visit($l10nPage, $language->code());
        return [$l10nPage, $data];
    };

    $newRoute['pattern'] = $pattern;
    $newRoute['action'] = $action;
    if (!$language->default()) {
        $newRoute['pattern'] = $language->code() . '/' . $pattern;
    }
    $routes[] = $newRoute;

    // AJAX Route
    $pattern = $pattern . '/ajax';
    $ajaxAction = function($gallery) use ($galleryPage, $language) {
        $l10nGalleryPageName = $galleryPage->urlKey($language->code());
        $l10nPage = $l10nGalleryPageName . '/' . $gallery;
        $data = [
            'ajax' => true
        ];
        $page = site()->visit($l10nPage, $language->code());
        return [$page, $data];
    };
    $newRoute['pattern'] = $pattern;
    $newRoute['action'] = $ajaxAction;
    if (!$language->default()) {
        $newRoute['pattern'] = $language->code() . '/' . $pattern;
    }
    $routes[] = $newRoute;

}

c::set('routes', $routes);
