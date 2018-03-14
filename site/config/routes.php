<?php

$pattern = '(?:(en)/)?(:any)/(:any)/ajax';

c::set('routes', [
    [
        'pattern' => $pattern,
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
    ]
]);