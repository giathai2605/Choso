<div class="form-group">
    <label class="form-control-label">ID COMERCIO</label>
    <input type="text" class="form-control" name="ID_DEL_COMERCIO" value="<?= $setting_data["ID_DEL_COMERCIO"] ?>" >
</div>
<div class="form-group">
    <label class="form-control-label">CLAVE SECRETA</label>
    <input type="text" class="form-control" name="CLAVE_SECRETA" value="<?= $setting_data["CLAVE_SECRETA"] ?>" >
</div>
<div class="form-group">
    <label class="form-control-label">YAPPY PLUGIN VERSION</label>
    <input type="text" class="form-control" name="YAPPY_PLUGIN_VERSION" value="<?= $setting_data["YAPPY_PLUGIN_VERSION"] ?>" >
</div>
<div class="form-group">
    <label class="form-control-label">MODO DE PRUEBAS</label>
    <input type="radio" <?= $setting_data["MODO_DE_PRUEBAS"] == 'true' ? 'checked="checked"' : ''; ?>  name="MODO_DE_PRUEBAS" value="true" > True
    <br>
    <input type="radio" <?= $setting_data["MODO_DE_PRUEBAS"] == 'false' ? 'checked="checked"' : ''; ?> name="MODO_DE_PRUEBAS" value="false" > False

</div>

<div class="form-group">
    <label  class="form-control-label">COLOR DEL BOTON</label>
    <select name="COLOR_DEL_BOTON" class="form-control">
    	<option <?= $setting_data["COLOR_DEL_BOTON"] == 'brand' ? 'selected' : ''; ?> value="brand">Brand</option>
    	<option <?= $setting_data["COLOR_DEL_BOTON"] == 'dark' ? 'selected' : ''; ?> value="dark">Dark</option>
    	<option <?= $setting_data["COLOR_DEL_BOTON"] == 'light' ? 'selected' : ''; ?> value="light">Light</option>
    </select>
</div>
<div class="form-group">
    <label class="form-control-label">DONACION</label>
    <input type="radio" <?= $setting_data["DONACION"] == 'true' ? 'checked="checked"' : ''; ?>  name="DONACION" value="
    true" > True
    <br>
    <input type="radio" <?= $setting_data["DONACION"] == 'false' ? 'checked="checked"' : ''; ?> name="DONACION" value="false" > False
</div>
<div class="form-group">
    <label class="form-control-label">ACTIVAR</label>
    <input type="radio" <?= $setting_data["ACTIVAR"] == 'true' ? 'checked="checked"' : ''; ?> name="ACTIVAR" value="true" > TRUE
    <br>
    <input type="radio" <?= $setting_data["ACTIVAR"] == 'false' ? 'checked="checked"' : ''; ?> name="ACTIVAR" value="false" > FALSE
</div>
<div class="form-group">
    <label class="control-label" for="input-completed-status">Completed Status</label>
    <select name="completed_status_id" id="input-completed-status" class="form-control">
        <?php foreach ($order_status as $order_status_id => $name){
				if(isset($setting_data["completed_status_id"])){
					$selected = ($order_status_id == $setting_data["completed_status_id"]) ? "selected" : "";
				}else{
					$selected = ($order_status_id == 1) ? "selected" : ""; ?>
	        	<?php } ?>
		        <option <?=$selected ?> value="<?= $order_status_id; ?>"><?= $name ?></option>
        	<?php } ?>
    </select>
</div>