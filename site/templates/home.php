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

        <?= snippet('layout/header_home') ?>

        <div class="main-content" id="main-content">

            <?= snippet('pages/content_home')?>

        </div>

        <?= snippet('layout/footer') ?>

    </div>

    <?= snippet('layout/jsAfterWrapper') ?>

</body>
</html>