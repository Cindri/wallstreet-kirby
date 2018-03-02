<section id="infoUs" class="section infoUs"
         style="background-image: url(assets/images/home/info/info-bg.jpg); background-position: right center; background-repeat: no-repeat;">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-sm-push-6">
                <figure>
                    <img alt="" src="assets/images/home/info/info-img-1.png" class="animated" data-animate="fadeInRight animation animation-delay-25">
                    <img alt="" src="assets/images/home/info/info-img-2.png" class="animated" data-animate="fadeInRight animation">
                </figure>
            </div>

            <div class="col-sm-6 col-sm-pull-6">
                <h1 class="title line-title">
                    <?= l::get('opening_hours') ?><i class="fa">&#xf111;</i>
                </h1>
                <aside>
                    <?= $site->opening_hours()->kirbytext() ?>
                </aside>
            </div>
        </div>
    </div>
</section>

<?= snippet('pages/galleries') ?>

<section id="latest" class="section latest"
         style="background-image: url(assets/images/home/latest/bg.png); background-position: right top; background-repeat: no-repeat;">
    <div class="container">
        <div class="row">
            <div class="col-sm-7">
                <h1 class="title line-title">
                    Latest Update<i class="fa">&#xf111;</i>
                </h1>
                <ul class="posts_list">
                    <li>
                        <figure>
                            <a href="#"> <img alt="" src="assets/images/home/latest/img-1.png">
                            </a>
                        </figure>
                        <aside>
                            <h4 class="title">
                                <a href="#">Happy Hour, between 4pm &amp; 5pm</a>
                            </h4>
                            <p>In specialty coffee culture an ability to properly brew
                                coffee is summing it all up. In one cup of coffee we bring
                                together efforts of all of those who worked o...</p>
                        </aside>
                    </li>
                    <li>
                        <figure>
                            <a href="#"> <img alt="" src="assets/images/home/latest/img-2.png">
                            </a>
                        </figure>
                        <aside>
                            <h4 class="title">
                                <a href="#">Brew coffee is summing it all up</a>
                            </h4>
                            <p>In specialty coffee culture an ability to properly brew
                                coffee is summing it all up. In one cup of coffee we bring
                                together efforts of all of those who worked o...</p>
                        </aside>
                    </li>
                </ul>
            </div>
            <div class="col-sm-5">
                <div class="widget-gallery">
                    <ul>
                        <li>
                            <figure>
                                <img class="animated" data-animate="zoomIn animation" alt="" src="assets/images/home/gallery/img-1.jpg" >
                                <figcaption>
                                    <a class="gallery-ajax" href="#" data-url="../ajax/gallery-v2-1.html" data-toggle="modal" data-target="#myModal-1"></a>
                                </figcaption>
                            </figure>
                        </li>
                        <li>
                            <figure>
                                <img class="animated" data-animate="zoomIn animation" alt="" src="assets/images/home/gallery/img-2.jpg" >
                                <figcaption>
                                    <a class="gallery-ajax" href="#" data-url="../ajax/gallery-v2-2.html" data-toggle="modal" data-target="#myModal-2"></a>
                                </figcaption>
                            </figure>
                        </li>
                        <li>
                            <figure>
                                <img class="animated" data-animate="zoomIn animation animation-delay-50" alt="" src="assets/images/home/gallery/img-3.jpg" >
                                <figcaption>
                                    <a class="gallery-ajax" href="#" data-url="../ajax/gallery-v2-2.html" data-toggle="modal" data-target="#myModal-3"></a>
                                </figcaption>
                            </figure>
                        </li>
                        <li>
                            <figure>
                                <img class="animated" data-animate="zoomIn animation animation-delay-50" alt="" src="assets/images/home/gallery/img-4.jpg" >
                                <figcaption>
                                    <a class="gallery-ajax" href="#" data-url="../ajax/gallery-v2-1.html" data-toggle="modal" data-target="#myModal-4"></a>
                                </figcaption>
                            </figure>
                        </li>
                        <li>
                            <figure>
                                <img class="animated" data-animate="zoomIn animation animation-delay-100" alt="" src="assets/images/home/gallery/img-5.jpg" >
                                <figcaption>
                                    <a class="gallery-ajax" href="#" data-url="../ajax/gallery-v2-1.html" data-toggle="modal" data-target="#myModal-5"></a>
                                </figcaption>
                            </figure>
                        </li>
                        <li>
                            <figure>
                                <img class="animated" data-animate="zoomIn animation animation-delay-100" alt="" src="assets/images/home/gallery/img-6.jpg" >
                                <figcaption>
                                    <a class="gallery-ajax" href="#" data-url="../ajax/gallery-v2-2.html" data-toggle="modal" data-target="#myModal-6"></a>
                                </figcaption>
                            </figure>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="myModal-1">
        <div class="modal-content">

            <div class="modal-header">
                <div class="container">
                    <button aria-label="Close" data-dismiss="modal" class="close"
                            type="button">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            </div>
            <div class="modal-body"></div>

        </div>
        <!-- /.modal-content -->
    </div>
    <div class="modal" id="myModal-2">
        <div class="modal-content">

            <div class="modal-header">
                <div class="container">
                    <button aria-label="Close" data-dismiss="modal" class="close"
                            type="button">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            </div>
            <div class="modal-body"></div>

        </div>
        <!-- /.modal-content -->
    </div>
    <div class="modal" id="myModal-3">
        <div class="modal-content">

            <div class="modal-header">
                <div class="container">
                    <button aria-label="Close" data-dismiss="modal" class="close"
                            type="button">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            </div>
            <div class="modal-body"></div>

        </div>
        <!-- /.modal-content -->
    </div>
    <div class="modal" id="myModal-4">
        <div class="modal-content">

            <div class="modal-header">
                <div class="container">
                    <button aria-label="Close" data-dismiss="modal" class="close"
                            type="button">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            </div>
            <div class="modal-body"></div>

        </div>
        <!-- /.modal-content -->
    </div>
    <div class="modal" id="myModal-5">
        <div class="modal-content">

            <div class="modal-header">
                <div class="container">
                    <button aria-label="Close" data-dismiss="modal" class="close"
                            type="button">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            </div>
            <div class="modal-body"></div>

        </div>
        <!-- /.modal-content -->
    </div>
    <div class="modal" id="myModal-6">
        <div class="modal-content">

            <div class="modal-header">
                <div class="container">
                    <button aria-label="Close" data-dismiss="modal" class="close"
                            type="button">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            </div>
            <div class="modal-body"></div>

        </div>
        <!-- /.modal-content -->
    </div>

</section>