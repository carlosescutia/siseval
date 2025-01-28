<?php
    $anio_sesion = $userdata['anio_sesion'] ;
?>
<div class="card mt-0 mb-3">
    <div class="card-header text-white bg-primary">
        Criterios para calificación de propuestas
    </div>
    <div class="card-body">
        <ul>
            <?php foreach( $criterios_calificacion_periodo as $criterios_calificacion_periodo_item) { ?>
            <li>
                <div class="row">
                    <div class="col-sm-6">
                        <?= $criterios_calificacion_periodo_item['nom_criterio'] ?>
                    </div>
                    <div class="col-sm-2">
                        <?php 
                        $item_eliminar = $criterios_calificacion_periodo_item['nom_criterio'] ;
                        $url = base_url() . "criterios_calificacion_periodo/eliminar/". $criterios_calificacion_periodo_item['id_criterio_calificacion_periodo']; 
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
        <form method="post" action="<?= base_url() ?>criterios_calificacion_periodo/guardar">
            <div class="row">
                <div class="col-md-8">
                    <select class="form-select" name="nom_criterio" id="nom_criterio">
                        <?php foreach ($criterios_calificacion as $criterios_calificacion_item) { ?>
                        <option value="<?= $criterios_calificacion_item['nom_criterio'] ?>"><?= $criterios_calificacion_item['nom_criterio'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <input type="hidden" name="periodo" id="periodo" value="<?= $periodo['nom_periodo'] ?>">
                <input type="hidden" name="id_periodo" id="id_periodo" value="<?= $periodo['id_periodo'] ?>">
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Agregar</button>
                </div>
            </div>
        </form>
    </div>
</div>
