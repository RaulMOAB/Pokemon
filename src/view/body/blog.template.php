
      <!--Contents-->
      <div class="container ">
        <span class="logo"><img src="img/img_aux/pokemon-logo.png" alt="logo-image" width="350" height="100"></span>
        <h1 class="main-title">Entérate de las últimas notícias sobre Pokémon y Pokémon GO!</h1>
         <div class="news">
          <?php  
            foreach ($news as $data) {
                                 
                  echo "<div class='card mb-3' style='width: 40rem;'>
                  <div class='card-body'>
                    <h5 class='card-title'>$data[title]</h5>
                    <h6 class='card-subtitle mb-2 text-primary'>$data[date]</h6>
                    <p class='card-text'>$data[content]</p>                   
                  </div>
                </div>" ;     
            }
          ?>
         </div> 
      </div>
