<?php

/**
 * Custom functions / External files
 */

require_once 'includes/custom-functions.php';


/**
 * Add support for useful stuff
 */

if ( function_exists( 'add_theme_support' ) ) {

    // Add support for document title tag
    add_theme_support( 'title-tag' );

    // Add Thumbnail Theme Support
    add_theme_support( 'post-thumbnails' );
    // add_image_size( 'custom-size', 700, 200, true );

    // Add Support for post formats
    // add_theme_support( 'post-formats', ['post'] );
    // add_post_type_support( 'page', 'excerpt' );

    // Localisation Support
    load_theme_textdomain( 'barebones', get_template_directory() . '/languages' );
}


/**
 * Hide admin bar
 */

add_filter( 'show_admin_bar', '__return_false' );


/**
 * Remove junk
 */

remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'start_post_rel_link');
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');


/**
 * Remove comments feed
 *
 * @return void
 */

function barebones_post_comments_feed_link() {
    return;
}

add_filter('post_comments_feed_link', 'barebones_post_comments_feed_link');


/**
 * Enqueue scripts
 */

function barebones_enqueue_scripts() {
    // wp_enqueue_style( 'fonts', '//fonts.googleapis.com/css?family=Font+Family' );
    // wp_enqueue_style( 'icons', '//use.fontawesome.com/releases/v5.0.10/css/all.css' );
    wp_enqueue_style( 'styles', get_stylesheet_directory_uri() . '/style.css?' . filemtime( get_stylesheet_directory() . '/style.css' ) );
    wp_enqueue_script( 'scripts', get_stylesheet_directory_uri() . '/js/scripts.min.js?' . filemtime( get_stylesheet_directory() . '/js/scripts.min.js' ), [], null, true );
}

add_action( 'wp_enqueue_scripts', 'barebones_enqueue_scripts' );


/**
 * Add async and defer attributes to enqueued scripts
 *
 * @param string $tag
 * @param string $handle
 * @param string $src
 * @return void
 */

function defer_scripts( $tag, $handle, $src ) {

    // The handles of the enqueued scripts we want to defer
    $defer_scripts = [
        'SCRIPT_ID'
    ];

    // Find scripts in array and defer
    if ( in_array( $handle, $defer_scripts ) ) {
        return '<script type="text/javascript" src="' . $src . '" defer="defer"></script>' . "\n";
    }

    return $tag;
}

add_filter( 'script_loader_tag', 'defer_scripts', 10, 3 );


/**
 * Add custom scripts to head
 *
 * @return string
 */

function add_gtag_to_head() {

    // Check is staging environment
    if ( strpos( get_bloginfo( 'url' ), '.test' ) !== false ) return;

    // Google Analytics
    $tracking_code = 'UA-*********-1';

    ?>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $tracking_code; ?>"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', '<?php echo $tracking_code; ?>');
    </script>
    <?php
}

add_action( 'wp_head', 'add_gtag_to_head' );



/**
 * Remove unnecessary scripts
 *
 * @return void
 */

function deregister_scripts() {
    wp_deregister_script( 'wp-embed' );
}

add_action( 'wp_footer', 'deregister_scripts' );


/**
 * Remove unnecessary styles
 *
 * @return void
 */

function deregister_styles() {
    wp_dequeue_style( 'wp-block-library' );
}

add_action( 'wp_print_styles', 'deregister_styles', 100 );


/**
 * Register nav menus
 *
 * @return void
 */

function barebones_register_nav_menus() {
    register_nav_menus([
        'header' => 'Header',
        'footer' => 'Footer',
    ]);
}

add_action( 'after_setup_theme', 'barebones_register_nav_menus', 0 );


/**
 * Nav menu args
 *
 * @param array $args
 * @return void
 */

function barebones_nav_menu_args( $args ) {
    $args['container'] = false;
    $args['container_class'] = false;
    $args['menu_id'] = false;
    $args['items_wrap'] = '<ul class="%2$s">%3$s</ul>';

    return $args;
}

add_filter('wp_nav_menu_args', 'barebones_nav_menu_args');


/**
 * Button Shortcode
 *
 * @param array $atts
 * @param string $content
 * @return void
 */

function barebones_button_shortcode( $atts, $content = null ) {
    $atts['class'] = isset($atts['class']) ? $atts['class'] : 'btn';
    return '<a class="' . $atts['class'] . '" href="' . $atts['link'] . '">' . $content . '</a>';
}

