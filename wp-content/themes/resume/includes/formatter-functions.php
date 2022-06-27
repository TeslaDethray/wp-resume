<?php

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
 * @param array $skills
 * @return array
 */
function format_events(array $info, array $skills) : array {
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
