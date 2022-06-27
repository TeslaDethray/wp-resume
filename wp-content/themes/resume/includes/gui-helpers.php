<?php

require_once 'formatter-functions.php';

/*******************************
 * Custom post GUI helpers
 *******************************/

/**
 * Returns the classes of every event and skill in a job to be used for filtering by skill
 * @param $job
 * @return string
 */
function get_all_filter_classes(object $job) : string {
    $skill_classes = reduce_skills_to_name($job->skills);
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
