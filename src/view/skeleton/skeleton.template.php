<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/styles.css">
    <title>PokéBlog</title>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>
<body>
    <nav class="navbar navbar-expand-lg sticky-top" id="navbar-section">
        <div class="container-fluid">
          <a class="navbar-brand" href="index" aria-current="home">
            <img src="img/img_aux/pokeball.png" alt="Logo" width="30" height="30" class="d-inline-block align-text-center">
            <span id="home-title">PokéBlog</span> 
          </a>
          <button class="navbar-toggler" id="toggle-btn" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"> <a class="nav-link link-light" href="blog" aria-current="pokemon-news">Blog</a></li>
                <li class="nav-item"> <a class="nav-link link-light" href="regions" aria-current="pokemon-images">Regions</a></li>
                <li class="nav-item"> <a class="nav-link link-light" href="data" aria-current="pokemon-dates">Datos</a></li>
            </ul>
          </div>
        </div>
    </nav>
  

  <?= $body ?>


    <div id="footer-container">
         <!-- Footer -->
         <footer>
         <!-- Copyright -->
         <div class="footer-copyright text-white text-center">© 2022 Copyright:
           <pre class="text-white"> Raul Montoro, Alvin Miller Garcia Garcia y Eloy Gonzalez</pre>
         </div>
         <!-- Copyright -->
         </footer>
         <!-- Footer -->
       </div>   
       <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>
</html>