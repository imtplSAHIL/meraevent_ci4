<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?php echo $blog_meta_title ?></title>
        <meta name="description" content="<?php echo $blog_meta_description ?>">
        <meta name="keywords" content="<?php echo $blog_meta_keywords ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="<?php echo site_url(); ?>css/public/blog/enow.custom.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <header class="hadr-blk">
            <div class="container">
                <h1 class="logo pulled-left"><a href="<?php echo site_url(); ?>blog"><img src="<?php echo site_url(); ?>images/logo.png" alt="" title=""></a></h1>
                <div class="pulled-right hadr-rit">
                    <aside class="srch-pnl pulled-left">
                        <form>
                            <input name="search-blog" placeholder="Search this blog" type="text">
                            <button><i class="fa fa-search"></i></button>
                        </form>
                    </aside>
                    <ul class="socl-mdi-list pulled-left">
                        <li><a href="https://www.facebook.com/meraeventsindia/"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="https://twitter.com/#!/meraeventsindia"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="https://www.linkedin.com/company/meraevents/"><i class="fa fa-linkedin"></i></a></li>
                    </ul>
                    <div class="mobileMenu pulled-right">
                        <div class="hamburger hamburger--elastic-r">
                            <div class="hamburger-box">
                                <div class="hamburger-inner"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>