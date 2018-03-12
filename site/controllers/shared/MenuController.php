<?php
// Menu Controller
/** @var \Kirby\Panel\Models\Site $site */
/** @var \Kirby\Panel\Models\Page[] $allPages */
/** @var \Kirby\Panel\Models\Page $seasonspecial */

$allPages = $site->children()->visible();
$mainPages = new Collection();

$actualDate = new \DateTime();

foreach ($allPages as $page) {

    // Display-Bedingung Season Specials
    if ($page->uid() == 'season-specials') {
        foreach ($page->children() as $seasonspecial) {
            $startDate = new \DateTime($seasonspecial->start_date());
            $endDate = new \DateTime($seasonspecial->end_date());
            if ($startDate <= $actualDate && $endDate > $actualDate) {
                $mainPages->append($page->num(), $page);
                break;
            }
        }
    }

    // Display-Bedingung Powerlunch
    else if ($page->uid() == 'powerlunch') {
        foreach ($page->children() as $powerlunchWeek) {
            $startDate = new \DateTime($powerlunchWeek->start_date());
            $endDate = new \DateTime($powerlunchWeek->end_date());
            if ($startDate <= $actualDate && $endDate > $actualDate) {
                $mainPages->append($page->num(), $page);
                break;
            }
        }
    }

    // Display-Bedingung Event
    else if ($page->content()->has('event_text')) {
        if (!$page->content()->event_text()->empty()) {
            $mainPages->append($page->num(), $page);
        }
    }

    // Übrige sichtbare Seiten ohne Bedingung dem Seitenbaum hinzufügen
    else {
        $mainPages->append($page->num(), $page);
    }

}

return [
    'mainPages'   => $mainPages
];
