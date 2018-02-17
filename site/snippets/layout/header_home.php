
<!-- Header -->
<header id="header" class="header">
    <div class="header-inner">
        <div class="container">
            <!-- Top Header -->
            <div class="header-top">

                <div class="row">
                    <div class="col-sm-4 header-left col-xs-6">
                        <ul class="nav">
                            <li><a href="#">Find</a></li>
                            <li><a href="#">Contacts</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-4 header-right col-sm-push-4  col-xs-6">
                        <ul class="nav">
                            <li><a href="#">Login</a></li>
                            <li><a href="#">Register</a></li>
                        </ul>
                    </div>

                    <!-- Logo -->
                    <div id="logo" class="col-sm-4 logo col-sm-pull-4">
                        <a href="index.html"><img alt="The Retation"
                                                  src="../assets/imgs/logo.png"></a>
                    </div>

                </div>
            </div>

        </div>

        <?= snippet('layout/main_menu') ?>

    </div>

    <!-- Banner -->
    <div id="banner">
        <div class="slider-wrapper">
            <div class="nivoSlider">
                <img src="../images/home/slider/slider-1.jpg" alt=""
                     title="#nivoCaption-1" /> <img src="../images/home/slider/slider-2.jpg"
                                                    alt="" title="#nivoCaption-2" /> <img
                    src="../images/home/slider/slider-3.jpg" alt="" title="" />
            </div>
            <div id="nivoCaption-1" class="nivo-html-caption">
                <div class="nivo-caption-img-1 animated animation-delay-50"
                     data-animate="fadeInUp">
                    <img alt="" src="../images/home/slider/img-1.png">
                </div>
                <div class="nivo-caption-img-2 animated" data-animate="fadeInUp">
                    <img alt="" src="../images/home/slider/img-2.png">
                </div>
                <div class="nivo-caption-content">
                    <h1 class="line-title title animated animation-delay-75"
                        data-animate="fadeInUp">
                        Advertising based<i class="fa">&#xf111;</i>
                    </h1>
                    <p class="desc animated animation-delay-100"
                       data-animate="fadeInUp">Coffee culture is a great coffee
                        taste and it rests on the basis of responsible &amp; respectful</p>
                </div>
            </div>
            <div id="nivoCaption-2" class="nivo-html-caption">
                <div class="nivo-caption-img-1 animated" data-animate="fadeInUp">
                    <img alt="" src="../images/home/slider/img-3.png">
                </div>
                <div class="nivo-caption-img-2 animated animation-delay-50"
                     data-animate="fadeInUp">
                    <img alt="" src="../images/home/slider/img-4.png">
                </div>
                <div class="nivo-caption-content">
                    <h1 class="line-title title animated animation-delay-75"
                        data-animate="fadeInUp">
                        Pack a big punch<i class="fa">&#xf111;</i>
                    </h1>
                    <p class="desc animated animation-delay-100"
                       data-animate="fadeInUp">Grown traditionally, harvested
                        naturally and roasted lovingly, they're the star of every cup</p>
                </div>
            </div>
        </div>
    </div>

</header>