<!doctype html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="">
<![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8" lang="">
<![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9" lang="">
<![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="">
<!--<![endif]-->

<?= snippet('layout/head') ?>

<body class="loadpage home style-v1">
<div id="wrap">

    <?= snippet('layout/header') ?>

    <div class="main-content" id="main-content">

        <?php
        /** @var \Kirby\Panel\Models\Page $page */
            $pageTemplate = $page->intendedTemplate();
            if ($pageTemplate !== 'default') {
                print snippet('pages/' . $pageTemplate);
            } else {
                print snippet('pages/' . $page->uid());
            }
        ?>

    </div>

    <?= snippet('layout/footer') ?>

</div>

<?= snippet('layout/jsAfterWrapper') ?>

</body>
</html>