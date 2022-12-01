<?php
declare(strict_types=1);
namespace Controller;

require_once(realpath(__DIR__ . '/../view/viewlib.php'));
use function Model\get_csv_path;

use function Model\read_table;
use function View\getTemplatePath;

require_once(realpath(__DIR__ . '/../../lib/utils/utils.php'));
use function Utils\render_template;

require_once(realpath(__DIR__ . '/../model/model.php'));
use function Model\get_news_array;
use function Model\get_region_name;
use function Model\get_regions_api;
use function Model\get_pokemons;

use function Model\get_pokemon_name;

function index():string {
    $index_body_template = render_template(getTemplatePath('/body/index'),
                                            ['contributors' => ['Alvin Garcia', 'Raul Montoro', 'Eloy Gonzalez', 'Mario Barroso']]);
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

function regions(): string {

    $regions_name = get_region_name();
    $game_version = get_regions_api($regions_name);
     
    $regions_body_template = render_template(getTemplatePath('/body/region'),['game_version' => $game_version]);
    $regions_view          = render_template(getTemplatePath('/skeleton/skeleton'), ['body' => $regions_body_template]);

    return $regions_view;
}

function pokemons():string {
    $regions_name    = get_region_name();
    $pokemons_images = get_pokemons($regions_name);

    $pokemons_body_template = render_template(getTemplatePath('/body/pokemons'),['pokemons_images' => $pokemons_images]);
    $pokemons_view          = render_template(getTemplatePath('/skeleton/skeleton'), ['body' => $pokemons_body_template]);

    return $pokemons_view;
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