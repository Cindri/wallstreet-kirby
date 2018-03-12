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
    <?php snippet('pages/seasonspecials_content', ['seasonSpecialsPage' => $seasonSpecialsPage]) ?>
</div>