<?php
declare(strict_types=1);
namespace Controller;

require_once(__DIR__ . '/../config.php');

use function Config\get_app_dir;
use function Config\get_db_dir;
use function Config\get_lib_dir;
use function Config\get_model_dir;
use function Config\get_view_dir;

require_once(get_lib_dir() . '/request/request.php');
use Request\Request;

require_once(get_lib_dir() . '/response/Response.php');
use Response\Response;

require_once(get_lib_dir() . '/table/Table.php');
use Table\Table;

require_once(get_lib_dir() . '/context/context.php');
use Context\Context;

require_once(get_lib_dir() . '/user/user.php');
use User\User;

require_once(get_model_dir() . '/model.php');
use function Model\get_csv_path;
use function Model\read_table;
use function Model\get_announcements_array;
use function Model\get_region_name;
use function Model\get_regions_api;
use function Model\add_pokemon;

use function Model\get_pokemon_images;
use function Model\add_blog_announcement;
use function Model\get_pokemon_name;
use function Table\read_csv;
use function Model\find_user;

use const Model\CONTRIBUTORS;

require_once(get_view_dir() . '/view.php');
use function View\get_template_path;
use function View\render_template;






function index(Request $request, Context $context): array
{
    $index_body_template = render_template(
        get_template_path('/body/index'),
        ['contributors' => CONTRIBUTORS,
         'user'         => $context->name
        ]
    );
    $index_view          = render_template(
        get_template_path('/skeleton/skeleton'),
        [
            'title'  => 'PokéBlog',
            'body' => $index_body_template,
            'contributors' => CONTRIBUTORS,
            'user'         => $context->name
        ]
    );

    $response = new Response($index_view);
    return [$response, $context];
}

function login(Request $request, Context $context): array {


    if ($request->method == 'GET') {
        $login_body_template = render_template(get_template_path('/body/login'),['contributors' => CONTRIBUTORS]);
    
        $login_view = render_template(get_template_path('/skeleton/skeleton'),[
            'title'  => 'PokéBlog',
            'body' => $login_body_template,
            'contributors' => CONTRIBUTORS,
            'user'         => $context->name
        ]);
    
        $response = new Response($login_view);
    
        return [$response, $context];

    } elseif ($request->method == 'POST') {
        # hacer login
        $username = $request->parameters['username'];
        $password = $request->parameters['password'];

        $registered_user = find_user($username, $password);

        if (!empty($registered_user->username)) { // if user does not exist an empty object is returned
            $context  = new Context(true, $registered_user->username, $registered_user->role);
            $response = new Response(redirection_path:"/");

            return [$response, $context];

        } else {           
            $context  = new Context();
            $response = new Response(redirection_path:"/login");

            return [$response, $context];
        }

    }
}

function blog(Request $request, Context $context): array
{

    if (($context->role == "admin") && ($request->method == 'POST')) {
        #  add function to add news.
        add_blog_announcement($request->parameters);

        $response = new Response(redirection_path: '/blog');

        return [$response, $context];
    } elseif (($context->role == "admin") && ($request->method == 'GET')) {
        
        # add function to delete news
        $action = $request->parameters['action'] ?? 'list';
        if($action == 'delete') {}
        $get_announcements = get_announcements_array();

        $blog_body_template = render_template(
            get_template_path('/body/admin_view/blog'),
            [
                'announcements' => $get_announcements
            ]
        );
        $blog_view          = render_template(
            get_template_path('/skeleton/skeleton'),
            [
                'title' => 'Blog de noticias',
                'body' => $blog_body_template,
                'contributors' => CONTRIBUTORS,
                'user'         => $context->name
            ]
        );
    } else {
        $get_announcements = get_announcements_array();

        $blog_body_template = render_template(
            get_template_path('/body/blog'),
            [
                'announcements' => $get_announcements
            ]
        );
        $blog_view          = render_template(
            get_template_path('/skeleton/skeleton'),
            [
                'title' => 'Blog de noticias',
                'body' => $blog_body_template,
                'contributors' => CONTRIBUTORS,
                'user'         => $context->name
            ]
        );
    }



    $response = new Response($blog_view);
    return [$response, $context];
}

function regions(Request $request, Context $context): array
{

    $regions_name = get_region_name();
    $regions_info = get_regions_api($regions_name);

    $regions_body_template = render_template(
        get_template_path('/body/region'),
        [
            'regions_info' => $regions_info
        ]
    );
    $regions_view          = render_template(
        get_template_path('/skeleton/skeleton'),
        [
            'title'        => 'Regiones',
            'body'         => $regions_body_template,
            'contributors' => CONTRIBUTORS,
            'user'         => $context->name
        ]
    );

    $response = new Response($regions_view);
    return [$response, $context];
}

function pokemons(Request $request, Context $context): array
{
    $region_name     = substr($request->path,9);
    $pokemons_images = get_pokemon_images($region_name);

    $pokemons_body_template = render_template(
        get_template_path('/body/pokemons'),
        [
            'pokemons_images' => $pokemons_images
        ]
    );
    $pokemons_view = render_template(
        get_template_path('/skeleton/skeleton'),
        [
            'title'        => 'Pokémon',
            'body'         => $pokemons_body_template,
            'contributors' => CONTRIBUTORS,
            'user'         => $context->name
        ]
    );

    $response = new Response($pokemons_view);
    return [$response, $context];
}

function data(Request $request, Context $context): array
{

    if (($context->role == "admin") && ($request->method == "GET")) {
        
        $pokemon_table = read_table(get_csv_path('pokemon'));

        $data_body_template = render_template(
            get_template_path('/body/admin_view/data'),
            [
                'pokemon_table' => $pokemon_table
            ]
        );
        $data_view          = render_template(
            get_template_path('/skeleton/skeleton'),
            [
                'title'        => 'Datos',
                'body'         => $data_body_template,
                'contributors' => CONTRIBUTORS,
                'user'         => $context->name
            ]
        );
    } elseif (($context->role == "admin") && ($request->method == 'POST')) {
        # add pokemon
        $pokemon_data = $request->parameters;
        array_pop($pokemon_data);// pop brwoser_id
        add_pokemon(get_csv_path('pokemon'), $pokemon_data);

        $pokemon_table = read_table(get_csv_path('pokemon'));

        $data_body_template = render_template(
            get_template_path('/body/admin_view/data'),
            [
                'pokemon_table' => $pokemon_table
            ]
        );
        $data_view          = render_template(
            get_template_path('/skeleton/skeleton'),
            [
                'title'        => 'Datos',
                'body'         => $data_body_template,
                'contributors' => CONTRIBUTORS,
                'user'         => $context->name
            ]
        );

    } else {
        $pokemon_table = read_table(get_csv_path('pokemon'));

        $data_body_template = render_template(
            get_template_path('/body/data'),
            [
                'pokemon_table' => $pokemon_table
            ]
        );
        $data_view          = render_template(
            get_template_path('/skeleton/skeleton'),
            [
                'title'        => 'Datos',
                'body'         => $data_body_template,
                'contributors' => CONTRIBUTORS,
                'user'         => $context->name
            ]
        );
    }


    $response = new Response($data_view);
    return [$response, $context];
}

function error_404(Request $request, Context $context): array
{

    

    $error404_body = render_template(
        get_template_path('/body/error404'),
        [
            'request_path' => $request->path
        ]
    );

    $error404_view = render_template(
        get_template_path('/skeleton/skeleton'),
        [
            'title'         => 'Not found',
            'body'          => $error404_body,
            'contributors'  => CONTRIBUTORS
        ]
    );

    $response = new Response($error404_view, 404);
    return [$response, $context];
}


