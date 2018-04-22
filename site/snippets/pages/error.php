<?php
/** @var \Kirby\Panel\Models\Page $page */
?>

<div class="page-header">
    <h1 class="title"><span class="line-title"><?= $page->title() ?><i class="fa"></i></span></h1>
</div>
<div class="page-content">
    <div class="error-page">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 title-center">
                    <div style="text-align:center; font-weight:bold;"><?= $page->intro()->kirbytext() ?></div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 title-center">
                    <?= $page->text()->kirbytext() ?>
                </div>
            </div>
        </div>
    </div>
</div>