<?php
    $anio_sesion = $userdata['anio_sesion'] ;
?>
<div class="card mt-0 mb-3">
    <div class="card-header text-white bg-primary">
        Aprobar por normativa los tipos de evaluación:
    </div>
    <div class="card-body">
        <ul>
            <?php foreach( $tipos_evaluacion_periodo as $tipos_evaluacion_periodo_item) { ?>
            <li>
                <div class="row">
                    <div class="col-sm-6">
                        <?= $tipos_evaluacion_periodo_item['nom_tipo_evaluacion'] ?>
                    </div>
                    <div class="col-sm-2">
                        <?php 
                        $item_eliminar = $tipos_evaluacion_periodo_item['nom_tipo_evaluacion'] . ' ' . $periodo['nom_periodo'] ;
                        $url = base_url() . "tipos_evaluacion_periodo/eliminar/". $tipos_evaluacion_periodo_item['id_tipo_evaluacion_periodo']; 
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
        <form method="post" action="<?= base_url() ?>tipos_evaluacion_periodo/guardar">
            <div class="row">
                <div class="col-md-8">
                    <select class="form-select" name="id_tipo_evaluacion" id="id_tipo_evaluacion">
                        <?php foreach ($tipos_evaluacion as $tipos_evaluacion_item) { ?>
                            <option value="<?= $tipos_evaluacion_item['id_tipo_evaluacion'] ?>"><?= $tipos_evaluacion_item['nom_tipo_evaluacion'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <input type="hidden" name="id_periodo" id="id_periodo" value="<?= $periodo['id_periodo'] ?>">
                <input type="hidden" name="periodo" id="periodo" value="<?= $periodo['nom_periodo'] ?>">
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Agregar</button>
                </div>
            </div>
        </form>
    </div>
</div>

