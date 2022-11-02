<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PokeBlog</title>
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link href="data:image/x-icon;base64,AAABAAEAEBAAAAEAIABoBAAAFgAAACgAAAAQAAAAIAAAAAEAIAAAAAAAAAQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAx8fH/8fHx//Hx8f/x8fH/8fHx//Hx8f/AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAx8fH/+Pj4//y8vL/8vLy//Ly8v/y8vL/4+Pj/8fHx/8AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAx8fH/+Pj4//y8vL///////////////////////Ly8v/j4+P/x8fH/wAAAAAAAAAAAAAAAAAAAAAAAAAAx8fH/+Pj4//y8vL///////////////9/////f///////////8vLy/+Pj4//Hx8f/AAAAAAAAAAAAAAAAAAAAAMfHx//y8vL///////////////9/AAAA/wAAAP////9////////////y8vL/x8fH/wAAAAAAAAAAAAAAAAAAAADj4+P/8vLy//////////9/AAAA/wAAAH4AAAB+AAAA/////3//////8vLy/+Pj4/8AAAAAAAAAAAAAAAAAAAAAAH3r/wCD9f8AiP//AGr/fwAAAP8AAAB+AAAAfgAAAP//M3d//zN3/8QxYv+wLFj/AAAAAAAAAAAAAAAAAAAAAAB96/8AiP//AIj//wCI//8Aav9/AAAA/wAAAP//M3d//zN3//8zd///M3f/sCxY/wAAAAAAAAAAAAAAAAAAAAAAiP//AIj//wCI//8AiP//AIj//wBq/3//M3d//zN3//8zd///M3f//zN3//8zd/8AAAAAAAAAAAAAAAAAAAAAAAAAAACI//8AiP//AIj//wCI//8AiP///zN3//8zd///M3f//zN3//8zd/8AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAIj//wCI//8AiP//AIj///8zd///M3f//zN3//8zd/8AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAiP//AIj//wCI////M3f//zN3//8zd/8AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA//8AAP//AAD4HwAA8A8AAOAHAADBgwAAwkMAAMWjAADFowAAwkMAAMGDAADgBwAA8A8AAPgfAAD//wAA//8AAA==" rel="icon" type="image/x-icon" />
</head>
<body>
    <nav class="navbar navbar-expand-lg sticky-top" id="navbar-section">
        <div class="container-fluid">
          <a class="navbar-brand" href="index.html" aria-current="home">
            <img src="../img/img_aux/pokeball.png" alt="Logo" width="30" height="30" class="d-inline-block align-text-center">
            <span id="home-title">PokéBlog</span> 
          </a>
          <button class="navbar-toggler" id="toggle-btn" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"> <a class="nav-link link-light" href="blog.html" aria-current="pokemon-news">Blog</a></li>
                <li class="nav-item"> <a class="nav-link link-light" href="regions.html" aria-current="pokemon-images">Galería</a></li>
                <li class="nav-item"> <a class="nav-link link-light" href="data.html" aria-current="pokemon-dates">Datos</a></li>
            </ul>
          </div>
        </div>
    </nav>
   <!--Contents-->
   <div class="container ">
   <span class="logo"><img src="../img/img_aux/pokemon-logo.png" alt="logo-image" width="350" height="100"></span>
        <h1 class="main-title">Aquí están todos los datos de los Pokémons</h1>
      <div class="table-responsive-lg">

      <table id="data-table" class="table table-dark table-hover">
        <?php         
          foreach ($csv_array as $key => $row) {
            echo "<tr>";
                foreach ($row as $key2 => $row2) {
                  echo "<td>$row2</td>";
                }
            echo "</tr>";
          };
        ?>
      </table>
      </div>
      </div>

      <!-- Footer -->
      <footer class="page-footer">

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