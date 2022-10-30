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
    
    //shell_exec("rm -r -f ../public/*");
    //create_dir('../public'); 
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
 * Function that gets data from json and add data to a heredoc 
 * @return {$news_array} An array of news formated    
 */
function get_news_array():array{

    $news_array                     = [];//array final a devolver despues del glob() y el basename()
    $news_path_array                = glob("../db_json/*.json");// devuelve array con los nombres de las noticias
    $filenames_array                = array_map('get_file_name', $news_path_array);//obtener los nombres limpios de los archivos json
    
    
    foreach ($filenames_array as $filename ) {
        $json_news                  = read_json("../db_json/". $filename);//lee json y devuelve array asociativo
        extract($json_news);//extrae las keys del json a variables php con su value
        $split_array                = substr($filename, 0, -5);
        $filename_string_to_date    = strtotime($split_array);// json filenames to string to date to sort them
      
 
        array_push($news_array, $json_news);
    }   



    rsort($news_array);// sort an array in descending   
    return $news_array;
}
function get_img_array():array{

    $img_array = [];
    $img_paths_array        = glob("../public/img/*.png");
    $filenames_array        = array_map('get_file_name', $img_paths_array);

    foreach ($filenames_array as $filename ) {
        array_push($img_array, "/img/".$filename);
    } 
    print_r($img_array);
    return $img_array;
}
/**
 * Calleable function that returns the file name without the path
 */
function get_file_name(string $path):string{
    return basename($path);
}

//$get_file_name = fn($path) => basename($path);

//__________________________________________________________________________________________
/**
 * Main function
 */
function main(): void
{
    //TEMPLATES HTML
    $index_filename_template        = "templates/index.template.php";
    $blog_filename_template         = "templates/blog.template.php";
    $images_filename_template       = "templates/images.template.php";

    //HTML FILENAME
    $index_filename_html            = "../public/index.html";
    $blog_filename_html             = "../public/blog.html";
    $images_filename_html           = "../public/images.html";

    //TEMPLATE VARS
    //Index
    $contributors                   = ["Alvin Miller Garcia Garcia", "Raul Montoro", "Eloy Gomez"];
    $index_template_vars            = ['contributors'=>$contributors];

    //Blog
    $news_array                     = get_news_array();
    $news_template_vars             = ['news_array'=>$news_array];

    //Images
    $images_array                   = get_img_array();
    $images_template_vars           = ['images'=>$images_array];


    make_index($index_filename_template,$index_filename_html ,$index_template_vars);    //Generate index.html
    make_html($blog_filename_template,$blog_filename_html,$news_template_vars);         //Generate blog.html
    make_html($images_filename_template,$images_filename_html,$images_template_vars);   //Generate image.html


    
}
//------------------------------------------------------------------------------------------
main();
