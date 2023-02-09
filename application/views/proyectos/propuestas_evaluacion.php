<div class="card mt-0 mb-3 tabla-datos">
    <div class="card-header text-white bg-primary">Evaluación del ejercicio 2023</div>
    <div class="card-body">
        <form method="post" action="<?= base_url() ?>propuestas_evaluacion/guardar/">
            <div class="row mb-3">
                <div class="col-sm-6">
                    <label for="id_tipo_evaluacion">Tipo de evaluación</label>
                    <select class="form-select" name="id_tipo_evaluacion" id="id_tipo_evaluacion">
                        <option value=""></option>
                        <?php foreach ($tipos_evaluacion as $tipos_evaluacion_item) { ?>
                        <option value="<?=$tipos_evaluacion_item['id_tipo_evaluacion']?>" <?= ($tipos_evaluacion_item['id_tipo_evaluacion'] == $propuesta_evaluacion['id_tipo_evaluacion']) ? 'selected' : '' ?> ><?=$tipos_evaluacion_item['nom_tipo_evaluacion']?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-sm-6">
                    <label for="otro_tipo_evaluacion">Especifique en caso de Otro tipo</label>
                    <input type="text" class="form-control" name="otro_tipo_evaluacion" id="otro_tipo_evaluacion" value="<?=$propuesta_evaluacion['otro_tipo_evaluacion']?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-6">
                    <label for="id_justificacion_evaluacion">Justificación</label>
                    <select class="form-select" name="id_justificacion_evaluacion" id="id_justificacion_evaluacion">
                        <option value=""></option>
                        <?php foreach ($justificaciones_evaluacion as $justificaciones_evaluacion_item) { ?>
                        <option value="<?=$justificaciones_evaluacion_item['id_justificacion_evaluacion']?>" <?= ($justificaciones_evaluacion_item['id_justificacion_evaluacion'] == $propuesta_evaluacion['id_justificacion_evaluacion']) ? 'selected' : '' ?>><?=$justificaciones_evaluacion_item['nom_justificacion_evaluacion']?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-sm-6">
                    <label for="otra_justificacion_evaluacion">Especifique en caso de Otra justificación</label>
                    <input type="text" class="form-control" name="otra_justificacion_evaluacion" id="otra_justificacion_evaluacion" value="<?=$propuesta_evaluacion['otra_justificacion_evaluacion']?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="anios_ejecucion">Años de ejecución</label>
                    <select class="form-select" name="anios_ejecucion" id="anios_ejecucion">
                        <option value=""></option>
                        <?php for ($num = 1; $num <= 20; $num++) { ?>
                        <option value="<?=$num?>" <?= ($num == $propuesta_evaluacion['anios_ejecucion']) ? 'selected' : '' ?> ><?=$num?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-sm-3">
                    <label for="meses_duracion">Meses de duración</label>
                    <select class="form-select" name="meses_duracion" id="meses_duracion">
                        <option value=""></option>
                        <?php for ($num = 1; $num <= 12; $num++) { ?>
                        <option value="<?=$num?>" <?= ($num == $propuesta_evaluacion['meses_duracion']) ? 'selected' : '' ?> ><?=$num?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-sm-6">
                    <label for="objetivo">Objetivo</label>
                    <textarea rows="4" class="form-control" name="objetivo" id="objetivo"><?=$propuesta_evaluacion['objetivo']?></textarea>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="recursos_propios">¿Recursos propios?</label>
                    <select class="form-select" name="recursos_propios" id="recursos_propios">
                        <option value=""></option>
                        <option value="S" <?= ($propuesta_evaluacion['recursos_propios'] == 'S') ? 'selected' : '' ?> >Si</option>
                        <option value="N" <?= ($propuesta_evaluacion['recursos_propios'] == 'N') ? 'selected' : '' ?> >No</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <label for="monto">Monto</label>
                    <input type="text" class="form-control" name="monto" id="monto" value="<?=$propuesta_evaluacion['monto']?>">
                </div>
                <div class="col-sm-6">
                    <label for="observaciones">Observaciones</label>
                    <textarea rows="4" class="form-control" name="observaciones" id="observaciones"><?=$propuesta_evaluacion['observaciones']?></textarea>
                </div>
            </div>

            <input type="hidden" name="id_propuesta_evaluacion" value="<?= $propuesta_evaluacion['id_propuesta_evaluacion']; ?>">
            <input type="hidden" name="cve_proyecto" value="<?= $propuesta_evaluacion['cve_proyecto']; ?>">
        </div>
        <?php if (in_array('99', $accesos_sistema_rol)) { ?>
            <div class="card-footer text-end">
                <?php 
                $item_eliminar = 'Evaluación actual del proyecto '.$propuesta_evaluacion['cve_proyecto']; 
                $url = base_url() . "propuestas_evaluacion/eliminar/". $propuesta_evaluacion['id_propuesta_evaluacion']; 
                ?>
                <a type="button" class="btn btn-danger btn-sm" href="#dlg_borrar" data-bs-toggle="modal" role="button" onclick="pass_data('<?=$item_eliminar?>', '<?=$url?>')" >Eliminar</a>
                <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
            </div>
        <?php } ?>
    </form>
</div>
