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
        $this->body = $body;
    }

    /**
     * Function to get the max length of body
     * @return int $max_length  
     */
    private function get_max_lengths(): array
    {
        $max_lengths = array_map('strlen', $this->header);

        foreach ($this->body as $index) {
            $actual_values = array_map('strlen', $index);
            for ($i = 0; $i < max(sizeof($max_lengths), sizeof($actual_values)); $i++) {
                if ($max_lengths[$i] < $actual_values[$i]) $max_lengths[$i] = $actual_values[$i];
            }
        }

        return $max_lengths;
    }

    /**
     * Function that return the table in a pretty format
     * @return string $string_table header and body table formatted into a string
     */
    public function __toString(): string
    {
        //________________________VARIABLES_AND_GENERAL_THINGS_SET_UP____________________________
        $max_lengths = (array)$this->get_max_lengths(); //Getting max lengths of the contents columns

        $header = $this->header; //Put header into new variable to not modify the original one
        $body = $this->body; //Create body array for not modify the original

        //Horizontal line to get more prettier, in this case all $max_lengths +  number of columns +2 (first and last "|")
        $line = str_repeat("═", array_sum($max_lengths) + sizeof($max_lengths) + 2) . PHP_EOL;

        //the string table, head and body inits as a void string.
        $string_table = '';
        $string_header = '';
        $string_body = '';
        
        //_________________________HEADER_SET_UP__________________________________
        for ($i = 0; $i < max(sizeof($max_lengths), sizeof($header)); $i++) {
            $header[$i] = str_pad((string) $header[$i], $max_lengths[$i]); //Adding to not orinal header the value of original header but spaced up to the max_length
        }

        
        //Header fields separated by an "║ " with implode function
        $string_header = implode(" ║ ", $header) . PHP_EOL; 


        //__________________________BODY_SET_UP____________________________________
        foreach ($body as $contents) {
            for ($i = 0; $i < max(sizeof($max_lengths), sizeof($contents)); $i++) {
                //Adding to not original body the value of original body but spaced up to the max_length
                $contents[$i] = str_pad((string) $contents[$i], $max_lengths[$i]);
            }

            $string_content = implode(" ║ ", $contents) . PHP_EOL; //Row fields separated by an "║ " with implode function 
            $string_body .= $string_content;
        }


        //_________________________BUILD_AND_RETURN_THE_TABLE________________________________
        $string_table .= $line; //Horizontal line

        $string_table .= $string_header;  //Concat header fields already formatted in final string

        $string_table .= $line; //Horizontal line

        $string_table .= $string_body;    //Concat body fields already formatted in final string

        $string_table .= $line; //Horizontal line

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

        $header = array_shift($csv_array);
        $body = $csv_array;


        return [$header, $body];
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

    //Filtrae filas YA VERAS QUE GUAPO NANOOO
    public function filterRows(int $column, int|string $filter1, int $filter2 = null)
    {
        if (gettype($column) == "integer") {
            if (gettype($filter1) == "string") {
                return $this->_filterStringRows($column, $filter1);
            }

            $filter1 = (int)$filter1;

            if (gettype($filter2) == "integer") {
                return $this->_filterIntRangeRows($column, $filter1, $filter2);
            }

            return $this->_filterIntRows($column, $filter1);
        }

        return $this->body;
    }

    //Filtrar filas valor unico STRING
    private function _filterStringRows(int $col, string $filter_string)
    {

        $aray_filtered = array_filter($this->body, function ($body) use ($filter_string, $col) {

            return str_contains($body[$col], $filter_string);
            //return $body[1] == $filter;
        }, ARRAY_FILTER_USE_BOTH);


        return $aray_filtered;
    }
    //Filtrar filas valor unico NUMERICO
    private function _filterIntRows(int $col, int $filter_int)
    {

        $aray_filtered = array_filter($this->body, function ($body) use ($filter_int, $col) {

            return $body[$col] == $filter_int;
        }, ARRAY_FILTER_USE_BOTH);


        return $aray_filtered;
    }
    //Filtrar filas valor RANGO DE NUMEROS
    private function _filterIntRangeRows(int $col, int $filter_min_int, int $filter_max_int)
    {

        if ($filter_max_int < $filter_min_int) {
            $aux = $filter_max_int;
            $filter_max_int = $filter_min_int;
            $filter_min_int = $aux;
        }
        $aray_filtered = array_filter($this->body, function ($body) use ($filter_min_int, $filter_max_int, $col) {

            return $body[$col] >= $filter_min_int && $body[$col] <= $filter_max_int;
        }, ARRAY_FILTER_USE_BOTH);


        return $aray_filtered;
    }

    //Obtener columna
    public function getRow(int $row): array
    {
        return $this->body[$row];
    }

    public function getColumn(int $col): array
    {
        return array_column($this->body, $col);
    }
}

function main()
{
    $manga = new Table(
        ['Titulo', 'Tomos', 'Autor'],
        [
            ['Chainsaw Man',    13, 'Ibañez'],
            ['Attack on Titan', 27, 'Francisco'],
            ['Titan Paco',      31, 'Pepe Botella'],
            ['Dragon Ball Z',   10, 'Goku Gómez González'],
            ['One Piece',       70, 'Hatsune Miku']
        ]
    );
    echo $manga->__toString();

    
    $filtered_str = new Table(
        ['Titulo Titan', 'Tomos', 'Autor'],
        $manga->filterRows(0, 'Titan')
    );
    $filtered_int = new Table(
        ['Titulo Titan', 'Tomos ¡27!', 'Autor'],
        $manga->filterRows(1, 27)
    );
    $filtered_rng = new Table(
        ['Titulo', 'Tomos 10 a 30', 'Autor'],
        $manga->filterRows(1, 10, 30)
    );
    
    echo $filtered_str->__toString();
    echo $filtered_int->__toString();
    echo $filtered_rng->__toString();
}

main();
