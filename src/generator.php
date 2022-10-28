<?php

declare(strict_types = 1);
require_once(__DIR__ . '/lib/utils.php');
require(__DIR__.'/templates/blog.item.template.php');//

//Functions here
/**
 * Function to generate an index.html
 * @param{$index_template_filename} path of the index template 
 * @param{$news array} array of news 
 */
function make_index(string $index_template_filename, array $news_array):void{
    $index_filename          = "../public/blog.html";
    $template_vars           = ['news_array' => $news_array];
    $make_index_html         = render_template($index_template_filename, $template_vars);
    file_put_contents($index_filename, $make_index_html);
}

/**
 * Function that compare dates
 * @return 0 if first date is lower than second date
 * @return -1 if second date is higher than first date
 * Me hace falta entender mas esta funcion
 */
function compareByTimeStamp($time1, $time2)
{
	if (strtotime($time1) < strtotime($time2)){return 0;}
	else if (strtotime($time1) > strtotime($time2)){return -1;}
	else{return 1;}
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
        $collapse     = ($id !== "One") ? "collapsed" : "";
        $expanded     = ($id !== "One") ? "false" : "true";
        $expanded_div = ($id !== "One") ? "" : "show";
        
        $news_content = getBlogItem($id,$collapse,$expanded,$date,$title,$expanded_div,$content);
        array_push($news_array, $news_content);
    }   



    usort($news_array,'compareByTimeStamp');// sort an array in descending   
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
    make_index($index_filename_template,$news_array);

    //shell_exec("rm -r -f public/*"); borra el dir public/

    //create_dir('public'); crea el dir public

    shell_exec("cp -r resources/ /public/"); //copia el dir resources a public
}
//------------------------------------------------------------------------------------------
main();
