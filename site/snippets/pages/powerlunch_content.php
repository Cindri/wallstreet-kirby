<?php

require_once(__ROOT__ . '/controllers/Newsletter/Services/PowerlunchService.php');

$powerlunchService = new PowerlunchService($site->language()->code());

/** @var \Kirby\Panel\Models\Page $currentPowerlunchWeek */
$currentPowerlunchWeek = $powerlunchService->getCurrentWeek();

$currentMealDays = $powerlunchService->getMealsOfCurrentWeek($currentPowerlunchWeek);

if (!empty($currentPowerlunchWeek)):
    ?>

    <section id="powerlunch">
        <div id="menus" class="menus">
            <div class="container">
                <?php if ($page->uid() == 'home'): ?>
                    <h1 class="title title-center"><span class="line-title"><?= $powerlunchPage->title() ?><i
                                    class="fa"></i></span></h1>
                <?php endif ?>
                <div class="menus-inner">
                    <?php
                    foreach ($currentMealDays as $dayName => $dayData):
                        $dayDate = $dayData['date'];
                        $meals = $dayData['meals'];
                        $i = 1;
                        foreach ($dayData['meals'] as $meal):
                            ?>
                            <section class="section menu-item powerlunch-section">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <?php if ($i == 1): ?> <h3
                                                class="title orange"><?= l::get(strtolower($dayName)) . ', ' . $dayDate->format('d.m.') ?></h3> <?php endif ?>
                                        <div class="menu-inner season-specials">
                                            <aside class="clearfix animated animation-delay-25 fadeInRight"
                                                   data-animate="fadeInRight">
                                                <div class="menu-content">
                                                    <h5 class="title menu-title">
                                                        <span><?= $meal->name() ?></span>
                                                        <span class="menu-price">
                                                            <?= number_format(floatval($meal->price()->toString()), 2) ?> &euro;
                                                        </span>
                                                    </h5>
                                                    <p>
                                                        <?= $meal->description()->kirbytext() ?>
                                                    </p>
                                                    <p>
                                                        <?= $meal->description_additional()->kirbytext() ?>
                                                    </p>
                                                </div>
                                            </aside>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <?php
                            $i++;
                            endforeach;
                        endforeach;
                    ?>
                </div>
            </div>
        </div>
    </section>
<?php endif ?>