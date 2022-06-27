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
function get_filter_classes($skills) : string {
    if (!is_array($skills)) return 'filter';
    return 'filter ' . implode(' ', reduce_skills_to_name($skills));
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
    return $start_date->format($format_string) . ' - ' . (empty($end_date_string) ? 'Present' : $end_date->format($format_string));

}

