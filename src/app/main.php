<?php
declare(strict_types=1);
namespace Main;

require_once(__DIR__ . '/config.php');
use function Config\get_lib_dir;

require_once(get_lib_dir() . '/request/request.php');
use Request\Request;

require_once(get_lib_dir() . '/router/router.php');
use function Router\process_request;

require_once(get_lib_dir() . '/table/Table.php');
use Table\Table;

function main(): void{

    //*Get the request and read csv routes
    $request   = Request::getFromWebServer();
    $route_csv = Table::readCSV(__DIR__ . '/routes.csv');

    //*Process request
    $response = process_request($request, $route_csv) ;

    //*Send response
    $response->send();
}

main();