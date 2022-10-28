<?php
declare(strict_types=1);

// Utils
// -----

// ********************************************************************
// Boolean utils
// ********************************************************************

// --------------------------------------------------------------------
function all_true(array $bool_array): bool {

    $all_count  = count($bool_array);
    $true_count = count(array_filter($bool_array));

    $all_are_true = ($all_count == $true_count);

    return $all_are_true;
}

// --------------------------------------------------------------------
function any_true(array $bool_array): bool {

    $true_count        = count(array_filter($bool_array));
    $at_least_one_true = ($true_count >= 1);

    return $at_least_one_true;
}


// ********************************************************************
// String utils
// ********************************************************************


// - Problem:
//   - PHP's empty() is a keyword, not a function.
//   - Because of that, we cannot pass it as a parameter to array_map(), array_filter(), etc.
// - Solution: Make our own 'is_empty_str()' function.
//   - Caveat: Do not use empty(). It returns true for strings starting with a zero!
//   - Use a type-strict comparison with === ''.
// - URLs
//   - https://stackoverflow.com/questions/732979/php-whats-an-alternative-to-empty-where-string-0-is-not-treated-as-empty
//   - https://stackoverflow.com/questions/718986/why-a-function-checking-if-a-string-is-empty-always-returns-true
//   - https://www.php.net/manual/en/types.comparisons.php
// --------------------------------------------------------------------
function is_empty_str(string $text): bool {
    $result = ($text === '');
    return $result;
}



// ********************************************************************
// Print utils
// ********************************************************************


// Print Line. Appends an EOL at the end
// --------------------------------------------------------------------
function println(mixed $something=''): void {
	echo $something;
    echo PHP_EOL;
}

// Print array values in a single line. Appends an EOL at the end
// --------------------------------------------------------------------
function print_values($arr): void {
    foreach($arr as $elem) { 
        echo "$elem ";
    }
    echo PHP_EOL;
}


// ********************************************************************
// Template utils
// ********************************************************************


// Params start with an underscore and all caps to avoid collisions in $_TEMPLATE_VARS.
// --------------------------------------------------------------------
function render_template(string $_TEMPLATE_FILENAME, array $_TEMPLATE_VARS): string {

    extract($_TEMPLATE_VARS);

    ob_start();
    require($_TEMPLATE_FILENAME);
    $_RESULT = ob_get_contents();
    ob_end_clean();

    return $_RESULT;
}


// ********************************************************************
// Json utils
// ********************************************************************


// Returns an array with the contents of $json_filename
// --------------------------------------------------------------------
function read_json(string $json_filename): array {

    $json_str = file_get_contents($json_filename);
    $result   = json_decode($json_str, true);

    return $result;
}


// ********************************************************************
// File utils
// ********************************************************************


// - Files with empty names do not exist.
//   - https://unix.stackexchange.com/questions/83785/how-do-you-create-a-file-with-an-empty-name
// --------------------------------------------------------------------
function join_paths(string ...$path_array): string {

    // Check for empty strings
    $empty_path_found = any_true(array_map('is_empty_str', $path_array));
    if ($empty_path_found) { throw new Exception('Error: join_paths() on an empty path.'); }

    // Join paths
    $joint_path = join(DIRECTORY_SEPARATOR, $path_array);

    // Remove any repeated slashes
    $repeated_slash_regex = '~'.DIRECTORY_SEPARATOR.'{2,}'.'~';
    $single_slash_str = DIRECTORY_SEPARATOR;
    $clean_path = preg_replace( $repeated_slash_regex,
                                $single_slash_str,
                                $joint_path );

    return $clean_path;
}



// ********************************************************************
// Path utils
// ********************************************************************


// Checks for existence to avoid warnings
// --------------------------------------------------------------------
function create_dir(string $dir): void {

    if (!is_dir($dir)) { mkdir($dir, recursive: true); }
}

// --------------------------------------------------------------------
function copy_files(array $source_file_array, string $target_dir): void {

    foreach($source_file_array as $source_file) {

        $target_file = join_paths($target_dir, basename($source_file));

        copy($source_file, $target_file); 
    }
}

// --------------------------------------------------------------------
