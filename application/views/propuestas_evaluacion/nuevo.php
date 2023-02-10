<main role="main" class="ml-sm-auto px-4">

    <div class="card mt-0 mb-3 tabla-datos">
        <div class="card-header text-white bg-primary">Nueva propuesta de evaluación</div>
        <div class="card-body">
            <form method="post" action="<?= base_url() ?>propuestas_evaluacion/guardar/">
                <div class="row mb-3">
                    <div class="col-sm-6">
                        <label for="id_tipo_evaluacion">Tipo de evaluación</label>
                        <select class="form-select" name="id_tipo_evaluacion" id="id_tipo_evaluacion">
                            <option value=""></option>
                            <?php foreach ($tipos_evaluacion as $tipos_evaluacion_item) { ?>
                            <option value="<?=$tipos_evaluacion_item['id_tipo_evaluacion']?>"><?=$tipos_evaluacion_item['nom_tipo_evaluacion']?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label for="otro_tipo_evaluacion">Especifique en caso de Otro tipo</label>
                        <input type="text" class="form-control" name="otro_tipo_evaluacion" id="otro_tipo_evaluacion" value="">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-6">
                        <label for="id_justificacion_evaluacion">Justificación</label>
                        <select class="form-select" name="id_justificacion_evaluacion" id="id_justificacion_evaluacion">
                            <option value=""></option>
                            <?php foreach ($justificaciones_evaluacion as $justificaciones_evaluacion_item) { ?>
                            <option value="<?=$justificaciones_evaluacion_item['id_justificacion_evaluacion']?>" ><?=$justificaciones_evaluacion_item['nom_justificacion_evaluacion']?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label for="otra_justificacion_evaluacion">Especifique en caso de Otra justificación</label>
                        <input type="text" class="form-control" name="otra_justificacion_evaluacion" id="otra_justificacion_evaluacion" value="">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4">
                        <label for="recursos_propios">¿Se financiará con recursos propios?</label>
                        <select class="form-select" name="recursos_propios" id="recursos_propios">
                            <option value=""></option>
                            <option value="S">Si</option>
                            <option value="N">No</option>
                            <option value="NA">N/A</option>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <label for="monto">Monto</label>
                        <input type="text" class="form-control" name="monto" id="monto" value="">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-6">
                        <label for="objetivo">Objetivo</label>
                        <textarea rows="4" class="form-control" name="objetivo" id="objetivo"></textarea>
                    </div>
                    <div class="col-sm-6">
                        <label for="observaciones">Observaciones</label>
                        <textarea rows="4" class="form-control" name="observaciones" id="observaciones"></textarea>
                    </div>
                </div>

                <input type="hidden" name="cve_proyecto" value="<?= $cve_proyecto ?>">
                <input type="hidden" name="cve_dependencia" value="<?= $cve_dependencia ?>">

            </div>
            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
            </div>
        </form>
    </div>

    <hr />
    <div class="form-group row">
        <div class="col-sm-10">
            <a href="<?=base_url()?>proyectos/detalle/<?=$cve_proyecto?>" class="btn btn-secondary">Volver</a>
        </div>
    </div>

</main>
