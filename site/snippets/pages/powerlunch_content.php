<?php

/** @var \Kirby\Panel\Models\Page $currentPowerlunchWeek */
/** @var \Kirby\Panel\Models\Page $powerlunchPage */

$actualDate = new \DateTime();
$currentPowerlunchWeek = null;
foreach ($powerlunchPage->children() as $powerlunchWeek) {
    $startDate = new \DateTime($powerlunchWeek->start_date());
    $endDate = new \DateTime($powerlunchWeek->end_date());
    if ($startDate <= $actualDate && $endDate > $actualDate) {
        $currentPowerlunchWeek = $powerlunchWeek;
    }
}

if (!empty($currentPowerlunchWeek)):
?>

<section id="powerlunch" class="section">
    <div id="menus" class="menus">
        <div class="container">
            <?php if ($page->uid() == 'home'): ?>
                <h1 class="title title-center"><span class="line-title"><?= $powerlunchPage->title() ?><i class="fa"></i></span></h1>
            <?php endif ?>
            <div class="menus-inner">
                <?php
                $weekDays = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
                foreach ($weekDays as $day):
                    $i = 1;
                    foreach ($currentPowerlunchWeek->{$day}()->toStructure() as $powerlunchDay):
                        if (empty($powerlunchDay->name()->toString())) {
                            continue;
                        }
                        ?>
                        <section class="section menu-item">
                            <div class="row">
                                <div class="col-sm-12">
                                    <?php if ($i == 1): ?> <h3 class="title"><?= l::get($day) ?></h3> <?php endif ?>
                                    <div class="menu-inner season-specials">
                                        <aside class="clearfix animated animation-delay-25 fadeInRight"
                                               data-animate="fadeInRight">
                                            <div class="menu-content">
                                                <h5 class="title menu-title">
                                                    <span><?= $powerlunchDay->name() ?></span>
                                                    <span class="menu-price">
                                                            <i class="fa fa-usd"></i>
                                                        <?= number_format(floatval($powerlunchDay->price()->toString()), 2) ?>
                                                        </span>
                                                </h5>
                                                <p>
                                                    <?= $powerlunchDay->description()->kirbytext() ?>
                                                </p>
                                                <p>
                                                    <?= $powerlunchDay->description_additional()->kirbytext() ?>
                                                </p>
                                            </div>
                                        </aside>
                                    </div>
                                </div>
                            </div>
                        </section>
                    <?php
                    $i++; endforeach;
                endforeach;
                ?>
            </div>
        </div>
    </div>
</section>
<?php endif ?>