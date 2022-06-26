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
                        <?php if (!empty(get_bloginfo('description'))) : ?>
                            <br />
                            <span class="white-text">
                                <?php bloginfo('description'); ?>
                            </span>
                        <?php endif; ?>
                    </h1>
                    <?php $summary = get_summary(); ?>
                    <?php if (!empty($summary->github_url) || !empty($summary->linkedin_url)) : ?>
                        <p>
                            <?php if (!empty($summary->github_url)) : ?>
                                <a href="<?php echo $summary->github_url; ?>">
                                    <?php echo $summary->github_url; ?>
                                </a>
                            <?php endif; ?>
                            <?php if (!empty($summary->linkedin_url)) : ?>
                                <br />
                                <a href="<?php echo $summary->linkedin_url; ?>">
                                    <?php echo $summary->linkedin_url; ?>
                                </a>
                            <?php endif; ?>
                        </p>
                    <?php endif; ?>
                    <?php if (!empty($summary->resume_url)) : ?>
                        <p>
                            <a download href="<?php echo $summary->resume_url; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-file-earmark-arrow-down-fill" viewBox="0 0 16 16">
                                    <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zm-1 4v3.793l1.146-1.147a.5.5 0 0 1 .708.708l-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 0 1 .708-.708L7.5 11.293V7.5a.5.5 0 0 1 1 0z"/>
                                </svg>
                                <span class="bottom-up-2">Download PDF</span>
                            </a>
                        </p>
                    <?php endif; ?>
                </div>
            </header>
