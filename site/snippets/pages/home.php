<section id="infoUs" class="section infoUs"
         style="background-image: url(assets/images/home/info/info-bg.jpg); background-position: right center; background-repeat: no-repeat;">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-sm-push-6">
                <figure>
                    <img alt="" src="assets/images/home/info/info-img-1.png" class="animated" data-animate="fadeInRight animation animation-delay-25">
                    <img alt="" src="assets/images/home/info/info-img-2.png" class="animated" data-animate="fadeInRight animation">
                </figure>
            </div>

            <div class="col-sm-6 col-sm-pull-6">
                <h1 class="title line-title">
                    <?= $page->title()->text() ?><i class="fa">&#xf111;</i>
                </h1>
                <aside>
                    <?= $page->text()->kirbytext() ?>
                </aside>
            </div>
        </div>
    </div>
</section>

<?= snippet('pages/galleries') ?>

<?php
$powerlunchPage = $site->find('season-specials');
snippet('pages/seasonspecials_content', ['seasonSpecialsPage' => $powerlunchPage]);
?>

<?php
$eventPage = $site->find('event');
if (!$eventPage->event_text()->empty()) {
    snippet('pages/event', ['page' => $eventPage]);
}
?>

<section id="anfahrt">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12" style="padding-left: 0; padding-right: 0">
                <a href="https://goo.gl/maps/SZsg9yeokyy" target="_blank">
                    <img src="assets/images/home/screenshot_anfahrt.jpg" style="width:100%; height: auto;" />
                </a>
            </div>
        </div>
    </div>
</section>
