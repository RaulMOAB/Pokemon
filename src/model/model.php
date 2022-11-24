<?php
declare(strict_types=1);
namespace Model;

require_once(realpath(__DIR__ . '/../../vendor/table.php'));
use Table\Table;

require_once(realpath(__DIR__ . '/../../vendor/utils/utils.php'));
use function Utils\join_paths;
use function Utils\read_json;



// ############################################################################
// News functions
// ############################################################################


/* function get_file_name(string $path):string{
    return basename($path);
} */




/**
 * Function that gets data from json and sort the array 
 * @return {$news_array} An array of news formated    
 */
function get_news_array():array{

    $get_file_name = fn($path) => basename($path);
    $news_array                     = [];//array final a devolver despues del glob() y el basename()
    $news_path_array                = glob(__DIR__ . '/../../db/news/*.json');// devuelve array con los nombres de las noticias
    $filenames_array                = array_map($get_file_name, $news_path_array);//obtener los nombres limpios de los archivos json
    
    
    foreach ($filenames_array as $filename ) {
        $json_news                  = read_json(__DIR__ . "/../../db/news/". $filename);//lee json y devuelve array asociativo
        array_push($news_array, $json_news);
    }

    sort($news_array);// sort an array in descending   
    return $news_array;
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
function read_table(string $csv_filename): Table {

    $data = Table::readCSV($csv_filename);
    return $data;
}
