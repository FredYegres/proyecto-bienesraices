<fieldset>
    <legend>Información General</legend>

    <label for="titulo">Título</label>
    <?php $propiedad->mostrarErrores('titulo'); ?>
    <input type="text" name="propiedad[titulo]" id="titulo" placeholder="Titulo Propiedad" value="<?php echo s($propiedad->titulo); ?>">

    <label for="precio">Precio</label>
    <?php $propiedad->mostrarErrores('precio'); ?>
    <input type="number" name="propiedad[precio]" id="precio" min="1" max="9999999999" placeholder="Precio Propiedad" value="<?php echo s($propiedad->precio); ?>">

    <label for="imagen">Imagen</label>
    <?php $propiedad->mostrarErrores('imagen'); ?>
    <input type="file" name="propiedad[imagen]" id="imagen" accept="image/jpeg, image/png">

    <?php if($propiedad->imagen) { ?>
        <img src="/imagenes/<?php echo $propiedad->imagen ?>" class="imagen-small">
    <?php } ?>

    <label for="descripcion">Descripción</label>
    <?php $propiedad->mostrarErrores('descripcion', $descripcion = true); ?>
    <textarea name="propiedad[descripcion]" id="descripcion"><?php echo s($propiedad->descripcion); ?></textarea>
</fieldset>

<fieldset>
    <legend>Información Propiedad</legend>

    <label for="habitaciones">Habitaciones</label>
    <?php $propiedad->mostrarErrores('habitaciones'); ?>
    <input type="number" name="propiedad[habitaciones]" id="habitaciones" placeholder="Ej: 3" min="1" max="9" value="<?php echo s($propiedad->habitaciones); ?>">

    <label for="wc">Baños</label>
    <?php $propiedad->mostrarErrores('wc'); ?>
    <input type="number" name="propiedad[wc]" id="wc" placeholder="Ej: 3" min="1" max="9" value="<?php echo s($propiedad->wc); ?>">

    <label for="estacionamiento">Estacionamiento</label>
    <?php $propiedad->mostrarErrores('estacionamiento'); ?>
    <input type="number" name="propiedad[estacionamiento]" id="estacionamiento" placeholder="Ej: 3" min="1" max="9" value="<?php echo s($propiedad->estacionamiento)   ; ?>">
</fieldset>

<fieldset>
    <legend>Vendedor</legend>
    <?php $propiedad->mostrarErrores('vendedor_id'); ?>
    <select name="propiedad[vendedor_id]" id="vendedor">
        <option selected value="">Seleccionar</option>
        <?php foreach($vendedores as $vendedor) { ?>
            <option <?php echo $propiedad->vendedor_id === $vendedor->id ? 'selected' : ''; ?> value="<?php echo s($vendedor->id); ?>">
                <?php echo s($vendedor->nombre) . " " . s($vendedor->apellido); ?>  
            </option>
        <?php }; ?>
    </select>
</fieldset>