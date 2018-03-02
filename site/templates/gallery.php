<div class="gallery gallery-v1">
    <div class="gallery-inner">
        <h3 class="title"><?= $page->title() ?><button class="close" title="Close"><span>×</span></button></h3>
        <div class="gallery-flickity">
            <?php
            if ($page->hasImages()):
                foreach ($page->images() as $image):
                    ?>
                    <div class="gallery-cell">
                        <img alt="" src="<?= $image->url() ?>">
                    </div>
                <?php
                endforeach;
            endif
            ?>
        </div>
        <aside class="entry-content">
            <p><?= $page->caption()->kirbytext() ?></p>
            <div class="gallery-meta">
                <div class="gallery-date">
                    <label>Galerie:</label><?= $page->headline()->text() ?>
                </div>
            </div>
        </aside>
    </div>
</div>
