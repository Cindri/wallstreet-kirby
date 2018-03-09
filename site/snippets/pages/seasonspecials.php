<div class="page-header">
    <?php if ($image = $page->main_image()->toFile()): ?>
        <figure class="post-thumbnail">
            <img src="<?= $image->url() ?>" />
        </figure>
    <?php endif ?>
    <h1 class="title"><span class="line-title"><?= $page->title() ?><i class="fa"></i></span></h1>
</div>
