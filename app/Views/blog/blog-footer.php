<footer class="fotr-blk clearBlock">
    <div class="container">
        <div class="ftr-links">
            <a href="<?php echo site_url() . 'terms'; ?>">Terms &amp; Conditions</a>
        </div>
        <p class="pull-left"> © 2009-<?php echo date(Y); ?>, Copyright @ Versant Online Solutions Pvt Ltd. All Rights Reserved </p>
        <ul class="socl-mdi-list pulled-right">
            <li><a href="https://www.facebook.com/meraeventsindia/"><i class="fa fa-facebook"></i></a></li>
            <li><a href="https://twitter.com/#!/meraeventsindia"><i class="fa fa-twitter"></i></a></li>
            <li><a href="https://www.linkedin.com/company/meraevents/"><i class="fa fa-linkedin"></i></a></li>
        </ul>
    </div>
</footer>
<div class="mdl-pop"> <span class="cls-mdl"><i class="fa fa-times-circle"></i></span>
    <div class="mdl-cont">
        <iframe class="enow-vid-ply" width="100%" height="100%" src="" frameborder="0" allowfullscreen></iframe>
    </div>
</div>
<div class="mobmenu-slider">
    <div class="srch-pnl">
        <form>
            <input name="search-blog" placeholder="Search this blog" type="text">
            <button><i class="fa fa-search"></i></button>
        </form>
        <div class="closeSlide"><i class="fa fa-close"></i></div>
    </div>
    <div class="mob-menu-list">
        <ul class="socl-mdi-list">
            <li><a href="https://www.facebook.com/meraeventsindia/"><i class="fa fa-facebook"></i></a></li>
            <li><a href="https://twitter.com/#!/meraeventsindia"><i class="fa fa-twitter"></i></a></li>
            <li><a href="https://www.linkedin.com/company/meraevents/"><i class="fa fa-linkedin"></i></a></li>
        </ul>
    </div>
</div>

<script src="<?php echo site_url(); ?>js/public/jQuery.min.js"></script> <!--/*! jQuery v2.2.4 | (c) jQuery Foundation | jquery.org/license */--> 
<script src="<?php echo site_url(); ?>js/public/plugins.min.js"></script> 
<script>
    $(window).load(function () {
        $(".se-pre-con").fadeOut("slow");
        ;
    });
</script> 
<script>

    $(document).ready(function () {
        ///////////////////////// MAIN BANNER 
        var conS = $('.banner-carousel');
        conS.contSlider({
            margin: 0, loop: true,
            items: 1,
            autoplay: true,
            autoplayTimeout: 3000,
            autoplayHoverPause: false
        });
        ///////////////////////// CLIENT ICONS SLIDE
        var conS = $('.clnt-logo');
        conS.contSlider({
            margin: 0, loop: true,
            responsive: {
                1025: {items: 11, },
                767: {items: 6, },
                480: {items: 5, },
                320: {items: 3, },
            },
            autoplay: true,
            slideSpeed: 1000,
            autoplayHoverPause: false
        });
        ///////////////////////// VIDEO SCROLL BAR HEIGHT
        $(window).load(function () {
            var bannerHeight = $(".owl-stage-outer img").height()
            $(".vid-pnl").css('height', bannerHeight);
        });

        ///////////////////////// VIDEO BLOCK POPUP CLOSE OPEN
        $(".enow-vid").click(function () {
            $(".mdl-pop").addClass("show-vid");
        });
        $(".cls-mdl").click(function () {
            $(".mdl-pop").removeClass("show-vid");
        });
        ///////////////////////// VIDEO BLOCK CLICK TO GET THIS URL SRC
        $(function () {
            $('.enow-vid').click(function () {
                var isVidLink = $(this).attr('onclick')
                $(".enow-vid-ply").attr("src", isVidLink);
            });
        });
        $('.cls-mdl').click(function () {
            $(".enow-vid-ply").attr('src', '');
        });
        ///////////////////////// MOBILE MENU HAMBURGER ICON
        var forEach = function (t, o, r) {
            if ("[object Object]" === Object.prototype.toString.call(t))
                for (var c in t)
                    Object.prototype.hasOwnProperty.call(t, c) && o.call(r, t[c], c, t);
            else
                for (var e = 0, l = t.length; l > e; e++)
                    o.call(r, t[e], e, t)
        };
        var hamburgers = document.querySelectorAll(".hamburger");
        if (hamburgers.length > 0) {
            forEach(hamburgers, function (hamburger) {
                hamburger.addEventListener("click", function () {
                    this.classList.toggle("is-active");

                }, false);
            });
        }
        ///////////////////////// MOBILE MENU SLIDE OPEN CLOSE FUNCTION
        $(".hamburger").click(function () {
            $("body").addClass("onmenfix");
            $(".mobmenu-slider").addClass("showSlider");
        });

        $(".closeSlide").click(function () {
            $("body").removeClass("onmenfix");
            $(".mobmenu-slider").removeClass("showSlider");
            $(".hamburger").removeClass("is-active");
        });
        ///////////////////////// SUBSCRIPBE POPUP 
        $(".cls-mp").click(function () {
            $(".modelPopup").fadeOut();
        });
        $(".sub-nltr").click(function () {
            $(".modelPopup").fadeIn();
        });
    })

    $("#postbtn").click(function () {

        var name = $('#name').val();
        var email = $('#email').val();
        var comment = $('#comment').val();
        var article_id = $('#article_id').val();
        $.ajax({
            url: "<?php echo commonHelperGetPageUrl('blog_savecomments'); ?>",
            method: "POST",
            cache: false,
            beforeSend: function () {
                $("#loadingDiv").show();
            },
            data: {name: name, email: email, comment: comment, article_id: article_id},
            success: function (data) {
                if (data == 1) {
                    $('#articleComments')[0].reset();
                    $('#loadingDiv').hide();
                    $('.comment-resp-msg').empty().append('Comment successfully saved. Need admin approval to dispaly');
                }
            }
        });
    });
</script>
</body>
</html>