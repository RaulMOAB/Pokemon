<?php
declare(strict_types=1);
namespace View;

require_once(realpath(__DIR__ . '/../../vendor/utils/utils.php'));
use function Utils\join_paths;

// ############################################################################
// Template functions
// ############################################################################

// Example: '/body/index' => '/app/src/view/body/index.template.php'
// ----------------------------------------------------------------------------
function getTemplatePath(string $template_name): string{

    $template_suffix = '.template.php';
    $template_path   = __DIR__ .  $template_name . $template_suffix;

    return $template_path;
}
function getPokemonName(string $img_path):string{
    $filename= basename($img_path);  
    $name = substr($filename,0,-5);

    return ucfirst($name);  
}
