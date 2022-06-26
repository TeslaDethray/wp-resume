<!DOCTYPE html>
<!--[if IE 8]><html <?php language_attributes(); ?> class="ie8"><![endif]-->
<!--[if lte IE 9]><html <?php language_attributes(); ?> class="ie9"><![endif]-->
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
        <link rel="dns-prefetch" href="//google-analytics.com">
        <?php wp_head(); ?>
        <!--[if lt IE 10]>
        <script src="//cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js"></script>
        <![endif]-->
        <!--[if lt IE 9]>
        <script src="//cdnjs.cloudflare.com/ajax/libs/livingston-css3-mediaqueries-js/1.0.0/css3-mediaqueries.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/selectivizr/1.0.2/selectivizr-min.js"></script>
        <![endif]-->
    </head>
    <body <?php body_class(); ?>>
        <div class="flex-container">
            <header class="header flex-item teal-area" role="banner">
                <div class="container">
                    <h1>
                        <?php bloginfo('name'); ?>
                        <br />
                        <span class="white-text">
                            <?php bloginfo('description'); ?>
                        </span>
                    </h1>
                    <?php $summary = get_summary(); ?>
<!--                    <p>-->
<!--                        --><?php //echo $summary->phone_number; ?><!-- • --><?php //echo $summary->email; ?>
<!--                    </p>-->
                    <p>
                        <a href="<?php echo $summary->github_url; ?>">
                            <?php echo $summary->github_url; ?>
                        </a>
                        <br />
                        <a href="<?php echo $summary->linkedin_url; ?>">
                            <?php echo $summary->linkedin_url; ?>
                        </a>
                    </p>
                </div>
            </header>
