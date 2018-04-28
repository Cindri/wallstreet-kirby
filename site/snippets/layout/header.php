<!-- Header -->
<header id="header" class="header">
    <div class="header-inner">
        <div class="container">
            <!-- Top Header -->
            <div class="header-top">

                <div class="row">
                    <div class="col-sm-4 header-left col-xs-6">
                        <ul class="nav">
                            <li><a href="<?= $site->find('kontakt')->url() ?>"><?= $site->find('kontakt')->title() ?></a></li>
                        </ul>
                    </div>
                    <div class="col-sm-4 header-right col-sm-push-4  col-xs-6">
                        <ul class="nav">
                            <li><a href="<?= $site->find('freunde-liste')->url() ?>"><?= $site->find('freunde-liste')->title() ?></a></li>
                        </ul>
                    </div>

                    <!-- Logo -->
                    <div id="logo" class="col-sm-4 logo col-sm-pull-4">
                        <a href="/"><img alt="The Retation" src="<?= $kirby->urls()->assets() ?>/images/logo_wallstreet.png"></a>
                    </div>

                </div>
            </div>

        </div>

        <?= snippet('layout/main_menu'); ?>

    </div>
</header>