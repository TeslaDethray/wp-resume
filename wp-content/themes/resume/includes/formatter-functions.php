<?php

/*******************************
 * Custom post type formatters
 *******************************/

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
 * @return array|string
 */
function shift_data($data) {
    return !empty($data) ? array_shift($data) : $data;
};

/**
 * Unserializes the skill ID lists returned by the API
 * @param array $value
 * @param array $skills
 * @return array|string
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

