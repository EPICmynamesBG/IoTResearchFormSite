<?php
static $CONFIG = [];

$CONFIG['dev'] = true;
if ($CONFIG['dev']){
    $CONFIG['config_file'] = 'dev';
} else {
    $CONFIG['config_file'] = 'prod';
}

require(dirname(__FILE__) . "/db_configs/{$CONFIG['config_file']}.php");
