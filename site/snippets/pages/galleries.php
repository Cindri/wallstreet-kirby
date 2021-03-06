<?php
$galleryMainPage = $site->find('galerien');
$galleryList = $galleryMainPage->children();
?>
<section id="galleries" class="galleries galleries-v1 section section-galleries">

    <h1 class="title title-center">
        <span class="line-title"><?= $galleryMainPage->title() ?><i class="fa"></i></span>
    </h1>

    <div class="container">
        <div class="filter-sticky">
            <div id="filter" class="filter">
                <button class="button" data-filter="*"><?= l::get('all'); ?></button>
                <?php
                foreach ($galleryList as $gallery):
                    ?>
                    <button class="button" data-filter=".<?= $gallery->uid() ?>"><?= $gallery->title() ?></button>
                <?php
                endforeach
                ?>
            </div>
        </div>


        <div class="row">
            <?php
            /** @var \Kirby\Panel\Models\Page $gallery */
            foreach ($galleryList as $gallery):
                $images = $gallery->images()->sortBy('sort', 'asc');
                $image = $images->first();
                ?>
                <div class="col-xs-4 col-md-3 gallery-item <?= $gallery->uid() ?>">
                    <div class="inner">
                        <?php if ($image): ?>
                            <figure>
                                <img src="<?= $image->url() ?>">
                                <figcaption>
                                    <a class="gallery-ajax" href="#" data-url="<?= $gallery->url() ?>/ajax"></a>
                                    <div class="gallery-icon">
                                        <a class="hvr-rectangle-out gallery-ajax" href="#" data-url="<?= $gallery->url() ?>/ajax"><i class="fa fa-arrows-alt"></i></a>
                                    </div>
                                </figcaption>
                            </figure>
                        <?php endif ?>
                        <h4 class="title"><?= $gallery->title() ?></h4>
                    </div>
                </div>
            <?php
            endforeach
            ?>
        </div>
    </div>
</section>

<?php
if (!empty($selectedGallery)) {
    ?>
    <script type="text/javascript">
        $(document).ready(function() {
            var button = $('.button[data-filter=".<?= $selectedGallery ?>"]');
            window.setTimeout(function() {
                $('.button[data-filter=".<?= $selectedGallery ?>"]').trigger('click');
            }, 10);
        });
    </script>
<?php
}
?>
