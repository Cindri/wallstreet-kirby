
<?php
/** @var \Kirby\Panel\Models\Page $page */
?>

<section id="events" class="section section-events">
    <div class="page-header">
        <h1 class="title"><span class="line-title"><?= $page->event_title()->text() ?><i class="fa"></i></span></h1>
    </div>
    <div class="page-content">
        <div class="event-page">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 title-center">
                        <div style="text-align:center; font-weight:bold;"><?= $page->event_text()->kirbytext() ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>