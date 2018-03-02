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
    if ($language->default()) {
        // Normale Route
        $newRoute = [];
        $newRoute['pattern'] = $galleryPage->urlKey($language->code()) . '/(:any)';
        $newRoute['action'] = function($gallery) use ($galleryPage, $language) {
            $l10nGalleryPageName = $galleryPage->urlKey();
            $data = [
                'selectedGallery' => $gallery
            ];
            site()->visit($l10nGalleryPageName, $language->code());
            return array($l10nGalleryPageName, $data);
        };
        $routes[] = $newRoute;

        // AJAX Route
        $newRoute['pattern'] = $galleryPage->urlKey($language->code()) . '/(:any)/ajax';
        $newRoute['action'] = function($gallery) use ($galleryPage, $language) {
            $l10nGalleryPageName = $galleryPage->urlKey($language->code());
            return site()->visit($l10nGalleryPageName . '/' . $gallery, $language->code());
        };
        $routes[] = $newRoute;

    } else {
        // Normale Route
        $newRoute = [];
        $newRoute['pattern'] = $language->code() . '/' . $galleryPage->urlKey($language->code()) . '/(:any)';
        $newRoute['action'] = function($gallery) use ($galleryPage, $language) {
            $l10nGalleryPageName = $galleryPage->urlKey();
            $data = [
                'selectedGallery' => $gallery
            ];
            site()->visit($l10nGalleryPageName, $language->code());
            return array($l10nGalleryPageName, $data);
        };
        $routes[] = $newRoute;

        // AJAX Route
        $newRoute = [];
        $newRoute['pattern'] = $language->code() . '/' . $galleryPage->urlKey($language->code()) . '/(:any)/ajax';
        $newRoute['action'] = function($gallery) use ($galleryPage, $language) {
            $l10nGalleryPageName = $galleryPage->urlKey($language->code());
            return site()->visit($l10nGalleryPageName . '/' . $gallery, $language->code());
        };
        $routes[] = $newRoute;
    }
}

c::set('routes', $routes);
