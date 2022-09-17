<fieldset>
    <legend>Información General</legend>

    <label for="titulo">Nombre</label>
    <?php $vendedor->mostrarErrores('nombre'); ?>
    <input type="text" name="vendedor[nombre]" id="nombre" placeholder="Nombre Vendedor" value="<?php echo s($vendedor->nombre); ?>">

    <label for="apellido">Apellido</label>
    <?php $vendedor->mostrarErrores('apellido'); ?>
    <input type="text" name="vendedor[apellido]" id="apellido" placeholder="Apellido Vendedor" value="<?php echo s($vendedor->apellido); ?>">

    <label for="imagen">Teléfono</label>
    <?php $vendedor->mostrarErrores('telefono', $telefono = true); ?>
    <input type="tel" name="vendedor[telefono]" id="telefono" placeholder="Número Vendedor" maxlength="11" value="<?php echo s($vendedor->telefono); ?>">


</fieldset>