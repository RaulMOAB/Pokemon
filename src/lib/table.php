<?php

declare(strict_types=1);

namespace Lib;




class Table
{
    public array $header;
    public array $body;

    public function __construct(array $header, array $body)
    {
        $this->header = $header;
        $this->body   = $body;
    }

    public function __toString(): string
    {
        $body_string   = '';
        $string_table  = '';
        $string_header = implode("|", $this->header) . PHP_EOL; //* cabezera titulo y volumenes
        $string_table  = $string_header;

      

        foreach ($this->body as $row => $content) {
            $string_content = implode("|", $content) . PHP_EOL;
            $body_string    = $body_string . $string_content; //* contenido de titulo y capitulos
        }


        $string_table = $string_table . $body_string;

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

    public function get_max_length():int{
    // $arr = array_filter($numbers, fn($n) => $n > 10);
        foreach ($this->body as $index => $row) {
            $arr = array_values($row);
            print_r($arr);
        }

        return 0;
    }
}

//!test
function main(): void
{
    //$empty_table = new Table();

    $header = ['Title', 'Volumes'];
    $body = [
        ['Chainsaw Man',    13],
        ['Attack on Titan', 27],
        ['Dragon Ball Z',   10],
        ['One Piece',       70]
    ];
    //

   /*  $pad = str_pad($body[0][0],15) . " |";
    echo $pad; 
    $len = strlen($body[1][0]);
    echo $len;  */

    $manga_table = new Table($header, $body);
    echo $manga_table;

    //?Test csv static functions
   /*  $new_row[] = ['23123123'];
    Table::writeCsv('../../pokemon.csv', $new_row);
    Table::readCsv('../../pokemon.csv'); */
     
    
 
}
//----------------------------------------------------------------------------------
main();


//TODO 1. __toString falta encontrar el max length
//!2. metodo leer csv static REPASAR
//!3. metodo escribir csv static REPASAR
//*4. Filtrar filas
//*5. Obtener columna