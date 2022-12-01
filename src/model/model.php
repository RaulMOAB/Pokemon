<?php
declare(strict_types=1);
namespace Model;

require_once(realpath(__DIR__ . '/../../lib/Table.php'));
use Table\Table;

require_once(realpath(__DIR__ . '/../../lib/utils/utils.php'));
use function Utils\join_paths;
use function Utils\read_json;



// ############################################################################
// Announcements functions
// ############################################################################

/**
 * Function that gets data from json and sort the array 
 * @return {$announcements} An array of announcements     
 */
function get_announcements_array():array{

    $announcements_path_array = glob(__DIR__ . '/../../db/announcements/*.json');// devuelve array con los nombres de las noticias
    $announcements_to_array   = fn ($json_file) => read_json($json_file);
    $announcements            = array_map($announcements_to_array, $announcements_path_array);
    
    sort($announcements);// sort an array in descending   
    return $announcements;
}




// ############################################################################
// Table functions
// ############################################################################

function get_csv_path(string $csv_id): string {

    $csv_suffix        = '.csv';
    $csv_relative_path = $csv_id . $csv_suffix;

    $db_dir        = realpath(join_paths(__DIR__, '/../../db'));
    $csv_full_path = join_paths($db_dir, $csv_relative_path);

    return $csv_full_path;
}

// ----------------------------------------------------------------------------

function get_header(array $header):string{
    $header_html = "";
    foreach ($header as $value) {
        $header_html .= "<th>$value</th>";
    }

    return "<tr>$header_html</tr>";
}
// ----------------------------------------------------------------------------

function get_body(array $body):string{
    $body_html = "";
    foreach ($body as $row) {
        foreach ($row as $value) {
            $body_html .= "<td>$value</td>";
        }
        $body_html = "<tr>$body_html</tr>";
    }

    return $body_html;
}

// ----------------------------------------------------------------------------
function read_table(string $csv_filename): array {
    $data = Table::readCsv($csv_filename, ",");
    $header_table = get_header($data->header);
    $body_table   = get_body($data->body);
    return ["header" => $header_table, "body" => $body_table];
}

// ############################################################################
// Regions functions
// ############################################################################


function get_regions_api(array $region_name):array{

    foreach ($region_name as $region) {
      
        $pure_name_region = substr($region,0, strlen($region) - 5);
        
        $api_url      = "https://pokeapi.co/api/v2/region/$pure_name_region";
        $json_string  = shell_exec("curl $api_url");//? api response in json
        $api_response = json_decode($json_string, true);//*json decoded

        $region_game_version[$pure_name_region] = ["game_version" => $api_response["version_groups"],
                                                   "map_path"     => "img/regions_map/$region"];
        

    }
    

    return $region_game_version;
}

function get_region_name():array{
    $region_name_array  = glob(__DIR__ .'/../../public/img/regions_map/*.webp');
    $get_file_name      = fn($filename) => basename($filename);
    //$get_pure_file_name = fn($filename) => substr($filename, 0,strlen($filename) - 5);

    $filenames_array   = array_map($get_file_name,$region_name_array);//*Arrray of img names with extension
   // $region_name       = array_map($get_pure_file_name, $filenames_array);//*Array of images without extension, pure name
    

    return $filenames_array;
}

// ############################################################################
// Pokemons images functions
// ############################################################################

function get_pokemons(array $regions_name):array{

    $pokemon_image_array = [];
    
    foreach ($regions_name as $region) {
    $region_name      = substr($region,0, strlen($region) - 5);//*get clean region name from array $regions_name
    $pokemon_img_name = fn($filename) => basename($filename);//*Calleable function to get celan image name
    $pokemon_img_path = fn($filename) => "img/regions/$region_name/" . $filename;//*Calleable function to concatenate region_name + clean image filename
    $pokemon_img      = glob(__DIR__ . "/../../public/img/regions/$region_name/*.webp");//*Get images (with .webp)
    $pokemon_img      = array_map($pokemon_img_name, $pokemon_img);//*new array with images path
    
    

    $pokemon_image_array[$region_name] = array_map($pokemon_img_path, $pokemon_img);//*associative array with region name as key and an indexed array with all the image paths
   
   }

    return $pokemon_image_array;
}

