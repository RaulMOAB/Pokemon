
      <!--Contents-->
      <div class="container ">
        <span class="logo"><img src="img/img_aux/pokemon-logo.png" alt="logo-image" width="350" height="100"></span>
        <h1 class='main-title'>Pokémons iniciales</h1>
          <div class="pokemons-container">
            <div class="pokemons-img-container">
              <div class="initial-pokemons">
                <?php 
                  require_once __DIR__."/../viewlib.php";
                  use function View\getPokemonName;

                  foreach ($pokemons_images as $region_name => $value) {
                    echo "<h1 class='region-name text-center mt-3'>$region_name</h1>";
                    echo "<div class='pokemon_images d-flex'>";
                    
                    foreach ($value as $img ) {    
                      $name = getPokemonName($img);   
                      echo "<div class='pokemons-name'>";
                      echo "<img src='$img' class='poke-img' title='$name'>";
                      echo "<p>$name</p>";
                      echo "</div>";
                    }
                    echo "</div>";
                  }
                  
                  
                ?>
              </div>
            </div>
          </div>
      </div>

      