<?php
/** @var \Kirby\Panel\Models\Page $page */
?>

<div class="page-header">
    <h1 class="title"><span class="line-title"><?= $page->title() ?><i class="fa"></i></span></h1>
    <h2 class="title-center"><?= $page->subline()->kirbytext() ?></h2>
</div>
<div class="page-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-lg-push-6 title-center">
                <?= $page->text()->kirbytext() ?>
            </div>
            <div class="col-lg-6 col-lg-pull-6">
                <form action="newsletter/add" class="registration-form js-registration-form" method="POST">
                    <div class="form-group">
                        <label for="email">E-Mail:</label>
                        <input type="email" name="email" id="email" class="input-standard" />

                        <label for="fax">Fax:</label>
                        <input type="tel" name="fax" id="fax" class="input-standard" />
                    </div>
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" name="name" required="required" id="name" class="input-standard" />

                        <label for="street">Straße:</label>
                        <input type="text" name="street" id="street" class="input-standard" />

                        <label for="city">Ort:</label>
                        <input type="text" name="city" id="city" class="input-standard" />

                        <label for="phone">Telefon:</label>
                        <input type="tel" name="phone" id="phone" class="input-standard" />
                    </div>
                    <div class="form-group">
                        <button class="submit-button hvr-shutter-out-horizontal js-submit-registration">Subscribe</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>