<?php
declare(strict_types=1);
namespace Router;

require_once(__DIR__ .'/controller/controller.php');
use Controller;



function get_request_path(): string {

    $url_path           = $_SERVER['REQUEST_URI'];
    $sanitized_url_path = filter_var($url_path, FILTER_SANITIZE_URL);//*Check if is a correct url path
    $trimmed_url_path   = rtrim($sanitized_url_path, '/');//*Delete '/' from the right Example: body/
   
    return $trimmed_url_path;
}

function make_response(string $request_path): string {

    $response = match($request_path) {

        '/index', ''    =>  Controller\index(),
        '/blog'         =>  Controller\blog(),
        '/gallery'      =>  Controller\gallery(),
        //'/data'         =>  Controller\data(),
        
         default        =>  Controller\error_404($request_path),
    };

    return $response;
}

// ----------------------------------------------------------------------------
function main(): void {

    // 1. Get URL path
    $request_path = get_request_path();

    // 2. Match URL path against registered functions
    $response = make_response($request_path);

    // 3. Send response to client
    echo $response;
}


// ----------------------------------------------------------------------------
main();
// ----------------------------------------------------------------------------


