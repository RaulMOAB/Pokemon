<?php

declare(strict_types=1);

namespace Controller;

require_once(__DIR__ . '/../config.php');

use function Config\get_app_dir;
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
use function Table\read_csv;
use function Model\find_user;
use function Model\exist_user;
use function Model\delete_announcement;
use function Model\delete_pokemon;
use function Model\add_user;
use function Model\delete_user;
use const Model\CONTRIBUTORS;

require_once(get_view_dir() . '/view.php');

use function View\get_template_path;
use function View\render_template;


// ############################################################################
// Helper functions
// ############################################################################

/**
 * Function to check if an user is logged
 * @return boolean 
 */
function check_login(Table $user_table, string $user_name, string $user_pass): bool
{

    $get_user_row = fn ($row) => (($row['username'] . $row['password']) == ($user_name . $user_pass));
    $filtered_table  = $user_table->filterRows($get_user_row);

    $login_ok = (count($filtered_table->body) == 1);

    return $login_ok;
}
// ----------------------------------------------------------------------------

// ############################################################################
// Request functions
// ############################################################################

/**
 * Function to display index view
 * @param $request is the path, http method and parameters
 * @param $context comunication data from browser 
 */
function index(Request $request, Context $context): array
{
    $logged   = $context->logged_in;
    $img_path = $context->avatar_profile_path;

    $index_body_template = render_template(
        get_template_path('/body/index'),
        [
            'contributors' => CONTRIBUTORS,
            'user'         => $context->name
        ]
    );
    $index_view = render_template(
        get_template_path('/skeleton/skeleton'),
        [
            'title'        => 'PokéBlog',
            'body'         => $index_body_template,
            'contributors' => CONTRIBUTORS,
            'user'         => $context->name,
            'logged'       => $logged,
            'img_path'     => $img_path,
            'role'         => $context->role
        ]
    );

    $response = new Response($index_view);
    return [$response, $context];
}

/**
 * Function to display admin view to add new users
 * Only users with role admin can access
 * @param $request is the path, http method and parameters
 * @param $context comunication data from browser 
 */
function admin(Request $request, Context $context): array
{

    $users_table = read_table(get_csv_path('users'));

    if ($context->role == 'admin') {
        if ($request->method == 'POST') {

            $username = $request->parameters['username'];
            $password = $request->parameters['password'];
            $role     = $request->parameters['role'];
            define('DEFAULT_ROLE', 'user');
            $set_role = ($role == '') ? DEFAULT_ROLE : $role;
            $new_user = new User($username, $password, $set_role);

            add_user($new_user, $users_table);
        }

        $admin_body_template = render_template(get_template_path('/body/admin_view/admin'), [
            'contributors' => CONTRIBUTORS,
            'users_table'  => $users_table
        ]);

        $admin_view = render_template(get_template_path('/skeleton/skeleton'), [
            'title'        => 'Administración de usuarios',
            'body'         => $admin_body_template,
            'contributors' => CONTRIBUTORS,
            'user'         => $context->name,
            'logged'       => $context->logged_in,
            'img_path'     => $context->avatar_profile_path,
            'role'         => $context->role
        ]);

        $response = new Response($admin_view);

        return [$response, $context];
    } else {

        $response = new Response();
        $response->set_redirection('/');

        return [$response, $context];
    }
}

/**
 * Function to delete an user by a form action from /admin
 * it takes the username from $request parameters to be cheked 
 * @param $request is the path, http method and parameters
 * @param $context comunication data from browser 
 */
function delete(Request $request, Context $context): array
{

    $users_table = read_table(get_csv_path('users'));

    $user_to_delete = $request->parameters['username'];

    delete_user($user_to_delete, $users_table);

    $response = new Response();
    $response->set_redirection('/admin');

    return [$response, $context];
}

/**
 * Function to display login view by GEt and login an user by POST
 * @param $request is the path, http method and parameters
 * @param $context comunication data from browser 
 */
