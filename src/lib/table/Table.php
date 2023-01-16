<?php
declare(strict_types=1);
namespace Table;

require_once(__DIR__ . '/../../app/config.php');
use function Config\get_lib_dir;

require_once(get_lib_dir() . '/utils/utils.php');
use function Utils\array_prepend;
use function Utils\is_empty_str;


// ############################################################################
// Table __toString() helper functions
// ############################################################################

function transpose(array $matrix): array {

    $result = array_map(null, ...$matrix);
    return $result;
}

// Helper function: Get max length of all columns
// ----------------------------------------------------------------------------
function get_column_widths(array $header, array $body): array {

    // Combine header and body
    $header_and_body = array_prepend($header, $body);

    // Arrange data by columns, including column names
    $columns       = transpose($header_and_body);
    $named_columns = array_combine($header, $columns);

    // Functions to calculate column widths
    $get_width        = fn ($field)  => strlen( (string) $field);
    $get_column_width = fn ($column) => max(array_map($get_width, $column));

    // Calculate widths
    $column_widths = array_map($get_column_width, $named_columns);

    return $column_widths;
}

// String conversion
// ----------------------------------------------------------------------------
function convert_table_to_string(array $header, array $body, string $separator = ' | '): string {

    // Get all column widths
    $column_widths = get_column_widths($header, $body);

    // Functions to convert rows to string lines
    $convert_field_to_string = fn ($field, $width) => str_pad( (string) $field, $width, ' ', STR_PAD_RIGHT);
    $convert_row_to_line     = fn ($row)           => implode( $separator, array_map($convert_field_to_string, $row, $column_widths) );

    // Convert header and body to string
    $header_and_body = array_prepend($header, $body);
    $result = implode( PHP_EOL, array_map($convert_row_to_line, $header_and_body) );

    return $result;
}


// ############################################################################
// Table CSV helper functions
// ############################################################################

function write_csv(Table $table, string $csv_filename, string $separator = ' | '): void {

    // 1. Check if table contains the separator string
    $contents_str  = convert_table_to_string($table->header, $table->body, '');
    $has_separator = str_contains($contents_str, $separator);

    // 2. If separator found: Abort
    $error_msg = "Write error: Table contains '$separator' already. Cannot use it as a separator in CSV file.";
    if ($has_separator) { throw new \Exception($error_msg); }

    // 3. Else: Return string using separator
    $table_str = convert_table_to_string($table->header, $table->body, $separator);
    file_put_contents($csv_filename, $table_str);
}
// ----------------------------------------------------------------------------
function read_csv(string $csv_filename, string $separator): Table
{

    $csv_str         = file_get_contents($csv_filename);
    $trimmed_csv_str = trim($csv_str);
    $data_matrix     = split_csv_str($trimmed_csv_str, $separator);

    $header = get_header($data_matrix);
    $body   = get_body($data_matrix);
    $result = new Table($header, $body);

    return $result;
}
// ----------------------------------------------------------------------------
function split_csv_str(string $csv_str, string $separator): array
{

    // 1. Split into lines
    $line_array = explode(PHP_EOL, $csv_str);

    // 2. Remove empty lines anywhere
    $has_data        = fn ($line) => !is_empty_str($line);
    $data_line_array = array_filter($line_array, $has_data);

    // 3. Explode each line + trim each field
    $split_line  = fn ($line) => array_map('trim', explode($separator, $line));
    $data_matrix = array_map($split_line, $data_line_array);

    return $data_matrix;
}

function get_header(array $data_matrix): array
{

    $empty = !count($data_matrix);

    if ($empty) {
        throw new \Exception('Error: No header!');
    } else {
        $header = $data_matrix[0];
    }

    return $header;
}

// Important: Rows are associative arrays. Keys are the column names.
// ----------------------------------------------------------------------------
function get_body(array $data_matrix): array
{

    $header = get_header($data_matrix);
    $body   = $data_matrix;
    array_shift($body);

    // $decorate_row   = fn ($row) => array_combine($header, $row);
    // $decorated_body = array_map($decorate_row, $body);

    return $body;
}

function decorate_body(array $header, array $body): array {

    $decorate_row   = fn ($row) => array_combine($header, $row);
    $decorated_body = array_map($decorate_row, $body);

    return $decorated_body;
}

// ############################################################################
// Rows and Columns helper functions
// ############################################################################

// When using indexed arrays, remember to call array_values() after array_filter().
// https://stackoverflow.com/questions/3401850/after-array-filter-how-can-i-reset-the-keys-to-go-in-numerical-order-starting
// ----------------------------------------------------------------------------
function filter_rows(Table $table, callable $filter): Table {

    $header         = $table->header;
    $filtered_body  = array_values(array_filter($table->body, $filter));

    $filtered_table = new Table($header, $filtered_body);

    return $filtered_table;
}


// ############################################################################
// Table Object
// ############################################################################

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
        $this->body = decorate_body($header, $body);
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

        $string_table .= $string_header;  //Concat header fields already formatted in final string

        $string_table .= $string_body;    //Concat body fields already formatted in final string

        return $string_table;
    }



    //*Read a csv file
 // ----------------------------------------------------------------
    public static function readCSV(
        string $csv_filename,
        string $separator = '|'
    ): self {

        $table = read_csv($csv_filename, $separator);
        return $table;
    }



    public function writeCsv(string $csv_filename, string $separator = '|'): void
    {
        write_csv($this, $csv_filename, $separator);
    }

    // ------------------------------------------------------------------------
    public function appendRow(array $row): void
    {

        $decorated_row = array_combine($this->header, $row);
        array_push($this->body, $decorated_row);
    }

    // ------------------------------------------------------------------------
    public function prependRow(array $row): void
    {

        $decorated_row = array_combine($this->header, $row);
        array_unshift($this->body, $decorated_row);
    }

    public function deleteRow(int $row_index): void{
        unset($this->body[$row_index - 1]);
        array_values($this->body);
    }


    // $filter function recieves a single parameter: a table row
    // Returns a new Table object. Does not modify the original table.
    // ------------------------------------------------------------------------
    public function filterRows(callable $filter): self {

        $result = filter_rows($this, $filter);
        return $result;
    }

    //Obtener fila
    public function getRow(int $row): array
    {
        return $this->body[$row];
    }
    
    //Obtener columna
    public function getColumn(int $col): array
    {
        return array_column($this->body, $col);
    }
}


