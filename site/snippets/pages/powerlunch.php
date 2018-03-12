<?php
/** @var \Kirby\Panel\Models\Page $powerlunchPage */
$powerlunchPage = $site->find('powerlunch');
?>
<div class="page-header">
    <?php if ($image = $powerlunchPage->main_image()->toFile()): ?>
        <figure class="post-thumbnail">
            <img src="<?= $image->url() ?>"/>
        </figure>
    <?php endif ?>
    <h1 class="title"><span class="line-title"><?= $powerlunchPage->title() ?><i class="fa"></i></span></h1>
</div>
<div class="page-content">
    <?php snippet('pages/powerlunch_content', ['powerlunchPage' => $powerlunchPage]) ?>
</div>