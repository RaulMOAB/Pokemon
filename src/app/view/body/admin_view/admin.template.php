<div class="container">
    <div class="row">
        <div class="col-xl-6 col-8 mx-auto bg bg-light mb-3 py-2 rounded">
            <h1 class=""> Administración de usuarios </h1>
            <form method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Nombre de usuario</label>
                    <input type="username" class="form-control" name="username" aria-describedby="username">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" name="password">
                </div>
                <div class="mb-3">
                <select class="form-select" name="role">
                    <option selected value="0"></option>  
                    <option value="user" name="user">User</option>
                    <option value="admin" name="admnin">Admin</option>                    
                </select>
                </div>
                <button type="submit" class="btn btn-primary">Añadir</button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-6 col-8 mx-auto bg bg-light mb-3 py-2 rounded">
            <form method="POST" action="delete">
                <table class="mx-auto table   table-sm text-center">
                   <?php
                   require_once(__DIR__ . '/../../../config.php');
                   use function Config\get_view_dir;


                   require_once(get_view_dir() . '/view.php');
                   echo View\get_html_header($users_table->header);

                   foreach ($users_table->body as $row) {
                    $username = $row['username'];
                    $password = $row['password'];
                    $role     = $row['role']  ;

                    echo<<<END
                    <tr>
                        <td>$username</td>
                        <td>$password</td>
                        <td>$role</td>
                        <td>                    
                            <button type="submit" name="username" value="$username" class="btn btn-danger">Delete</button>
                        </td>
                    </tr>
                    END;
                   }
                   
                   ?> 
                </table>
            </form>
        </div>
    </div>
</div>