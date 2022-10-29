<?php

declare(strict_types = 1);
require_once(__DIR__ . '/lib/utils.php');


//Functions here
/**
 * Function to generate an index.html
 * @param{$index_template_filename} path of the index template 
 * @param{$news array} array of news 
 */
function make_index(string $index_template_filename, array $news_array):void{
    $index_filename          = "../public/index.html";
    $blog_filename           = "../public/blog.html";
    $template_vars           = ['news_array' => $news_array,];
    $make_index_html         = render_template($index_template_filename, $template_vars);
    
    //shell_exec("rm -r -f ../public/*");

    //create_dir('../public'); 

    
    //shell_exec("cp -r ../resources/ ../public/"); 
    file_put_contents($blog_filename, $make_index_html);
    file_put_contents($index_filename, $make_index_html);// geenra el index con noticias
}



/**
 * Function that gets data from json and add data to a heredoc 
 * @return {$news_array} An array of news formated    
 */
function get_news_array():array{

    $news_array      = [];//array final a devolver despues del glob() y el basename()
    $news_path_array = glob("../db_json/*.json");// devuelve array con los nombres de las noticias
    $filenames_array = array_map('get_file_name', $news_path_array);//obtener los nombres limpios de los archivos json
    
    
    foreach ($filenames_array as $filename ) {
        $json_news = read_json("../db_json/". $filename);//lee json y devuelve array asociativo
        extract($json_news);//extrae las keys del json a variables php con su value
        $split_array = substr($filename, 0, -5);
        $filename_string_to_date = strtotime($split_array);// json filenames to string to date to sort them
      
 
        array_push($news_array, $json_news);
    }   



    rsort($news_array);// sort an array in descending   
    return $news_array;
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
   
    
    $index_filename_template = "templates/blog.template.php";
    $news_array = get_news_array();
    make_index($index_filename_template, $news_array);

    //shell_exec("rm -r -f ../public/*");

    //create_dir('../public'); 

    //shell_exec("cp -r ../resources/ ../public/"); //copia el dir resources a public

    
}
//------------------------------------------------------------------------------------------
main();
