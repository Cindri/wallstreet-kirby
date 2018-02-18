<?php
// Menu Controller
/** @var \Kirby\Panel\Models\Site $site */
/** @var \Kirby\Panel\Models\Page[] $allPages */

$allPages = $site->children()->visible();
$mainPages = new Collection();
foreach ($allPages as $page) {

    // Display-Bedingung Season Specials
    if ($page->content()->has('seasonspecials')) {
        if (!$page->content()->seasonspecials()->empty()) {
            $mainPages->append($page->num(), $page);
        }
    }

    // Display-Bedingung Powerlunch
    else if ($page->content()->has('powerlunch')) {
        $actualDate = new \DateTime();
        if (!in_array($actualDate->format('l'), ['Saturday', 'Sunday'])) {
            $mainPages->append($page->num(), $page);
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