function login(Request $request, Context $context): array
{
    $logged   = $context->logged_in;
    $img_path = $context->avatar_profile_path;

    if ($request->method == 'GET') {

        $login_body_template = render_template(
            get_template_path('/body/login'),
            ['contributors' => CONTRIBUTORS]
        );

        $login_view = render_template(get_template_path('/skeleton/skeleton'), [
            'title'        => 'PokéBlog',
            'body'         => $login_body_template,
            'contributors' => CONTRIBUTORS,
            'user'         => $context->name,
            'logged'       => $logged,
            'img_path'     => $img_path,
            'role'         => $context->role
        ]);

        $response = new Response($login_view);

        return [$response, $context];
    } elseif ($request->method == 'POST') {

        $username = $request->parameters['username'];
        $password = $request->parameters['password'];

        $registered_user = find_user($username, $password);

        if (!empty($registered_user->username)) { // if user does not exist an empty object is returned
            $context  = new Context(true, $registered_user->username, $registered_user->role, "/img/users_profile/logged/" . $username . "_profile.png");
            $response = new Response();
            $response->set_redirection('/');

            return [$response, $context];
        } else {
            $context  = new Context(avatar_profile_path: '/img/users_profile/guest/pokeball.png');
            $response = new Response();
            $response->set_redirection('/login');

            return [$response, $context];
        }
    }
}

/**
 * Function to register a new user
 * @param $request is the path, http method and parameters
 * @param $context comunication data from browser 
 */
function register(Request $request, Context $context): array
{
    $logged   = $context->logged_in;
    $img_path = $context->avatar_profile_path;
    $method   = $request->method;

    if ($method == 'GET') {
        $register_body_template = render_template(get_template_path('/body/register'), []);
        $register_view = render_template(get_template_path('/skeleton/skeleton'), [
            'body'         => $register_body_template,
            'title'        => 'Registro',
            'contributors' => CONTRIBUTORS,
            'user'         => $context->name,
            'logged'       => $logged,
            'img_path'     => $img_path,
            'role'         => $context->role
        ]);
        $response = new Response($register_view);
        return [$response, $context];
    } else if ($method == 'POST') {
        $users_table = read_csv(get_app_dir() . '/users.csv', '|');
        $username = $request->parameters['username'];
        $password = $request->parameters['password'];
        $confirm_password = $request->parameters['confirm_password'];
        $exist = exist_user($username, $password);
        if ($exist) {
            $response = new Response();
            $response->set_redirection('/register');
            return [$response, $context];
        } else {
            define('DEFAULT_ROL', 'user');
            $ready_user_to_add_to_table = [$username, $password, DEFAULT_ROL];
            $users_table->appendRow($ready_user_to_add_to_table);
            $users_table->writeCSV(get_app_dir() . '/users.csv');

            $context->logged_in = true;
            $context->name = $username;

            $context  = new Context(true, $username, DEFAULT_ROL, '/img/users_profile/guest/pokeball.png');
            $response = new Response();
            $response->set_redirection('/');

            return [$response, $context];
        }
    }
}

/**
 * Function to logout an user and redirect user to index view
 * @param $request is the path, http method and parameters
 * @param $context comunication data from browser 
 */
function logout(Request $request, Context $context): array
{
    $context  = new Context(avatar_profile_path: '/img/users_profile/guest/pokeball.png');
    $response = new Response();
    $response->set_redirection('/');
    return [$response, $context];
}

/**
 * Function to display blog view
 * ussers with admin role can add a new post or delete a post
 * @param $request is the path, http method and parameters
 * @param $context comunication data from browser 
 */
