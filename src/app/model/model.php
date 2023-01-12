<?php
declare(strict_types=1);
namespace Model;

require_once(__DIR__ . '/../config.php');
use function Config\get_lib_dir;
use function Config\get_db_dir;
use function Config\get_app_dir;
use function Config\get_project_dir;
use function Config\get_session_dir;

require_once(realpath(get_lib_dir() . '/table/Table.php'));
use Table\Table;
use function Table\read_csv;
use function Utils\convert_to_string;
use function Utils\ensure_dir;

use User\User;

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

function csv_to_array(string $filename, string $separator = '|'):array{
    
    $csv_str = file_get_contents($filename);

    $users_array = explode(PHP_EOL, $csv_str);

    $split_lines = fn ($line) => array_map('trim', explode($separator, $line));

    $result = array_map($split_lines, $users_array);

    return $result;
}


function find_user(string $username, string $password):User{
    //1.Read csv file and returns an arrays with users
    $users_array = csv_to_array(get_app_dir() . '/users.csv');
    $user = [];
    $registered_user = new User();


    foreach ($users_array as $value) {
        if (($username == $value[0]) && ($password == $value[1])) {
            $user = ["username" => $value[0], "password" => $value[1], "rol" => $value[2]];
            $registred_user =  new User($user["username"], $user["password"], $user["rol"]);
            return $registred_user;
        }
    }
    return $registered_user;
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

function add_blog_announcement(array $announcement):void{

    //1.Get the announcements array from DB
    $announcement_path_array = glob(get_db_dir() . '/announcements/*.json'); // return an indexed array of news names

    //2. Build json properties(announcements sections)
    $id      = count($announcement_path_array) + 1;
    $date    = $announcement['date'];
    $title   = $announcement['title'];
    $content = $announcement['content'];

    //3. Build a new announcement  
    $announcement_array = [
        "id"      => $id,
        "date"    => $date,
        "title"   => $title,
        "content" => $content
    ];

    //*4. Do diferents json titles if the announcment has the same date
    //* exemple 2023-01-11 to 2023-01-11_1.json
    $count = 0;

    $get_file_name      = fn ($filename) => basename($filename);
    $json_filenames_array    = array_map($get_file_name, $announcement_path_array);

    foreach ($json_filenames_array as $announcement_name) {
        $name  = substr($announcement_name, 0, strlen($announcement_name) - 5);
        while ($name == $date) {
            $count++;
            $date = $date . '_' . $count;
        }
    }
    //5. Write to disk   
    $convert_to_json = convert_to_string($announcement_array, true);
    $json_file       = get_db_dir() . "/announcements/$date.json";

    ensure_dir(get_db_dir());
    file_put_contents($json_file, $convert_to_json);

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
    $header = explode(",", $header[0]);
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
            $tds = explode(",",$value);
            foreach ($tds as $td) {
                $body_html .= "<td>$td</td>";
            }
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

function add_pokemon(string $csv_filename, array $pokemon_data):void{

    //1. Read Pokemon data table
    $pokemon_table = Table::readCSV($csv_filename);

    //2. Get the last entry number
    $last_entry = csv_to_array($csv_filename, "|");
    $last_entry = count($last_entry);
    $pokemon_num["#"] = $last_entry;

    //pasar a string los values
    $pokemon_data = array_merge($pokemon_num, $pokemon_data);
    $pokemon_data =array_values($pokemon_data);
   
   

    $pokemon_table->appendRow([$pokemon_data]);
    $pokemon_table->writeCSV($csv_filename, ',');
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
    $filenames_array    = array_map($get_file_name,$region_name_array);//*Arrray of img names with extension
 
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

function get_pokemon_images(string $region_name):array{

    $clean_image_name = fn ($filename) => basename($filename);
    $region_img_path  = fn($filename) => "img/regions/$region_name/" . $filename;
    $pokemons_img     = glob(get_app_dir() . "/../../public/img/regions/$region_name/*.webp");
    $pokemons_img     = array_map($clean_image_name, $pokemons_img);//*array with images names ex: totodile.webp

    $regions_pokemon_img[$region_name] = array_map($region_img_path, $pokemons_img);

    return $regions_pokemon_img;
}

