<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PokeBlog</title>
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>
<body>
    <nav class="navbar navbar-expand-lg sticky-top" id="navbar-section">
        <div class="container-fluid">
          <a class="navbar-brand" href="index.html" aria-current="home">
            <img src="img/img_aux/pokeball.png" alt="Logo" width="30" height="30" class="d-inline-block align-text-center">
            <span id="home-title">PokéBlog</span> 
          </a>
          <button class="navbar-toggler" id="toggle-btn" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"> <a class="nav-link link-light" href="blog.html" aria-current="pokemon-news">Blog</a></li>
                <li class="nav-item"> <a class="nav-link link-light" href="images.html" aria-current="pokemon-images">Galería</a></li>
                <li class="nav-item"> <a class="nav-link link-light" href="data.html" aria-current="pokemon-dates">Datos</a></li>
                <li class="nav-item"> <a class="nav-link link-light" href="#" aria-current="pokemon-dates">PokéApi</a></li>
            </ul>
          </div>
        </div>
    </nav>
      <!--Contents-->
      <div class="container ">
        <span class="logo"><img src="img/img_aux/pokemon-logo.png" alt="logo-image" width="350" height="100"></span>
          <?php 
                //Entrara un array con informacion de la region
                extract($info_region);
                echo "
                <h1 class='main-title'>Estos son los iniciales de $region_name</h1>
                <span class='initial-pokemons'>$pokemon_inicial_1,$pokemon_inicial_2  y $pokemon_inicial_3</span>
                <div class='pokemons-container'>";

                foreach ($images as $image) {
                    /*images vendra de la variable extraida del array de toda la info de la region.
                     images sera otro array pero indexado con las urls de las imagenes*/
                    echo "
                    <div class='pokemons-img'>
                    <img class='poke-img' src='$image' alt='initial-pokemons'>
                    </div>
                    </div>";
                }
          ?>
      </div>

      <!-- Footer -->
      <footer class="page-footer font-small blue">

      <!-- Copyright -->
      <div class="footer-copyright text-white text-center py-3">© 2022 Copyright:
        <pre class="text-white"> Raul Montoro, Alvin Miller Garcia Garcia y Eloy Gonzalez</pre>
      </div>
      <!-- Copyright -->

      </footer>
      <!-- Footer -->


      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>
</html>