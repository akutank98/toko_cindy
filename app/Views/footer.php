<style>
    .site-footer {
        background-color: #838383;
        text-align: center;
        padding: 10px 0;
        position: fixed;
        top: 87vh;
        width: 100%;
        max-height: 15vh;
        bottom: 0;
    }

    #social-wrapper {
        text-align: center;
    }

    /*Social Media Icons*/
    .social-wrapper {
        text-align: center;
    }

    .social-wrapper ul li {
        display: inline;
        margin: 0 5px;
    }

    .twitter-icon,
    .facebook-icon,
    .instagram-icon,
    .googlemail-icon,
    .whatsapp-icon {
        margin-top: .625em;
        width: 40px;
        height: 40px;
        opacity: .6;
        filter: alpha(opacity=60);
        /* For IE8 and earlier */
        border-radius: 25px;
    }

    .twitter-icon:hover,
    .facebook-icon:hover,
    .instagram-icon:hover,
    .googlemail-icon:hover,
    .whatsapp-icon:hover {
        opacity: 1.0;
        filter: alpha(opacity=100);
        /* For IE8 and earlier */
    }

    .footer-nav p {
        text-align: center;
    }
</style>
<div>
    <footer id="colophon" class="site-footer" role="contentinfo">
        <div class="social-wrapper">
            <ul>
                <li>
                    <a href="#" target="_blank">
                        <img src="<?= base_url('icons/twitter.png') ?>" alt="Twitter Logo" class="twitter-icon"></a>
                </li>
                <li>
                    <a href="https://www.instagram.com/cindy.babyshop/" target="_blank">
                        <img src="<?= base_url('icons/instagram.png') ?>" alt="Instagram Logo" class="instagram-icon"></a>
                </li>
                <li>
                    <a href="https://www.facebook.com/tokocindy.tulungagung/" target="_blank">
                        <img src="<?= base_url('icons/facebook.ico') ?>" alt="Facebook Logo" class="facebook-icon"></a>
                </li>
                <li>
                    <a href="mailto:tokocindy@gmail.com" target="_blank">
                        <img src="<?= base_url('icons/gmail.svg') ?>" alt="GoogleMail Logo" class="googlemail-icon"></a>
                </li>
                <a href="https://wa.me/628155051048" target="_blank">
                    <img src="<?= base_url('icons/whatsapp.png') ?>" alt="whatsapp Logo" class="whatsapp-icon"></a>

            </ul>
        </div>
        <nav class="footer-nav" role="navigation">
            <p>
                Copyright &copy; 2021- Toko Cindy. All rights reserved.
            </p>
        </nav>
    </footer>
</div>
<?= $this->section('script'); ?>
<script>
    // $(window).on("scroll", function() {
    //     if ((window.innerHeight + window.scrollY) >= ) {
    //         $(".site-footer").fadeIn("fast").addClass("show");
    //     } else {
    //         $(".site-footer").fadeOut("fast").removeClass("show");
    //     }
    // });
    $(window).scroll(function(event) {
        function footer() {
            var scroll = $(window).scrollTop();
            if (scroll > 0) {
                $(".site-footer").fadeIn("fast").addClass("show");
            } else {
                $(".site-footer").fadeOut("fast").removeClass("show");
            }
            //autodismiss
            // clearTimeout($.data(this, 'scrollTimer'));
            // $.data(this, 'scrollTimer', setTimeout(function() {
            //     if ($('.site-footer').is(':hover')) {
            //         footer();
            //     } else {
            //         $(".site-footer").fadeOut("slow");
            //     }
            // }, 2000));
        }
        footer();
    });
</script>
<?= $this->endSection(); ?>