function blog(Request $request, Context $context): array
{
    $logged   = $context->logged_in;
    $img_path = $context->avatar_profile_path;

    if (($context->role == "admin") && ($request->method == 'POST')) {

        add_blog_announcement($request->parameters);

        $response = new Response();
        $response->set_redirection('/blog');

        return [$response, $context];
    } elseif (($context->role == "admin") && ($request->method == 'GET')) {

        $action = $request->parameters['action'] ?? 'none';
        if ($action !== 'none') {
            delete_announcement($action);
        }

        $get_announcements = get_announcements_array();

        $blog_body_template = render_template(
            get_template_path('/body/admin_view/blog'),
            [
                'announcements' => $get_announcements
            ]
        );
        $blog_view = render_template(
            get_template_path('/skeleton/skeleton'),
            [
                'title'        => 'Blog de noticias',
                'body'         => $blog_body_template,
                'contributors' => CONTRIBUTORS,
                'user'         => $context->name,
                'logged'       => $logged,
                'img_path'     => $img_path,
                'role'         => $context->role
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
        $blog_view = render_template(
            get_template_path('/skeleton/skeleton'),
            [
                'title'        => 'Blog de noticias',
                'body'         => $blog_body_template,
                'contributors' => CONTRIBUTORS,
                'user'         => $context->name,
                'logged'       => $logged,
                'img_path'     => $img_path,
                'role'         => $context->role
            ]
        );
    }

    $response = new Response($blog_view);

    return [$response, $context];
}

/**
 * Function to display regions view
 * Regions and game versions are obtained by PokeApi
 * @param $request is the path, http method and parameters
 * @param $context comunication data from browser 
 */
function regions(Request $request, Context $context): array
{
    $logged   = $context->logged_in;
    $img_path = $context->avatar_profile_path;

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
            'user'         => $context->name,
            'logged'       => $logged,
            'img_path'     => $img_path,
            'role'         => $context->role
        ]
    );

    $response = new Response($regions_view);

    return [$response, $context];
}

/**
 * Function to display each initial pokemons for every region
 * @param $request is the path, http method and parameters
 * @param $context comunication data from browser 
 */
function pokemons(Request $request, Context $context): array
{
    $logged   = $context->logged_in;
    $img_path = $context->avatar_profile_path;

    $region_name     = substr($request->path, 9);
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
            'user'         => $context->name,
            'logged'       => $logged,
            'img_path'     => $img_path
        ]
    );

    $response = new Response($pokemons_view);
    return [$response, $context];
}

/**
 * Function to display data view
 * Data is all the pokemons information from a csv file
 * User with admin role can add a new entry to the table or delete an entry
 * @param $request is the path, http method and parameters
 * @param $context comunication data from browser 
 */
function data(Request $request, Context $context): array
{
    $logged   = $context->logged_in;
    $img_path = $context->avatar_profile_path;

    if (($context->role == "admin") && ($request->method == "GET")) {

        $action = $request->parameters['action'] ?? '';

        $pokemon_table = read_table(get_csv_path('pokemon'));

        if ($action !== '') {
            delete_pokemon($action, $pokemon_table);
        }

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
                'user'         => $context->name,
                'logged'       => $logged,
                'img_path'     => $img_path,
                'role'         => $context->role
            ]
        );
    } elseif (($context->role == "admin") && ($request->method == 'POST')) {

        $pokemon_data = $request->parameters;

        add_pokemon(get_csv_path('pokemon'), $pokemon_data);

        $pokemon_table = read_table(get_csv_path('pokemon'));

        $data_body_template = render_template(
            get_template_path('/body/admin_view/data'),
            [
                'pokemon_table' => $pokemon_table
            ]
        );
        $data_view = render_template(
            get_template_path('/skeleton/skeleton'),
            [
                'title'        => 'Datos',
                'body'         => $data_body_template,
                'contributors' => CONTRIBUTORS,
                'user'         => $context->name,
                'logged'       => $logged,
                'img_path'     => $img_path,
                'role'         => $context->role
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
        $data_view = render_template(
            get_template_path('/skeleton/skeleton'),
            [
                'title'        => 'Datos',
                'body'         => $data_body_template,
                'contributors' => CONTRIBUTORS,
                'user'         => $context->name,
                'logged'       => $logged,
                'img_path'     => $img_path,
                'role'         => $context->role
            ]
        );
    }


    $response = new Response($data_view);
    return [$response, $context];
}

/**
 * Function to display error 404 view where user can see the request path
 * @param $request is the path, http method and parameters
 * @param $context comunication data from browser 
 */
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
