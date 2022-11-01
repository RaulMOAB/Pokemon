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
                <li class="nav-item"> <a class="nav-link link-light" href="#" aria-current="pokemon-dates">Datos</a></li>
            </ul>
          </div>
        </div>
    </nav>
      <!--Contents-->
      <div class="container ">
        <span class="logo"><img src="img/img_aux/pokemon-logo.png" alt="logo-image" width="350" height="100"></span>
        <h1 class="main-title">Imagenes de los iniciales</h1>
          <?php   
            foreach ($images as $image) {       
              echo "
                  <img class='d-block w-100' src='$image'>";
               
                  /*  
               
               echo "<div id='carouselExampleDark' class='carousel carousel-dark slide' data-bs-ride='carousel'>
                <div class='carousel-indicators'>
                  <button type='button' data-bs-target='#carouselExampleDark' data-bs-slide-to='0' class='active' aria-current='true' aria-label='Slide 1'></button>
                  <button type='button' data-bs-target='#carouselExampleDark' data-bs-slide-to='1' aria-label='Slide 2'></button>
                  <button type='button' data-bs-target='#carouselExampleDark' data-bs-slide-to='2' aria-label='Slide 3'></button>
                </div>
                <div class='carousel-inner'>
                  <div class='carousel-item active' data-bs-interval='10000'>
                    <img src='$image' class='d-block poke-img' alt='...'>
                    <div class='carousel-caption d-none d-md-block'>
                      <h5>First slide label</h5>
                      <p>Some representative placeholder content for the first slide.</p>
                    </div>
                  </div>
                  <div class='carousel-item' data-bs-interval='2000'>
                    <img src='$image' class='d-block poke-img' alt='...'>
                    <div class='carousel-caption d-none d-md-block'>
                      <h5>Second slide label</h5>
                      <p>Some representative placeholder content for the second slide.</p>
                    </div>
                  </div> 
                  <div class='carousel-item'>
                    <img src='$image' class='d-block poke-img' alt='...'>
                    <div class='carousel-caption d-none d-md-block'>
                      <h5>Third slide label</h5>
                      <p>Some representative placeholder content for the third slide.</p>
                    </div>
                  </div>
                </div>
                <button class='carousel-control-prev' type='button' data-bs-target='#carouselExampleDark' data-bs-slide='prev'>
                  <span class='carousel-control-prev-icon' aria-hidden='true'></span>
                  <span class='visually-hidden'>Previous</span>
                </button>
                <button class='carousel-control-next' type='button' data-bs-target='#carouselExampleDark' data-bs-slide='next'>
                  <span class='carousel-control-next-icon' aria-hidden='true'></span>
                  <span class='visually-hidden'>Next</span>
                </button>
              </div>";   */

            }
          ?>

      </div>

      <!-- Footer -->
      <footer class="page-footer font-small blue">

      <!-- Copyright -->
      <div class="footer-copyright text-white text-center py-3">© 2022 Copyright:
        <pre class="text-white"> Raul Montoro, Alvin Miller Garcia Garcia y Eloy Gonzales</pre>
      </div>
      <!-- Copyright -->

      </footer>
      <!-- Footer -->


      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>
</html>