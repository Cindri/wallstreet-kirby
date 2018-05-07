<section>
    <div class="page-header">
        <h1 class="title">
            <span class="line-title"><?= $page->title() ?><i class="fa"></i></span>
        </h1>
    </div>
    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <p>
                        <?= $page->text()->kirbytext() ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
