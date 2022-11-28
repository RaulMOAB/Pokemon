
      <!--Contents-->
      <div class="container ">
        <span class="logo"><img src="img/img_aux/pokemon-logo.png" alt="logo-image" width="350" height="100"></span>
        <h1 class='main-title'>Pokémons iniciales</h1>
          <div class="pokemons-container">
            <div class="pokemons-img-container">
              <div class="initial-pokemons">
                <?php 

                  foreach ($pokemons_images as $region_name => $value) {
                    echo "<h1 class='h1 text-center mt-3'>$region_name</h1>";
                    foreach ($value as $img ) {
                      echo "<img src='$img' class='poke-img' title='pokemons'>";
                    }
                  }
                  
                ?>
              </div>
            </div>
          </div>
      </div>

      