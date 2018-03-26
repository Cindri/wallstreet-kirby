
<?php
/** @var \Kirby\Panel\Models\Page $friendListPage */
$friendListPage = $site->find('freunde-liste');
?>

<footer id="footer">
    <div class="footer-info">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <aside class="widget">
                        <h3 class="title">About Us</h3>
                        <div class="widget-content contact-us">
                            <p>Anim pariatur cliche reprehenderit, enim eiusmod high
                                life accusamus terry richardson ad squid.</p>
                            <p><i class="fa">&#xf0e0;</i><span>hello@mtheme.org</span></p>
                            <p><i class="fa">&#xf095;</i><span>+(84)123456789</span></p>
                            <p><i class="fa">&#xf015;</i><span>198 West 21th Street, Suite 721 New York
										NY 10010</span></p>
                        </div>
                    </aside>
                </div>
                <div class="col-sm-3">
                    <aside class="widget">
                        <h3 class="title">For Business</h3>
                        <div class="widget-content">
                            <ul>
                                <li><a href="#">Office Coffee</a></li>
                                <li><a href="#">Food Service</a></li>
                                <li><a href="#">Affiliate Program</a></li>
                            </ul>
                        </div>
                    </aside>
                </div>
                <div class="col-sm-3">
                    <aside class="widget">
                        <h3 class="title">Newsletter</h3>
                        <div class="widget-content">
                            <p><?= l::get('newsletter_invitation_short') ?><br/>
                                <a href="<?= $friendListPage->url() ?>"><?= l::get('newsletter_link_long_registration') ?></a>
                            </p>
                            <form method="post" action="<?= $site->url($site->language()->code()) ?>/newsletter/add" data-action="newsletter/add" class="registration-form registration-form-short js-registration-form">
                                <p>
                                    <input type="text" value="" name="name" placeholder="Name"
                                           required="required" class="name">
                                </p>
                                <p>
                                    <input type="email" value="" name="email" placeholder="Email"
                                           required="required" class="email">
                                </p>
                                <p>
                                    <button class="hvr-shutter-out-horizontal js-submit-registration">Subscribe</button>
                                </p>
                            </form>
                        </div>
                    </aside>
                </div>
                <div class="col-sm-3">
                    <aside class="widget">
                        <h3 class="title">Follow Us</h3>
                        <div class="widget-content">
                            <p>Follow Origin on the following social network sites.</p>
                            <ul class="social">
                                <li><a href="#" class="hvr-rectangle-out" target="_blank"><i class="fa">&#xf09a;</i></a></li>
                                <li><a href="#" class="hvr-rectangle-out" target="_blank"><i class="fa">&#xf099;</i></a></li>
                                <li><a href="#" class="hvr-rectangle-out" target="_blank"><i class="fa">&#xf0d5;</i></a></li>
                                <li><a href="#" class="hvr-rectangle-out" target="_blank"><i class="fa">&#xf09e;</i></a>
                                </li>
                            </ul>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright">
        <div class="container">
            <p>
                Copyright &copy; <?= date('Y') ?> <?= l::get('copyright_notice') ?>
            </p>
        </div>
    </div>

</footer>