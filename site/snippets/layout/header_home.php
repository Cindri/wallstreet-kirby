<!-- Header -->
<header id="header" class="header">
    <div class="header-inner">
        <div class="container">
            <!-- Top Header -->
            <div class="header-top">

                <div class="row">
                    <div class="col-sm-4 header-left col-xs-6">
                        <ul class="nav">
                            <li><a href="<?= $site->find('impressum')->url() ?>">Impressum</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-4 header-right col-sm-push-4  col-xs-6">
                        <ul class="nav">
                            <li><a href="<?= $site->find('freunde-liste')->url() ?>">Freunde-Liste</a></li>
                        </ul>
                    </div>

                    <!-- Logo -->
                    <div id="logo" class="col-sm-4 logo col-sm-pull-4">
                        <a href="index.html"><img alt="The Retation" src="<?= $kirby->urls()->assets() ?>/images/logo_wallstreet.png"></a>
                    </div>

                </div>
            </div>

        </div>

        <?= snippet('layout/main_menu') ?>

    </div>

    <!-- Banner -->
    <div id="banner">
        <div class="slider-wrapper">
            <div class="nivoSlider">
                <?php
                $home = $site->find('home');
                $sliderImages = $home->images();
                $i = 1;
                foreach ($sliderImages as $image):
                    ?>
                    <img src="<?= $image->url() ?>" alt="" title="#nivoCaption-<?= $i ?>"/>
                    <?php
                    $i++;
                endforeach ?>
            </div>
            <div id="nivoCaption-1" class="nivo-html-caption">
                <div class="nivo-caption-content">
                    <h1 class="line-title title shadow animated animation-delay-75" data-animate="fadeInUp">
                        <?= l::get('welcome') ?><i class="fa">&#xf111;</i>
                    </h1>
                    <p class="desc banner-text animated animation-delay-100" data-animate="fadeInUp">
                        <?= l::get('welcome_text') ?>
                    </p>
                </div>
            </div>
            <div id="nivoCaption-2" class="nivo-html-caption">
                <div class="nivo-caption-content">

                        <div class="row">
                            <div class="col-sm-6 col-xs-6"><a class="banner-link" href="<?= $site->find('speisen')->url() ?>"><?= l::get('link_food'); ?></a></div>
                            <div class="col-sm-6 col-xs-6"><a class="banner-link" href="<?= $site->find('getraenke')->url() ?>"><?= l::get('link_drinks'); ?></a></div>
                        </div>

                </div>
            </div>
        </div>
    </div>

</header>