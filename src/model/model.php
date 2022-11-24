<?php
declare(strict_types=1);
namespace Model;

require_once(realpath(__DIR__ . '/../../vendor/Table.php'));
use Table\Table;

require_once(realpath(__DIR__ . '/../../vendor/utils/utils.php'));
use function Utils\join_paths;
use function Utils\read_json;



// ############################################################################
// News functions
// ############################################################################

/**
 * Function that gets data from json and sort the array 
 * @return {$news} An array of news     
 */
function get_news_array():array{

    $news_path_array = glob(__DIR__ . '/../../db/news/*.json');// devuelve array con los nombres de las noticias
    $news_to_array   = fn ($json_file) => read_json($json_file);
    $news            = array_map($news_to_array, $news_path_array);
    
    sort($news);// sort an array in descending   
    return $news;
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
// Gallery functions
// ############################################################################


function get_regions_api(array $region_name):array{

    foreach ($region_name as $region) {
        $api_url      = "https://pokeapi.co/api/v2/region/$region";
        $json_string  = shell_exec("curl $api_url");//? japi response in json
        $api_response = json_decode($json_string, true);//*json decoded
        $region_game_version = $api_response["version_groups"];
    }

    return [];
}

function get_region_name():array{
    $region_name_array  = glob(__DIR__ .'/../../public/img/regions_map/*.webp');
    $get_file_name      = fn($filename) => basename($filename);
    $get_pure_file_name = fn($filename) => substr($filename, 0,strlen($filename) - 5);

    $filenames_array   = array_map($get_file_name,$region_name_array);//*Arrray of img names with extension
    $region_name       = array_map($get_pure_file_name, $filenames_array);//*Array of images without extension, pure name
    
    $api_attack = get_regions_api($region_name);//TODO

    return $region_name_array;
}