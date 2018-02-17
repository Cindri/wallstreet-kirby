<?php
// Menu Controller
/** @var \Kirby\Panel\Models\Site $site */
/** @var \Kirby\Panel\Models\Page[] $allPages */

$allPages = $site->children()->visible();
$mainPages = new Collection();
foreach ($allPages as $page) {

    // Display-Bedingung Season Specials
    if ($page->num() == 2 || $page->content()->has('seasonspecials')) {
        if (!$page->content()->seasonspecials()->empty()) {
            $mainPages->append($page->num(), $page);
        }
    }

    // Display-Bedingung Powerlunch
    else if ($page->num() == 3 || $page->content()->has('powerlunch')) {
        $actualDate = new \DateTime();
        if (!in_array($actualDate->format('l'), ['Saturday', 'Sunday'])) {
            $mainPages->append($page->num(), $page);
        }
    }

    // Display-Bedingung Event
    else if ($page->num() == 7 || $page->content()->has('event_text')) {
        if (!$page->content()->event_text()->empty()) {
            $mainPages->append($page->num(), $page);
        }
    }

    // Übrige sichtbare Seiten ohne Bedingung dem Seitenbaum hinzufügen
    else {
        $mainPages->append($page->num(), $page);
    }

}

$mainPages->sortBy();

return [
    'mainPages'   => $mainPages
];
