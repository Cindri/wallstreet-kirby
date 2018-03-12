<?php
$actualDate = new \DateTime();
$currentSeasonSpecial = null;
foreach ($seasonSpecialsPage->children() as $seasonSpecial) {
    $startDate = new \DateTime($seasonSpecial->start_date());
    $endDate = new \DateTime($seasonSpecial->end_date());
    if ($startDate <= $actualDate && $endDate > $actualDate) {
        $currentSeasonSpecial = $seasonSpecial;
    }
}

if (!empty($currentSeasonSpecial)):
?>

<section id="seasonspecials" class="section" <?php if ($page->uid() == 'home'): ?> style="background-image:url('<?= $seasonSpecialsPage->background_image()->toFile()->url() ?>'); background-size:cover; background-repeat:no-repeat;"<?php endif ?>>
    <div id="menus" class="menus">
        <div class="container">
            <?php if ($page->uid() == 'home'): ?>
                <h1 class="title title-center"><span class="line-title"><?= $seasonSpecialsPage->title() ?><i class="fa"></i></span></h1>
            <?php endif ?>
            <div class="menus-inner">
                <?php
                foreach ($currentSeasonSpecial->seasonspecials()->toStructure() as $seasonSpecial):
                    ?>
                    <section class="section menu-item">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="menu-inner season-specials">
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
                                                <?= $seasonSpecial->description()->kirbytext() ?>
                                            </p>
                                            <p>
                                                <?= $seasonSpecial->description_additional()->kirbytext() ?>
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
</section>
<?php endif ?>