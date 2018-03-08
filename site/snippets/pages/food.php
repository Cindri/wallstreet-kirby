<?php
/** @var \Kirby\Panel\Models\Page $page */
?>
<div class="page-header">
    <figure class="post-thumbnail">
        <img src="assets/images/menus/menus.jpg"/>
    </figure>
    <h1 class="title">
        <span class="line-title"><?= $page->title() ?><i class="fa"></i></span>
    </h1>
</div>
<div class="page-content">
    <div id="menus" class="menus">
        <div class="container">
            <div class="filter-sticky" style="">
                <div id="filter" class="filter">
                    <button class="button" data-filter="*"><?= l::get('all') ?></button>
                    <?php foreach ($page->children() as $foodChapter): ?>
                        <button class="button"
                                data-filter=".<?= $foodChapter->uid() ?>"><?= $foodChapter->title() ?></button>
                    <?php endforeach ?>
                </div>
            </div>
            <div class="menus-inner">
                <?php
                $i = 0;
                /** @var \Kirby\Panel\Models\Page $foodChapter */
                foreach ($page->children() as $foodChapter):
                    ?>
                    <section id="<?= $foodChapter->uid() ?>" class="section menu-item <?= $foodChapter->uid() ?>">
                        <div class="row">
                            <div class="col-sm-6 <?php e(($i % 2 != 0), 'col-sm-push-6', '') ?>">
                                <h1 class="title"><?= $foodChapter->title() ?></h1>
                                <?php if (!empty($image = $foodChapter->chapter_image()->toFile())) : ?>
                                    <figure class="menu-thumbnail">
                                        <img src="<?= $image->url() ?>"/>
                                    </figure>
                                <?php endif ?>
                            </div>
                            <div class="col-sm-6 <?php e(($i % 2 != 0), 'col-sm-pull-6', '') ?>">
                                <div class="menu-inner">
                                    <?php
                                    if (!empty($items = $foodChapter->items()->toStructure())):
                                        $x = 0; foreach ($items as $meal):
                                            ?>
                                            <aside class="clearfix animated animation-delay-<?= (25 * $x) ?> <?php e(($i % 2 != 0), 'fadeInLeft', 'fadeInRight') ?>"
                                                   data-animate="<?php e(($i % 2 != 0), 'fadeInLeft', 'fadeInRight') ?>">
                                                <?php
                                                if ($image = $meal->image()->toFile()) :
                                                    ?>
                                                    <img class="menu-img" src="<?= $image->url() ?>"/>
                                                <?php
                                                endif;
                                                ?>
                                                <div class="menu-content">
                                                    <h5 class="title menu-title">
                                                        <span><?= $meal->name() ?></span>
                                                        <span class="menu-price">
                                                            <i class="fa fa-usd"></i>
                                                            <?= number_format($meal->price()->toString(), 2) ?>
                                                        </span>
                                                    </h5>
                                                    <p>
                                                        <?= $meal->description() ?>
                                                    </p>
                                                </div>
                                            </aside>
                                        <?php
                                        $x++;
                                        endforeach;
                                    endif;
                                    ?>
                                </div>
                            </div>
                        </div>
                    </section>
                    <?php
                    $i++;
                endforeach
                ?>
            </div>
        </div>
    </div>
</div>