<?php
/** @var \Kirby\Panel\Models\Page $seasonSpecialsPage */
$seasonSpecialsPage = $site->find('season-specials');
?>
<div class="page-header">
    <?php if ($image = $seasonSpecialsPage->main_image()->toFile()): ?>
        <figure class="post-thumbnail">
            <img src="<?= $image->url() ?>"/>
        </figure>
    <?php endif ?>
    <h1 class="title"><span class="line-title"><?= $seasonSpecialsPage->title() ?><i class="fa"></i></span></h1>
</div>
<div class="page-content">
    <div id="menus" class="menus">
        <div class="container">
            <div class="menus-inner">
                <?php
                foreach ($seasonSpecialsPage->seasonspecials()->toStructure() as $seasonSpecial):
                    ?>
                    <section class="section menu-item">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="menu-inner">
                                    <aside class="clearfix animated animation-delay-25 fadeInRight"
                                           data-animate="fadeInRight">
                                        <div class="menu-content">
                                            <h5 class="title menu-title">
                                                <span><?= $seasonSpecial->name() ?></span>
                                                <span class="menu-price">
                                                            <i class="fa fa-usd"></i>
                                                    <?= number_format($seasonSpecial->price()->toString(), 2) ?>
                                                        </span>
                                            </h5>
                                            <p>
                                                <?= $seasonSpecial->description() ?>
                                            </p>
                                        </div>
                                    </aside>
                                </div>
                            </div>
                        </div>
                    </section>
                    <?php
                endforeach
                ?>
            </div>
        </div>
    </div>
    2
</div>