add_shortcode('button', 'barebones_button_shortcode');


/**
 * TinyMCE
 *
 * @param array $buttons
 * @return void
 */

function barebones_mce_buttons_2( $buttons ) {
    array_unshift( $buttons, 'styleselect' );
    $buttons[] = 'hr';

    return $buttons;
}

add_filter('mce_buttons_2', 'barebones_mce_buttons_2');


/**
 * TinyMCE styling
 *
 * @param array $settings
 * @return void
 */

function barebones_tiny_mce_before_init( $settings ) {
    $style_formats = [
        // [
        //     'title'    => '',
        //     'selector' => '',
        //     'classes'  => ''
        // ],
        // [
        //     'title' => 'Buttons',
        //     'items' => [
        //         [
        //             'title'    => 'Primary',
        //             'selector' => 'a',
        //             'classes'  => 'btn btn--primary'
        //         ],
        //         [
        //             'title'    => 'Secondary',
        //             'selector' => 'a',
        //             'classes'  => 'btn btn--secondary'
        //         ]
        //     ]
        // ]
    ];

    $settings['style_formats'] = json_encode($style_formats);
    $settings['style_formats_merge'] = true;

    return $settings;
}

add_filter('tiny_mce_before_init', 'barebones_tiny_mce_before_init');


/**
 * Get post thumbnail url
 *
 * @param string $size
 * @param boolean $post_id
 * @param boolean $icon
 * @return void
 */

function get_post_thumbnail_url( $size = 'full', $post_id = false, $icon = false ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }

    $thumb_url_array = wp_get_attachment_image_src(
        get_post_thumbnail_id( $post_id ), $size, $icon
    );
    return $thumb_url_array[0];
}


/**
 * Add Front Page edit link to admin Pages menu
 */

function front_page_on_pages_menu() {
    global $submenu;
    if ( get_option( 'page_on_front' ) ) {
        $submenu['edit.php?post_type=page'][501] = array(
            __( 'Front Page', 'barebones' ),
            'manage_options',
            get_edit_post_link( get_option( 'page_on_front' ) )
        );
    }
}

add_action( 'admin_menu' , 'front_page_on_pages_menu' );

function post_remove () {
    remove_menu_page('edit.php');
}

add_action('admin_menu', 'post_remove');

function page_remove () {
    remove_menu_page('edit.php?post_type=page');
}

add_action('admin_menu', 'page_remove');

function comments_remove () {
    remove_menu_page('edit-comments.php');
}

add_action('admin_menu', 'comments_remove');

function users_remove () {
    remove_menu_page('users.php');
}

add_action('admin_menu', 'users_remove');

function summary_custom_post_type() {
    register_post_type('summary',
        array(
            'labels'      => array(
                'name'          => __('Summary', 'textdomain'),
                'singular_name' => __('Summary', 'textdomain'),
            ),
            'supports'    => ['editor', 'title'],
            'public'      => true,
            'has_archive' => true,
            'menu_icon'   => 'dashicons-media-text',
        )
    );
}
add_action('init', 'summary_custom_post_type');

function experience_custom_post_type() {
    register_post_type('experience',
        array(
            'labels'      => array(
                'name'          => __('Experience', 'textdomain'),
                'singular_name' => __('Experience', 'textdomain'),
            ),
            'supports'    => ['custom-fields', 'title'],
            'public'      => true,
            'has_archive' => true,
            'menu_icon'   => 'dashicons-admin-site-alt2',
        )
    );
}
add_action('init', 'experience_custom_post_type');

function education_custom_post_type() {
    register_post_type('education',
        array(
            'labels'      => array(
                'name'          => __('Education', 'textdomain'),
                'singular_name' => __('Education', 'textdomain'),
            ),
            'supports'    => ['custom-fields', 'title'],
            'public'      => true,
            'has_archive' => true,
            'menu_icon'   => 'dashicons-welcome-learn-more',
        )
    );
}
add_action('init', 'education_custom_post_type');

function skill_custom_post_type() {
    register_post_type('skill',
        array(
            'labels'      => array(
                'name'          => __('Skills', 'textdomain'),
                'singular_name' => __('Skill', 'textdomain'),
            ),
            'supports'    => ['title'],
            'public'      => true,
            'has_archive' => true,
            'taxonomies'  => ['category'],
            'menu_icon'   => 'dashicons-admin-tools',
        )
    );
}
add_action('init', 'skill_custom_post_type');

