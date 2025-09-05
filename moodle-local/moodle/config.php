<?php
unset($CFG);
global $CFG;
$CFG = new stdClass();

$CFG->dbtype    = 'mysqli';
$CFG->dblibrary = 'native';
$CFG->dbhost    = 'localhost';
$CFG->dbname    = 'moodle_sysdesign';
$CFG->dbuser    = 'root';
$CFG->dbpass    = '';
$CFG->prefix    = 'mdl_';
$CFG->dboptions = array();

$CFG->wwwroot   = 'http://localhost:8000';
$CFG->dataroot  = '/Users/razkevich/system_design_course/moodle-local/moodledata';
$CFG->admin     = 'admin';

$CFG->directorypermissions = 0777;

// Disable debugging for cleaner output
$CFG->debug = 0;
$CFG->debugdisplay = 0;

require_once(__DIR__ . '/lib/setup.php');