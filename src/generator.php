<?php

declare(strict_types = 1);
require_once(__DIR__ . '/lib/utils.php');


/*______________________________________________Functions here____________________________________________*/

/**
 * Function to generate index.html
 * @param $html_template_filename the filename of the template that we use for it
 * @param $html_filename the name that we like to put to the html
 * @param $template_vars an array that we use to fill the template vars 
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


/**
 * Function to make the generics htmls
 * @param $html_template_filename the filename of the template that we use for it
 * @param $html_filename the name that we like to put to the html
 * @param $template_vars an array that we use to fill the template vars
 */
function make_html( string $html_template_filename,
                    string $html_filename,
                    array $template_vars):void{

    $html_ready         = render_template($html_template_filename, $template_vars);
    file_put_contents($html_filename, $html_ready);
}


/**
 * Function to generate regions html with his initials pokemons
 * @param $region_info information about  regions, we take it for the name of the regions
 */
function make_regions_html(array $region_info):void{
    $info_template = [];
    foreach ($region_info as $region => $value) {
        //FILENAME TEMPLATE PHP
        $filename_template                              = "templates/regions_pokemons.template.php";
        //FILENAME OF THE HTML
        $filename_html                                  = "../public/$region.html";

        $region_pokemons                                = glob("../public/img/regions/$region/*.webp");
        $pokemon_images_paths                           = array_map('get_pokemon_paths',$region_pokemons);
        $pokemons_filenames                             = array_map('get_file_name',$region_pokemons);

        $pokemons_name                                  = array_map('get_pokemon_name',$pokemons_filenames);

        $region_name                                    = ucfirst($region);//This function make first char to uppercase

        $info_template ["region_name"]                  = $region_name;//Assign value of the region

        for ($i=0; $i < count($pokemons_name); $i++) { 
            $num_i = $i+1;
            $info_template["pokemon_inicial_$num_i"]    = $pokemons_name[$i]; //Adding pokemons name
        }

        $info_template["images"]                        = $pokemon_images_paths; //Adding path images array

        $template_vars                                  = ['info_region'=>$info_template]; //Making template vars

        make_html($filename_template,$filename_html,$template_vars);
    }

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
        array_push($news_array, $json_news);
    }

    sort($news_array);// sort an array in descending   
    return $news_array;
}

/**
 * Function to get data from a csv file and convert it to an associative array
 * @return array of data
 */
function get_data_array():array{
    $csv_rows       = array_map('str_getcsv', file('../pokemon.csv'));
    $csv_array      = [];
    foreach ($csv_rows as $row) {
        array_push($csv_array, $row);
    }
    return $csv_array;
}

/**
 * Function that compile all information about regions calling pokeapi API
 * @return array with info about the regions
 */
function get_regions_array():array{
    $regions = [];
    $regions_img_array          = glob("../public/img/regions_map/*.webp");
    $filenames_array            = array_map('get_file_name',$regions_img_array);

    foreach ($filenames_array as $filename) {
        
        $region_name                = substr($filename,0,-5);
        $url                        = "https://pokeapi.co/api/v2/region/$region_name";
        $json_string                = shell_exec("curl $url");
        $api_response               = json_decode($json_string,true);
        $version_group              = $api_response["version_groups"];

        $region                     = [];
        $region["region_name"]      = $filename;
        $region["game_versions"]    = $version_group;

        $regions[$region_name]=$region;
    }
    
    return $regions;

}

/*_______________________________________Calleable functions_______________________________________*/

/**
 * Function that return the base name of the file path
 * @return string basename of the path
 */
function get_file_name(string $path):string{
    return basename($path);
}

/**
 * Function that cut the extension file of .webp
 * @return string filename without extension .webp
 */
function get_pokemon_name(string $pokemon_filename):string{
    $poke_name      = substr($pokemon_filename,0,-5);
    return ucfirst($poke_name);
}

/**
 * Function that remove ../public from the path to get the correct path from the server
 * @return string correct path from the server public
 */
function get_pokemon_paths(string $path):string{
    return substr($path,9);
}

/*____________________________________________MAIN FUNCTION________________________________________________*/
function main(): void
{
    //TEMPLATES HTML
    $index_filename_template        = "templates/index.template.php";
    $blog_filename_template         = "templates/blog.template.php"; 
    $data_filename_template         = "templates/data.template.php";
    $region_filename_template       = "templates/region.template.php";
    
    

    //HTML FILENAME
    $index_filename_html            = "../public/index.html";
    $blog_filename_html             = "../public/blog.html";
    $data_filename_html             = "../public/data.html";
    $regions_filename_html          = "../public/regions.html";



    //TEMPLATE VARS

    //For Index
    $contributors                   = ["Alvin Miller Garcia Garcia", "Raul Montoro", "Eloy Gonzalez"];
    $index_template_vars            = ['contributors'=>$contributors];

    //For Blog
    $news_array                     = get_news_array();
    $news_template_vars             = ['news_array'=>$news_array];

    //For Regions
    $regions_array                  = get_regions_array();
    $regions_template_vars          = ['regions'=>$regions_array];

    //For Data
    $data_array                     = get_data_array();
    $data_template_vars             = ['csv_array' => $data_array];

    //Calling functions
    make_index($index_filename_template, $index_filename_html, $index_template_vars);       //Generate index.html
    make_html($blog_filename_template, $blog_filename_html, $news_template_vars);           //Generate blog.html
    make_html($data_filename_template, $data_filename_html, $data_template_vars);           //Generate data.html
    make_html($region_filename_template, $regions_filename_html, $regions_template_vars);   //Generate region.html
    make_regions_html($regions_array);                                                      //Generate region_name.html
}
/*_________________________________________________________________________________________________________________________________________*/

main();//Calling main() function
