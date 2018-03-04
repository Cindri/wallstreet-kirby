<?php

/** @var \Kirby\Panel\Models\Page $page */
$galleryPage = $page;

// HTML-Rahmen nur einbinden, wenn nicht per AJAX-Request angefragt
if (!$ajax):
    $galleryMainPage = $site->find('galerien');
    $galleryList = $galleryMainPage->children();
    ?>

    <!doctype html>
    <!--[if lt IE 7]>
    <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="">
    <![endif]-->
    <!--[if IE 7]>
    <html class="no-js lt-ie9 lt-ie8" lang="">
    <![endif]-->
    <!--[if IE 8]>
    <html class="no-js lt-ie9" lang="">
    <![endif]-->
    <!--[if gt IE 8]><!-->
    <html class="no-js" lang="">
    <!--<![endif]-->

    <?= snippet('layout/head') ?>

    <body class="loadpage home style-v1">
    <div id="wrap">

    <?= snippet('layout/header') ?>

    <div class="main-content" id="main-content">
    <section class="section section-galleries">
    <div class="container-fluid no-padding">
        <div class="single-gallery-navigation">
            <button data-ref="<?= $galleryMainPage->url() ?>" class="button single-gallery-navigation-link"><?= l::get('all'); ?></button>
            <?php
            foreach ($galleryList as $gallery):
                ?>
                <button data-ref="<?= $gallery->url() ?>" class="button single-gallery-navigation-link <?php e($gallery->uid() === $galleryPage->uid(), 'active'); ?>"><?= $gallery->title() ?></button>
            <?php
            endforeach
            ?>
        </div>
<?php
endif
?>

    <div class="gallery gallery-v1 <?php if(!$ajax): echo 'single-gallery'; endif ?>">
        <div class="gallery-inner single-gallery-inner">
            <h3 class="title"><?= $galleryPage->title() ?><button class="close" title="Close"><span>×</span></button></h3>
            <div class="gallery-flickity">
                <?php
                if ($galleryPage->hasImages()):
                    foreach ($galleryPage->images() as $image):
                        ?>
                        <div class="gallery-cell">
                            <img alt="" src="<?= $image->url() ?>">
                        </div>
                    <?php
                    endforeach;
                endif
                ?>
            </div>
            <aside class="entry-content">
                <p><?= $galleryPage->caption()->kirbytext() ?></p>
                <div class="gallery-meta">
                    <div class="gallery-date">
                        <label>Galerie:</label> <?= $galleryPage->headline()->text() ?>
                    </div>
                </div>
            </aside>
        </div>
    </div>

<?php
// HTML-Footer nur einbinden, wenn nicht per AJAX angefragt
if (!$ajax) :
    ?>
    </div>
    </section>
    </div>

<?= snippet('layout/footer') ?>

    </div>

<?= snippet('layout/jsAfterWrapper') ?>

    <script type="text/javascript">
        $('button[data-ref]').click(function () {
            window.location.replace($(this).data('ref'));
        });
        $(document).ready(function() {
            $('.gallery-flickity').imagesLoaded(function() {
                $('.gallery-flickity').flickity({
                    wrapAround: true,
                    freeScroll: false,
                    imagesLoaded: true,
                    resize: false,
                    arrowShape: {
                        x0: 25,
                        x1: 60, y1: 35,
                        x2: 70, y2: 35,
                        x3: 35
                    }
                });
            });
        });
    </script>
    </body>
    </html>

<?php
endif
?>