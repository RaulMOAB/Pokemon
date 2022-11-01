<?php

declare(strict_types = 1);
require_once(__DIR__ . '/lib/utils.php');


//Functions here
/**
 * Function to generate an index.html
 * @param{$index_template_filename} path of the index template 
 * @param{$news array} array of news 
 */
function make_index(
                    string $html_template_filename,
                    string $html_filename,
                    array $template_vars):void{

    $make_index_html         = render_template($html_template_filename, $template_vars);
    
    shell_exec("rm -r -f ../public/");
    create_dir('../public'); 
    shell_exec("cp -r ../resources/* ../public/"); 
    file_put_contents($html_filename, $make_index_html);
}

function make_html( string $html_template_filename,
                    string $html_filename,
                    array $template_vars):void{

    $html_ready         = render_template($html_template_filename, $template_vars);
    file_put_contents($html_filename, $html_ready);
}



/**
 * Function that gets data from json and sort the array 
 * @return {$news_array} An array of news formated    
 */
function get_news_array():array{

    $news_array                     = [];//array final a devolver despues del glob() y el basename()
    $news_path_array                = glob("../db_json/*.json");// devuelve array con los nombres de las noticias
    $filenames_array                = array_map('get_file_name', $news_path_array);//obtener los nombres limpios de los archivos json
    
    
    foreach ($filenames_array as $filename ) {
        $json_news                  = read_json("../db_json/". $filename);//lee json y devuelve array asociativo
        extract($json_news);//extrae las keys del json a variables php con su value
        array_push($news_array, $json_news);
    }   
    sort($news_array);// sort an array in descending   
    return $news_array;
}

/**
 * Function to get ann array of image with paths
 * @return ann array of images
 */
function get_img_array():array{

    $regions_array = ["kanto", "johto"];
    $img_array = [];
    $img_paths_array        = glob("../public/img/kanto/*.png");
    $filenames_array        = array_map('get_file_name', $img_paths_array);
    

    foreach ($filenames_array as $filename ) {
        array_push($img_array, "/img/kanto/".$filename);
    } 

    return $img_array;
}

/**
 * Function to get data from a csv file and convert it to an associative array
 * @return array of data
 */
function get_data_array():array{
    $csv_rows  = array_map('str_getcsv', file('../pokemon.csv'));
    $csv_array = [];
    foreach ($csv_rows as $row) {
        array_push($csv_array, $row);
    }
    return $csv_array;
}
/**
 * Calleable function that returns the file name without the path
 */
function get_file_name(string $path):string{
    return basename($path);
}

//$get_file_name = fn($path) => basename($path);

//--------------------------------MAIN FUNCTION--------------------------------------------- 
function main(): void
{
    //TEMPLATES HTML
    $index_filename_template        = "templates/index.template.php";
    $blog_filename_template         = "templates/blog.template.php"; 
    $images_filename_template       = "templates/images.template.php";
    $data_filename_template         = "templates/data.template.php";
    
    

    //HTML FILENAME
    $index_filename_html            = "../public/index.html";
    $blog_filename_html             = "../public/blog.html";
    $images_filename_html           = "../public/images.html";
    $data_filename_html             = "../public/data.html";

    //TEMPLATE VARS
    //Index
    $contributors                   = ["Alvin Miller Garcia Garcia", "Raul Montoro", "Eloy Gonzalez"];
    $index_template_vars            = ['contributors'=>$contributors];

    //Blog
    $news_array                     = get_news_array();
    $news_template_vars             = ['news_array'=>$news_array];

    //Images
    $images_array                   = get_img_array();
    $images_template_vars           = ['images'=>$images_array];

    //Data
    $data_array = get_data_array();
    $data_template_vars =['csv_array' => $data_array];



    make_index($index_filename_template, $index_filename_html, $index_template_vars);    //Generate index.html
    make_html($blog_filename_template, $blog_filename_html, $news_template_vars);         //Generate blog.html
    make_html($images_filename_template, $images_filename_html, $images_template_vars);   //Generate image.html
    make_html($data_filename_template, $data_filename_html, $data_template_vars);


    
}
//------------------------------------------------------------------------------------------
main();
