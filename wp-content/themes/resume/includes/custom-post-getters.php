<?php

require_once 'formatter-functions.php';

/*******************************
 * Custom post type retrievers
 *******************************/

/**
 * Returns all education posts
 * @return array
 * @throws Exception
 */
function get_education() : array {
    $education = [];
    $posts = get_posts([
        'numberposts' => -1,
        'post_type' => 'education',
    ]);
    $skills = get_skills();
    foreach ($posts as $post) {
        $custom_info = get_post_custom($post->ID);
        $end_date = shift_data($custom_info['end_date']);
        $start_date = shift_data($custom_info['start_date']);
        $education[$start_date] = (object)[
            'degree' => shift_data($custom_info['degree']),
            'end_date' => $end_date,
            'fields_of_study' => shift_data($custom_info['fields_of_study']),
            'institution' => shift_data($custom_info['institution_name']),
            'location' => shift_data($custom_info['location']),
            'skills' => unserialize_skills($custom_info['skills'], $skills),
            'start_date' => $start_date,
            'timespan' => format_timespan($start_date, $end_date),
        ];
    }
    krsort($education);
    return $education;
}

/**
 * Returns all experience posts
 * @return array
 * @throws Exception
 */
function get_experience() : array {
    $experience = [];
    $posts = get_posts([
        'numberposts' => -1,
        'post_type' => 'experience',
    ]);
    $skills = get_skills();

    foreach ($posts as $post) {
        $custom_info = get_post_custom($post->ID);
        $end_date = shift_data($custom_info['end_date']);
        $start_date = shift_data($custom_info['start_date']);
        $experience[$start_date] = (object)[
            'company' => shift_data($custom_info['company_name']),
            'description' => shift_data($custom_info['company_description']),
            'end_date' => $end_date,
            'events' => format_events($custom_info, $skills),
            'job_title' => shift_data($custom_info['job_title']),
            'location' => shift_data($custom_info['company_location']),
            'skills' => unserialize_skills($custom_info['skills'], $skills),
            'start_date' => $start_date,
            'timespan' => format_timespan($start_date, $end_date),
            'url' => shift_data($custom_info['url']),
        ];
    }
    krsort($experience);
    return $experience;
}

/**
 * Returns all projects posts
 * @return array
 */
function get_projects() : array {
    $skills = get_skills();
    $projects = [];
    $posts = get_posts([
        'numberposts' => -1,
        'post_type' => 'project',
    ]);
    foreach ($posts as $post) {
        $custom_info = get_post_custom($post->ID);
        $projects[] = (object)[
            'description' => $post->post_excerpt,
            'skills' => unserialize_skills($custom_info['skills'], $skills),
            'title' => $post->post_title,
            'url' => shift_data($custom_info['url']),
        ];
    }
    krsort($projects);
    return $projects;
}

/**
 * Returns all skill posts
 * @param bool $by_title
 * @return array
 */
function get_skills(bool $by_title = false) : array {
    $skills_posts = get_posts([
        'numberposts' => -1,
        'post_type' => 'skill',
    ]);
    $skills = [];
    foreach($skills_posts as $skill) {
        if ($by_title) {
            $id = $skill->post_name;
        } else {
            $id = $skill->ID;
        }
        $skills[$id] = (object)[
            'id' => $skill->ID,
            'name' => $skill->post_name,
            'skill' => $skill->post_title,
        ];
    }
    ksort($skills);
    return $skills;
}

/**
 * Returns only the latest summary post
 * @return object
 */
function get_summary() : object {
    $posts = get_posts([
        'numberposts' => 1,
        'order' => 'DESC',
        'post_type' => 'summary',
    ]);
    $post = array_shift($posts);
    $custom_info = get_post_custom($post->ID);
    return (object)[
        'email' => strtolower(shift_data($custom_info['email_address'])),
        'github_url' => shift_data($custom_info['github_url']),
        'linkedin_url' => shift_data($custom_info['linkedin_url']),
        'resume_url' => wp_get_attachment_url(shift_data($custom_info['resume_url'])),
        'phone_number' => shift_data($custom_info['phone_number']),
        'summary' => $post->post_content,
    ];
}
