<main class="contenedor seccion contenido-centrado">
    <h1>Iniciar Sesión</h1>

    <form class="formulario" method="POST" action="/login">

    <fieldset>
        <legend>Email y Contraseña</legend>

        <label for="email">E-mail</label>
        <?php if($usuarioInvalido) { ?>
            <div class="alerta error">
                Usuario Invalido
            </div>
        <?php } ?>
        <?php $auth->mostrarErrores('email'); ?>
        <input type="email" name="email" id="email" placeholder="Tu Email" value="<?php echo $auth->email ?>">
        
        <label for="password">Contraseña</label>
        <?php if($passwordInvalida) { ?>
            <div class="alerta error">
                Contraseña Incorrecta
            </div>
        <?php } ?>
        <?php $auth->mostrarErrores('password'); ?>
        <input type="password" name="password" id="password" placeholder="Tu Contraseña">
    </fieldset>

        <input type="submit" value="Iniciar Sesión" class="boton boton-verde">
    </form>
</main>