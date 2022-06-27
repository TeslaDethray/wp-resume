<?php

if(in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1'])) {
    require_once(ABSPATH . 'wp-config-local.php');
} else {
    require_once(ABSPATH . 'wp-config-production.php');
}
