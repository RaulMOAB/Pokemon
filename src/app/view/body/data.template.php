<h1 class="main-title"> Pokemon Data </h1>

<div class="container">
  <table class="mx-auto table table-bordered table-primary table-striped table-sm">
    
      <?php
    require_once(__DIR__ . '/../../config.php');
    use function Config\get_view_dir;

    require_once(get_view_dir() . '/view.php');
      //echo $pokemon_table["header"];
      echo View\get_html_header($pokemon_table->header);
      echo View\get_html_body($pokemon_table->body)

      
      //echo $pokemon_table["body"];
      ?>
    
  </table>
</div>