function project_custom_post_type() {
    register_post_type('project',
        array(
            'labels'      => array(
                'name'          => __('Projects', 'textdomain'),
                'singular_name' => __('Project', 'textdomain'),
            ),
            'supports'    => ['custom-fields', 'title', 'excerpt'],
            'public'      => true,
            'has_archive' => true,
            'menu_icon'   => 'dashicons-art',
        )
    );
}
add_action('init', 'project_custom_post_type');

function get_skills() : array {
    $skills_posts = get_posts([
        'numberposts' => -1,
        'post_type' => 'skill',
    ]);

    $skills = [];
    foreach($skills_posts as $skill) {
        $skills[$skill->ID] = (object)[
            'id' => $skill->ID,
            'skill' => $skill->post_title,
        ];
    }
    return $skills;
}

function format_events ($info) : array {
    $fields = [
        'what_did_you_do' => function ($value) {
            return array_shift($value);
        },
        'what_skills_were_used' =>
            function ($value) {
                $serialized_string = array_shift($value);
                return maybe_unserialize($serialized_string);
            }
    ];

    $skills = get_skills();
    $prepared = [];
    $i = 0;
    while (isset($info['events_' . $i . '_what_did_you_do'])) {
        $prepared[$i] = (object)[];
        foreach($fields as $field => $formatter) {
            $datum = $info['events_' . $i . '_' . $field];
            if (is_callable($formatter)) {
                $datum = $formatter($datum);
            }
            if (is_array($datum)) {
                $datum = array_map(
                    function ($skill_id) use ($skills) {
                        return $skills[$skill_id];
                    },
                    $datum
                );
            }
            $prepared[$i]->{$field} = $datum;
        }
        $i++;
    }
  return $prepared;
}

function format_timespan($start_date_string, $end_date_string) : string {
    $start_date = new DateTime($start_date_string);
    $end_date = new DateTime($end_date_string);
    $format_string = 'Y';
    $year_span = (integer)$start_date->diff($end_date)->format('%R%y');
    if ($year_span < 2) {
        $format_string = 'F Y';
    }
    return sprintf('%d - %s', $start_date->format($format_string), $end_date->format($format_string));
}

function get_education() : array {
    $education = [];
    $posts = get_posts([
      'numberposts' => -1,
      'post_type' => 'education',
    ]);
    foreach ($posts as $post) {
        $custom_info = get_post_custom($post->ID);
        $end_date = array_shift($custom_info['end_date']);
        $start_date = array_shift($custom_info['start_date']);
        $education[$start_date] = (object)[
            'end_date' => $end_date,
            'fields_of_study' => array_shift($custom_info['fields_of_study']),
            'institution' => array_shift($custom_info['institution_name']),
            'location' => array_shift($custom_info['location']),
            'start_date' => $start_date,
            'timespan' => format_timespan($start_date, $end_date),
        ];
    }
    krsort($education);
    return $education;
}

function get_experience() : array {
    $experience = [];
    $posts = get_posts([
       'numberposts' => -1,
       'post_type' => 'experience',
    ]);

    foreach ($posts as $post) {
        $custom_info = get_post_custom($post->ID);
        $end_date = array_shift($custom_info['end_date']);
        $start_date = array_shift($custom_info['start_date']);
        $experience[$start_date] = (object)[
           'company' => array_shift($custom_info['company_name']),
           'description' => array_shift($custom_info['company_description']),
           'end_date' => $end_date,
           'events' => format_events($custom_info),
           'job_title' => array_shift($custom_info['job_title']),
           'location' => array_shift($custom_info['company_location']),
           'start_date' => $start_date,
           'timespan' => format_timespan($start_date, $end_date),
           'url' => array_shift($custom_info['url']),
       ];
    }
    krsort($experience);
    return $experience;
}

function get_summary() : object {
    $posts = get_posts([
        'numberposts' => 1,
        'post_type' => 'summary',
    ]);
    $post = array_shift($posts);
    $custom_info = get_post_custom($post->ID);
    return (object)[
        'email' => strtolower(array_shift($custom_info['email_address'])),
        'github_url' => array_shift($custom_info['github_url']),
        'linkedin_url' => array_shift($custom_info['linkedin_url']),
        'phone_number' => array_shift($custom_info['phone_number']),
        'summary' => $post->post_content,
    ];
}
