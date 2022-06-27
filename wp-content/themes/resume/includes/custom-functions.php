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

/*******************************
 * Custom post type formatters
 *******************************/

/**
 * Unserializes the skill ID lists returned by the API
 * @param array $value
 * @param array $skills
 * @return array|mixed|string
 */
function unserialize_skills(array $value, array $skills) {
    $unserialized_data = array_shift($value);
    $data = maybe_unserialize($unserialized_data);
    if (!is_array($data)) {
        return $data;
    }
    return array_map(
        function ($skill_id) use ($skills) {
            return $skills[$skill_id];
        },
        $data
    );
}

/**
 * Formats the events data and links skills
 * @param array $info
 * @return array
 */
function format_events (array $info) : array {
    $skills = get_skills();
    $fields = [
        'what_did_you_do' => function ($value) {
            return array_shift($value);
        },
        'skills' =>
            function ($value) use ($skills) {
                return unserialize_skills($value, $skills);
            }
    ];

    $prepared = [];
    $i = 0;
    while (isset($info['events_' . $i . '_skills'])) {
        $prepared[$i] = (object)[];
        foreach($fields as $field => $formatter) {
            $prepared[$i]->{$field} = $formatter($info['events_' . $i . '_' . $field]);
        }
        $i++;
    }
    return $prepared;
}

/**
 * Unserializes the skills list and links it with the skill objects
 * @param array $info
 * @return array
 */
function format_skills (array $info) : array {
    $skills = get_skills();
    $fields_skills = function ($value) use ($skills) {
        if (is_array($value)) {
            return unserialize_skills($value, $skills);
        }
        return [];
    };

    $prepared = [];
    $i = 0;
    $key = fn ($num) => 'events_' . $num . '_skills';
    while (isset($info[$key($i)])) {
        $prepared[$i] = $fields_skills($info[$key($i)]);
        $i++;
    }
    return $prepared;
}

/**
 * Formats two dates into a presentable string based on their distance to each other.
 * @param $start_date_string
 * @param $end_date_string
 * @return string
 * @throws Exception
 */
function format_timespan($start_date_string, $end_date_string) : string {
    $start_date = new DateTime($start_date_string);
    $end_date = new DateTime($end_date_string);
    $format_string = 'Y';
    $year_span = (integer)$start_date->diff($end_date)->format('%R%y');
    if ($year_span < 2) {
        $format_string = 'F Y';
    }
    return $start_date->format($format_string) . ' - ' . $end_date->format($format_string);
}

/**
 * Takes an array of Skill objects and returns an array of their names.
 * @param $skills
 * @return array
 */
function reduce_skills_to_name(array $skills) : array {
    return array_map(
        function ($skill) {
            return $skill->name;
        },
        $skills
    );
}

/**
 * Returns the object itself if the data is empty and the first component of the array if not.
 * @param $data
 * @return mixed
 */
function shift_data(mixed $data) : mixed{
    return !empty($data) ? array_shift($data) : $data;
};

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

    foreach ($posts as $post) {
        $custom_info = get_post_custom($post->ID);
        $end_date = shift_data($custom_info['end_date']);
        $start_date = shift_data($custom_info['start_date']);
        $experience[$start_date] = (object)[
            'company' => shift_data($custom_info['company_name']),
            'description' => shift_data($custom_info['company_description']),
            'end_date' => $end_date,
            'events' => format_events($custom_info),
            'job_title' => shift_data($custom_info['job_title']),
            'location' => shift_data($custom_info['company_location']),
            'skills' => format_skills($custom_info),
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

/*******************************
 * Custom post GUI helpers
 *******************************/

/**
 * Returns the classes of every event and skill in a job to be used for filtering by skill
 * @param $job
 * @return string
 */
// TODO add job skills
function get_all_filter_classes($job) : string {
    $skill_classes = [];
    foreach ($job->events as $event) {
        if (is_array($event->skills)) {
            $skill_classes = array_merge($skill_classes, reduce_skills_to_name($event->skills));
        }
    }
    $skill_classes = array_unique($skill_classes);
    return 'filter ' . implode(' ', $skill_classes);
}

/**
 * Returns the classes to be used for filtering by skill
 * @param array|string|null $skills
 * @return string
 */
function get_filter_classes(mixed $skills) : string {
    if (!is_array($skills)) return 'filter';
    return 'filter ' . implode(' ', reduce_skills_to_name($skills));
}
