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
                <form action="newsletter/add" data-unregister="newsletter/signoutRequest" class="registration-form js-registration-form" method="POST">
                    <div class="container-fluid">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label for="email"><?= l::get('email') ?>:</label>
                                    <input type="email" name="email" id="email" class="input-standard" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <label for="vorwahl"><?= l::get('vorwahl') ?>:</label>
                                    <input type="tel" name="vorwahl" id="vorwahl" class="input-standard" />
                                </div>
                                <div class="col-sm-9">
                                    <label for="fax"><?= l::get('fax') ?>:</label>
                                    <input type="tel" name="fax" id="fax" class="input-standard" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12">
                                    <button class="submit-button hvr-shutter-out-horizontal js-submit-registration"><?= l::get('checkin') ?></button>
                                    <button class="submit-button hvr-shutter-out-horizontal js-submit-unregister"><?= l::get('checkout') ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>