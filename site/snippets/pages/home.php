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
                    <?= l::get('opening_hours') ?><i class="fa">&#xf111;</i>
                </h1>
                <aside>
                    <?= $site->opening_hours()->kirbytext() ?>
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
$foodPage = $site->find('speisen');
snippet('pages/menu', ['page' => $foodPage]);
?>
