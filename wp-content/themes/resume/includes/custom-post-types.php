<?php

/*******************************
 * Custom post types
 *******************************/

/**
 * Registers the Education post type
 * @return void
 */
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

/**
 * Registers the Experience post type
 * @return void
 */
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

/**
 * Registers the Project post type
 * @return void
 */
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

/**
 * Registers the Skill post type
 * @return void
 */
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

/**
 * Registers the Summary post type
 * @return void
 */
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
