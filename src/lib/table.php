<?php

declare(strict_types=1);
namespace Lib;

class Table
{
    public array $header;
    public array $body;

    /**
     * Table's constructor
     * @param array $header indexed array with the name of each field of the table
     * @param array $body multidimensional array that contains an array of each row
     */
    public function __construct(array $header, array $body)
    {
        $this->header = $header;
        $this->body   = $body;
    }

    /**
     * Function to get the max length of body
     * @return int $max_length  
     */
    private function get_max_length():int{
        $arr = [];
        foreach ($this->body as $index => $value) {   
         $arr [] = max(array_map('strlen',$value));  
        }
        $max_length = max($arr);
        return $max_length;
    }

    /**
     * Function that return the table in a pretty format
     * @return string $string_table header and body table formatted into a string
     */
    public function __toString():string{

        $max_length = Table::get_max_length();                  //Getting max length of the content
        $string_table  = '';                                   

        //_________________________HEADER_SET_UP__________________________________

        $header = $this->header;                             //Put header into new variable to not modify the original one
        foreach ($header as $index => $title) {              // modify index from an indexed array   
            $header[$index] = str_pad($title,$max_length);   //?Adding to header the value of original header but spaced up to $max_length
        }

        $line = str_repeat("═",($max_length*count($header)));//Horizontal line to get more prettier usint str_repeat that repeat a character a number of times, in this case $max_length *  number of columns of the table


        $string_table = $string_table.$line.PHP_EOL;         //Horizontal line

        $string_header = implode("║ ",$header) . PHP_EOL;     //Header fields separated by an "║" with implode function
        $string_table  =$string_table . $string_header;      //Concat header fields already formatted in final string

        $string_table = $string_table.$line.PHP_EOL;         //Horizontal line

        //__________________________BODY_SET_UP____________________________________

        $body_string   = '';                                  
        $body   = $this->body;                                  //Create body array for not modify the original                         
        foreach ($body as $content) {
            foreach ($content as $index => $comic_info) {
                $content[$index] = str_pad((string)$comic_info,$max_length); //Adding to not original body the value of original body but spaced up to $max_length
            }
            $string_content = implode("║ ", $content) . PHP_EOL;              //Row fields separated by an "║" with implode function 
            $body_string    = $body_string . $string_content;               
        }

        $string_table = $string_table . $body_string;
        $string_table = $string_table.$line.PHP_EOL;
        return $string_table;
    }

    //*Read a csv file
    public static function readCsv(string $csv_file): array
    {

        $file = file($csv_file);
        $csv_array = [];
        foreach ($file as $row) {
            $csv_array[] = str_getcsv($row);
        }
        //print_r($csv_array);
        return $csv_array;
    }

    //*Append a new row into csv array
    public static function writeCsv(string $csv_file, array $fields): void
    {
        $file = fopen($csv_file, "a"); //*append
        foreach ($fields as $values) {
            fputcsv($file, $values);
        }
        fclose($file);
    }

    //TODO-->

    //Filtrar filas
    public function filterRows(int $num_volums){
        
        $aray_filtered = array_filter($this->body, function ($volums){
           return $volums[1] == 27;
        });    
        return $aray_filtered;
    }

    //Obtener columna
    
}

//!test
function main(): void
{
    //$empty_table = new Table();

    $header = ['Title', 'Volumes', 'id'];
    $body = [
        ['Chainsaw Man',    13, "QP9"],
        ['Attack on Titan', 27, "QV2"],
        ['Dragon Ball Z',   10, "Q92"],
        ['One Piece',       70, "Q1Z"]
    ];
    //


    $manga_table = new Table($header, $body);
    //echo $manga_table;

    //?Test csv static functions
   /*  $new_row[] = ['23123123'];
    Table::writeCsv('../../pokemon.csv', $new_row);
    Table::readCsv('../../pokemon.csv'); */
     
    $num_volums = 30;
    print_r($manga_table->filterRows($num_volums));
    
 
}
//----------------------------------------------------------------------------------
main();


//TODO 1. __toString falta encontrar el max length
//!2. metodo leer csv static REPASAR
//!3. metodo escribir csv static REPASAR
//*4. Filtrar filas
//*5. Obtener columna