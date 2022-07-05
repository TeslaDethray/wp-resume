<?php

require_once 'custom-post-getters.php';
require_once 'custom-post-types.php';
require_once 'formatter-functions.php';
require_once 'gui-helpers.php';

register_sidebar(['description' => 'Where photos go', 'id' => 'resume_photos', 'name' => 'Photos',]);
register_sidebar(['description' => 'Personal interests and hobbies', 'id' => 'resume_personal', 'name' => 'Interests & Hobbies',]);
