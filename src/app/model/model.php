<?php
declare(strict_types=1);
namespace Model;

require_once(__DIR__ . '/../config.php');
use function Config\get_lib_dir;
use function Config\get_db_dir;
use function Config\get_app_dir;
use function Table\read_csv;

require_once(realpath(get_lib_dir() . '/table/Table.php'));
use Table\Table;

require_once(realpath(get_lib_dir() . '/utils/utils.php'));
use function Utils\join_paths;
use function Utils\read_json;


// ############################################################################
// Meta functions and vars
// ############################################################################
const CONTRIBUTORS=['Alvin Garcia', 'Raul Montoro', 'Eloy Gonzalez', 'Mario Barroso'];


// ############################################################################
// Login functions
// ############################################################################

function find_user(string $username, string $password):bool{
    //1.Read csv file and returns a table
    $users_table = read_csv(get_app_dir() . '/users.csv', '|');

    //2.Need to do a calleable function to find username and password on a table
    
    //$matched_user = $users_table->filterRows();

   
    

    return false;
}



// ############################################################################
// Announcements functions
// ############################################################################

/**
 * Function that gets data from json and sort the array 
 * @return {$announcements} An array of announcements     
 */
function get_announcements_array():array{

    $announcements_path_array = glob(get_db_dir() . '/announcements/*.json');// return an indexed array of news names
    $announcements_to_array   = fn ($json_file) => read_json($json_file);
    $announcements            = array_map($announcements_to_array, $announcements_path_array);
    
    sort($announcements);// sort an array in descending   
    return $announcements;
}

function add_announcement():void{

    if (isset($_POST['submit'])) {// post form has been submitted
        echo "Title: " . $_POST['title'];
    }
}




// ############################################################################
// Table functions
// ############################################################################

function get_csv_path(string $csv_id): string {

    $csv_suffix        = '.csv';
    $csv_relative_path = $csv_id . $csv_suffix;

    $db_dir        = realpath(join_paths(get_db_dir()));
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
function read_table(string $csv_filename): Table {
    $data = Table::readCsv($csv_filename);
    return $data;
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
    $region_name_array  = glob(get_app_dir() .'/../../public/img/regions_map/*.webp');
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
    $pokemon_img      = glob(get_app_dir() . "/../../public/img/regions/$region_name/*.webp");//*Get images (with .webp)
    $pokemon_img      = array_map($pokemon_img_name, $pokemon_img);//*new array with images path
    
    

    $pokemon_image_array[$region_name] = array_map($pokemon_img_path, $pokemon_img);//*associative array with region name as key and an indexed array with all the image paths
   
   }

    return $pokemon_image_array;
}

