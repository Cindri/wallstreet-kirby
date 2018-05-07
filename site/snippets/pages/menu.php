<?php
/** @var \Kirby\Panel\Models\Page $page */
?>
<section id="<?= $page->uid() ?>">
    <div class="page-header">
        <h1 class="title">
            <span class="line-title"><?= $page->title() ?><i class="fa"></i></span>
        </h1>
    </div>
    <div class="page-content">
        <div id="menus-<?= $page->uid() ?>" class="menus">
            <div class="container">
                <div class="filter-sticky" style="">
                    <div id="filter" class="filter">
                        <button class="button" data-filter="*"><?= l::get('all') ?></button>
                        <?php foreach ($page->children() as $chapter): ?>
                            <button class="button"
                                    data-filter=".<?= $chapter->uid() ?>"><?= $chapter->title() ?></button>
                        <?php endforeach ?>
                    </div>
                </div>
                <div class="menus-inner menu-card">
                    <?php
                    $i = 0;
                    /** @var \Kirby\Panel\Models\Page $chapter */
                    foreach ($page->children() as $chapter):
                        ?>
                        <section id="<?= $chapter->uid() ?>" class="section menu-item <?= $chapter->uid() ?>">
                            <div class="row">
                                <div class="col-sm-6 <?php e(($i % 2 != 0), 'col-sm-push-6', '') ?>">
                                    <h1 class="title"><?= $chapter->title() ?></h1>
                                    <?php if (!empty($image = $chapter->chapter_image()->toFile())) : ?>
                                        <figure class="menu-thumbnail">
                                            <a href="<?= $image->url() ?>" class="menu-expand-image"><img src="<?= $image->url() ?>"/></a>
                                        </figure>
                                    <?php endif ?>
                                </div>
                                <div class="col-sm-6 <?php e(($i % 2 != 0), 'col-sm-pull-6', '') ?>">
                                    <div class="menu-inner">
                                        <?php
                                        if (!empty($items = $chapter->items()->toStructure())):
                                            $x = 0;
                                            foreach ($items as $meal):
                                                ?>
                                                <aside class="clearfix animated animation-delay-<?= (25 * $x) ?> <?php e(($i % 2 != 0), 'fadeInLeft', 'fadeInRight') ?>"
                                                       data-animate="<?php e(($i % 2 != 0), 'fadeInLeft', 'fadeInRight') ?>">

                                                    <?php
                                                    if ($image = $meal->image()->toFile()) :
                                                        ?>
                                                        <a href="<?= $image->url() ?>" class="menu-expand-image"><img class="menu-img" src="<?= $image->url() ?>"/></a>
                                                    <?php
                                                    endif;
                                                    ?>

                                                    <?php $isSubline = empty($meal->price()->toString()); ?>
                                                    <div class="menu-content <?php e($isSubline, 'menu-subline') ?>">
                                                        <h5 class="title menu-title">
                                                            <span><?= $meal->name() ?></span>
                                                            <span class="menu-price">
                                                                <?php e(!$isSubline, number_format(floatval($meal->price()->toString()), 2)); ?> &euro;
                                                            </span>
                                                        </h5>
                                                        <?= $meal->description()->kirbytext() ?>
                                                    </div>
                                                </aside>
                                                <?php
                                                $x++;
                                            endforeach;
                                        endif;
                                        ?>
                                    </div>

                                    <?php if (!$chapter->chapter_text()->empty()): ?>
                                    <p><?= $chapter->chapter_text()->kirbytext() ?></p>
                                    <?php endif; ?>
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
</section>