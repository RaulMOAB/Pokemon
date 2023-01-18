<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title> <?= $title ?> </title>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

    <!--CSS-->
    <link rel="stylesheet" href="/css/styles.css">
    <!--Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://kit.fontawesome.com/bd26f4ad58.js" crossorigin="anonymous"></script>
    <!--Bootstrap-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>
    <div id="page-container">
        <div id="content-wrap">
            <!-- Navigation var -->
            <nav class="navbar navbar-expand-lg sticky-top navbar-dark" id="navbar-section">
                <div class="container-fluid">
                    <a class="navbar-brand" href="/index" aria-current="home">
                        <img id="nav-pokeball" class="" src="../img/img_aux/pokeball.png" alt="Logo" class="d-inline-block align-text-center">
                        <span id="home-title">PokéBlog</span>
                    </a>
                    <button class="navbar-toggler" id="toggle-btn" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item"> <a class="nav-link link-light" href="/blog" aria-current="pokemon-announcements">Blog</a></li>
                            <li class="nav-item"> <a class="nav-link link-light" href="/regions" aria-current="pokemon-images">Regiones</a></li>
                            <?php
                            $show_data = $user == '' ? false : true;
                            $data_link = $show_data ? '<li class="nav-item"> <a class="nav-link link-light" href="/data" aria-current="pokemon-dates">Datos</a></li>' : '';

                            $login_link  = '<li class="nav-item"> <button class="btn btn-light me-2" type="button"><a href="/login" class="login-btn">Login</a></button></li>';
                            $logout_link = '<li> <a href="/logout" class="btn btn-danger mt-2 mt-lg-0">Logout</a></li>';

                            $log_link = $logged ? $logout_link : $login_link;

                            $admin_link = '<li class="nav-item"> <a class="nav-link link-light" href="/admin" aria-current="user-management">Administrador</a></li>';

                            if ($role == 'admin') {
                                echo $admin_link;
                            }

                            echo $data_link;
                            echo $log_link;
                            ?>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="container-fluid">
                <div class="row">
                    <div class="col text-end mt-2 px-3">
                        <?php
                        $user = $user == '' ? 'invitado' : $user;
                        $avatar_seccion = <<<END
                            <div class="row">
                                <div class="col text-end mt-2 px-3 d-flex justify-content-end">
                                    <div class="profile-pic-container rounded-circle">
                                        <img class='img-thumbnail me-2 rounded-circle profile-picture  shadow-4-strong avatar' alt='avatar' src='$img_path' />
                                    </div>    
                                    <div>
                                        <p class='fs-6 mt-2 text-white fw-semibold'>$user</p>
                                    </div>                                        
                                </div>
                            </div>
                            END;
                        echo $avatar_seccion;
                        ?>

                    </div>
                </div>
            </div>

            <!-- Pokemon logo/ page top-->
            <div class="container logo text-center">
                <img class="h-100" src="/img/img_aux/pokemon-logo.png" alt="Pokemon-logo-image">
            </div>

            <!-- Variant body -->
            <?= $body ?>
        </div>

        <!-- footer -->
        <div id="page-footer" class="py-1 bg-primary">
            <footer>
                <!-- Copyright -->
                <div class="footer-copyright text-white text-center">© 2022 Copyright:
                    <pre class="text-white"> <?= implode(", ", $contributors) ?></pre>
                </div>
            </footer>
        </div>
    </div>

</body>

</html>