<div class="col-sm-6 offset-sm-3 mb-5">
    <div class="card mt-5 mb-3">
        <div class="card-header text-bg-primary">
            Seleccione Evaluador
        </div>
        <div class="card-body">
            <div class="row mb-3 text-start">
                <h5>Evaluador actual: <?= $valoracion_evaluador['id_evaluador'] ?> - <?= $valoracion_evaluador['nom_evaluador'] ?></h5>
                <h4>Evaluador seleccionado: <span id="lbl_id_evaluador"></span> - <span id="lbl_nom_evaluador"></span></h4>
            </div>

            <div class="row mb-3">
                <div class="col-sm-10 offset-sm-1 align-self-center">
                    <form method="post" action="<?= base_url() ?>valoracion/valoracion_evaluador_seleccionar_evaluador/<?=$valoracion_evaluador['id_valoracion_evaluador']?>">
                        <div class="row">
                            <div class="col-7">
                                <label>Buscar por Número de Proveedor o Nombre</label>
                                <input type="text" class="form-control" name="buscar_evaluador" id="buscar_evaluador">
                            </div>
                            <div class="col-3 d-print-none text-end">
                                <br>
                                <label></label>
                                <button class="btn btn-success">Buscar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php foreach ($evaluadores as $evaluadores_item) { ?>
                <div class="col-sm-8 offset-sm-1 alternate-color">
                    <div class="row">
                        <div class="col-sm-2 align-self-center">
                            <p><?= $evaluadores_item['id_evaluador'] ?></p>
                        </div>
                        <div class="col-sm-6 align-self-center">
                            <p><a href="#" onclick="select_evaluador('<?= $evaluadores_item['id_evaluador'] ?>','<?= $evaluadores_item['nom_evaluador'] ?>')"><?= $evaluadores_item['nom_evaluador'] ?></a></p>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-4 text-start">
                    <a href="<?=base_url()?>evaluadores" class="btn btn-primary btn-sm boton">Agregar nuevo evaluador</a>
                </div>
                <div class="col-2 offset-6 text-end">
                    <form method="post" action="<?= base_url() ?>valoracion/valoracion_evaluador_actualizar_evaluador">
                        <input type="hidden" id="id_evaluador" name="id_evaluador" value="">
                        <input type="hidden" id="id_valoracion_evaluador" name="id_valoracion_evaluador" value="<?=$valoracion_evaluador['id_valoracion_evaluador']?>">
                        <button type="submit" class="btn btn-primary btn-sm">Aceptar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<hr />

<div class="form-group row">
    <div class="col-sm-10 d-print-none">
        <a href="<?=base_url()?>valoracion/valoracion_evaluador_detalle/<?=$valoracion_evaluador['id_valoracion_evaluador']?>" class="btn btn-secondary boton">Volver</a>
    </div>
</div>

<script>
    function select_evaluador(id_evaluador, nom_evaluador) {
        $("#lbl_id_evaluador").text(id_evaluador);
        $("#lbl_nom_evaluador").text(nom_evaluador);
        $("#id_evaluador").val(id_evaluador);
    }
</script>
