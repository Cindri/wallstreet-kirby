
<?php
/** @var \Kirby\Panel\Models\Page $friendListPage */
$friendListPage = $site->find('freunde-liste');
?>

<footer id="footer">
    <div class="footer-info">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <aside class="widget">
                        <h3 class="title"><?= l::get('pages') ?></h3>
                        <div class="widget-content">
                            <ul>
                                <?php foreach ($mainPages as $mainPage) : ?>
                                    <li><a href="<?= $mainPage->url() ?>"><?= $mainPage->title() ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </aside>
                </div>
                <div class="col-sm-4">
                    <aside class="widget">
                        <h3 class="title"><?= l::get('additional') ?></h3>
                        <div class="widget-content">
                            <ul>
                                <li><a href="<?= $site->find('freunde-liste')->url() ?>"><?= l::get('friend_list') ?></a></li>
                                <li><a href="http://extern.panten.de/wallstreet/epaper/index" target="_blank"><?= l::get('epaper') ?></a></li>
                                <li><a href="<?= $site->find('impressum')->url() ?>"><?= l::get('imprint') ?></a></li>
                                <li><a href="<?= $site->find('datenschutz')->url() ?>"><?= l::get('data_policy') ?></a></li>
                                <li><a href="<?= $site->find('zusatzstoffe')->url() ?>"><?= l::get('ingredients') ?></a></li>
                                <li><a href="<?= $site->find('kontakt')->url() ?>"><?= l::get('contact') ?></a></li>
                            </ul>
                        </div>
                    </aside>
                </div>
                <div class="col-sm-4">
                    <aside class="widget">
                        <h3 class="title"><?= l::get('friend_list') ?></h3>
                        <div class="widget-content">
                            <p><?= l::get('newsletter_invitation_short') ?></p>
                            <button class="hvr-shutter-out-horizontal" onclick="window.location.href = '<?= $friendListPage->url() ?>'"><?= l::get('newsletter_link_registration') ?></button>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright">
        <div class="container">
            <p>
                Copyright &copy; <?= date('Y') ?> <?= l::get('copyright_notice') ?>
            </p>
        </div>
    </div>

</footer>