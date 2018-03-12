<!-- Main Menu -->

<?php
/** @var \Kirby\Panel\Models\Site $site */
/** @var \Kirby\Panel\Models\Page $page */
/** @var \Kirby\Panel\Models\Page $mainPage */
/** @var \Kirby\Panel\Models\Page[] $subPages */
?>

<nav id="primary-navigation" class="navbar" role="navigation">
    <div class="navbar-inner">

        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed"
                    data-toggle="collapse" data-target="#navbar">
                <span class="sr-only">Toggle navigation</span> <span
                    class="icon-bar"></span> <span class="icon-bar"></span> <span
                    class="icon-bar"></span>
            </button>
            <h3 class="navbar-brand">Menu</h3>
        </div>

        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <?php foreach ($mainPages as $mainPage) : ?>
                    <li<?php e($mainPage->isOpen(), ' class="active"') ?>><a href="<?= $mainPage->url() ?>"><?= $mainPage->title() ?></a>
                        <?php if ($mainPage->hasVisibleChildren()): ?>
                            <div class="dropdown">
                                <ul class="sub-menu">
                                    <?php foreach ($mainPage->children()->visible() as $subPage) : ?>
                                        <li><a href="<?= $subPage->url() ?>"><?= $subPage->title() ?></a></li>
                                    <?php endforeach ?>
                                </ul>
                            </div>
                        <?php endif ?>
                    </li>
                <?php endforeach ?>

                <li>
                    <a href="#"><?= l::get('languages') ?></a>
                    <div class="dropdown">
                        <ul class="sub-menu">
                            <?php foreach($site->languages() as $language): ?>
                                <li<?php e($site->language() == $language, ' class="active"') ?>>
                                    <a href="<?= $page->url($language->code()) ?>">
                                        <img src="<?= $kirby->urls()->assets() ?>/flags/flagge_<?= $language->code() ?>.gif" width="20" height="13">
                                        <?= html($language->name()) ?>
                                    </a>
                                </li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                </li>
        </div>

        <!--/.navbar-collapse -->

    </div>
</nav>