<h1 class="main-title"> Pokemon Data </h1>

<div class="container">

  <table class="mx-auto table table-bordered table-primary table-striped table-sm">

    <?php
    require_once(__DIR__ . '/../../config.php');
    use function Config\get_view_dir;

    require_once(__DIR__ . '/../../model/model.php');
    use function Model\get_body;
    use function Model\get_header;

    require_once(get_view_dir() . '/view.php');
    $header = get_header($pokemon_table->header);
    $body = get_body($pokemon_table->body);
    echo $header;
    echo $body;
    ?>

  </table>
</div>