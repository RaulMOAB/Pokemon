<?php
declare(strict_types=1);
namespace Controller;

require_once(realpath(__DIR__ . '/../view/viewlib.php'));
use function Model\get_csv_path;

use function Model\read_table;
use function View\getTemplatePath;

require_once(realpath(__DIR__ . '/../../vendor/utils/utils.php'));
use function Utils\render_template;

require_once(realpath(__DIR__ . '/../model/model.php'));
use function Model\get_news_array;
use function Model\get_region_name;

function index():string {
    $index_body_template = render_template(getTemplatePath('/body/index'),
                                            ['contributors' => ['Alvin Garcia', 'Raul Montoro', 'Eloy Gomez', 'Mario Barroso']]);
    $index_view          = render_template(getTemplatePath('/skeleton/skeleton'),['body' => $index_body_template]);

    return $index_view;
}

function blog(): string
{
    $get_news = get_news_array();

    $blog_body_template = render_template(getTemplatePath('/body/blog'), ['news' => $get_news]);
    $blog_view          = render_template(getTemplatePath('/skeleton/skeleton'), ['body' => $blog_body_template]);

    return $blog_view;
}

function gallery(): string {

    $regions = get_region_name();
    $gallery_body_template = render_template(getTemplatePath('/body/gallery'),[/*response de la api para las regiones */]);
    $gallery_view          = render_template(getTemplatePath('/skeleton/skeleton'), ['body' => $gallery_body_template]);

    return $gallery_view;
}

function data():string {
  $pokemon_table      = read_table(__DIR__ . '/../../db/pokemon.csv');

  $data_body_template = render_template(getTemplatePath('/body/data'),
                                        ['pokemon_table' => $pokemon_table]);
  $data_view          = render_template(getTemplatePath('/skeleton/skeleton'),
                                        ['body' => $data_body_template]);
  return $data_view;                                        
}

function error_404(string $request_path): string {

    http_response_code(404);

    $error404_body = render_template(getTemplatePath('/body/error404'),
                                     ['request_path' => $request_path]);

    $error404_view = render_template(getTemplatePath('/skeleton/skeleton'),
                                 ['title' => 'Not found',
                                  'body'  => $error404_body]);

    return $error404_view;
}