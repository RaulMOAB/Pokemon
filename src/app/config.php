<?php
declare(strict_types=1);
namespace Config;


//*Get directories
function get_project_dir():string  { return realpath(__DIR__ . '/../..'); }

function get_db_dir(): string           { return get_project_dir() . '/db'; }
function get_public_dir():string        { return get_project_dir() . '/public'; }
function get_source_dir():string        { return get_project_dir() . '/src'; }
function get_app_dir(): string          { return get_project_dir() . '/src/app'; }
function get_lib_dir(): string          { return get_project_dir() . '/src/lib'; }
function get_controller_dir(): string   { return get_project_dir() . '/src/app/controller'; }
function get_model_dir(): string        { return get_project_dir() . '/src/app/model';      }
function get_view_dir(): string         { return get_project_dir() . '/src/app/view';       }
