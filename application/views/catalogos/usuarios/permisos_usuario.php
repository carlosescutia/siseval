<div class="card mt-0 mb-3">
    <div class="card-header text-white bg-primary">
        Permisos del usuario
    </div>
    <div class="card-body">
        <ul>
                <?php foreach( $accesos_sistema_usuario as $accesos_sistema_usuario_item) { ?>
                    <li>
            <div class="row">
                        <div class="col-sm-6">
                            <?= $accesos_sistema_usuario_item['nom_opcion'] ?>
                        </div>
                        <div class="col-sm-2">
                            <?php 
                                $item_eliminar = $accesos_sistema_usuario_item['nom_opcion'] ;
                                $url = base_url() . "accesos_sistema_usuario/eliminar/". $accesos_sistema_usuario_item['cve_acceso']; 
                                ?>
                                <a href="#dlg_borrar" data-bs-toggle="modal" onclick="pass_data('<?=$item_eliminar?>', '<?=$url?>')" ><i class="bi bi-x-circle boton-eliminar" ></i>
                                </a>
                        </div>
            </div>
                    </li>
                <?php } ?>
        </ul>
    </div>
    <div class="card-footer text-end">
        <form method="post" action="<?= base_url() ?>accesos_sistema_usuario/guardar">
            <div class="row">
                <div class="col-md-8">
                    <select class="form-select" name="cod_opcion" id="cod_opcion">
                        <?php foreach ($opciones_sistema_otorgables as $opciones_sistema_otorgables_item) { ?>
                        <option value="<?= $opciones_sistema_otorgables_item['cod_opcion'] ?>"><?= $opciones_sistema_otorgables_item['nom_opcion'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <input type="hidden" id="cve_usuario" name="cve_usuario" value="<?= $usuarios['cve_usuario'] ?>">
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Agregar</button>
                </div>
            </div>
        </form>
    </div>
</div>
