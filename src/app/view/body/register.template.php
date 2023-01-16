<div class="container">
    <div class="row">
        <div class="col-lg-4 col-6 mx-auto mt-3">
            <h2 class="text-white text-center mb-3">Entra en el mundo Pokémon!</h2>
        <form method="POST" class="bg-light py-5 px-5 rounded">
            <div class="mb-3">
                <label for="username" class="form-label">Nombre usuario</label>
                <input type="username" class="form-control" id="username" name="username" aria-describedby="username">              
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="userPass" name="password">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Confirmar contraseña</label>
                <input type="password" class="form-control" id="userConfirmPass" name="confirm_password">
            </div>
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary mt-3">Registrarse</button>
            </div>
            <div class="d-flex justify-content-center links mt-3">
				<a href="/login">Ya tengo cuenta</a>
			</div>
            </form>
        </div>
    </div>
</div>