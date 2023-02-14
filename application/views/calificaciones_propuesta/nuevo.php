<main role="main" class="ml-sm-auto px-4">
    <div class="card mt-0 mb-3 tabla-datos">
        <div class="card-header text-white bg-primary">Nueva calificación</div>
        <div class="card-body">
            <form method="post" action="<?= base_url() ?>calificaciones_propuesta/guardar/">
                <div class="row mb-3">
                    <div class="col-sm-4">
                        <label for="obligatorias">Obligatorias</label>
                        <select class="form-select" name="obligatorias" id="obligatorias">
                            <option value=""></option>
                            <?php foreach ($valores_calificacion as $valores_calificacion_item) { ?>
                            <option value="<?=$valores_calificacion_item['puntaje']?>"><?=$valores_calificacion_item['nom_valor_calificacion']?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <label for="solicitud">Solicitud</label>
                        <select class="form-select" name="solicitud" id="solicitud">
                            <option value=""></option>
                            <?php foreach ($valores_calificacion as $valores_calificacion_item) { ?>
                            <option value="<?=$valores_calificacion_item['puntaje']?>"><?=$valores_calificacion_item['nom_valor_calificacion']?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <label for="intervenciones_estrategicas">Intervenciones estratégicas</label>
                        <select class="form-select" name="intervenciones_estrategicas" id="intervenciones_estrategicas">
                            <option value=""></option>
                            <?php foreach ($valores_calificacion as $valores_calificacion_item) { ?>
                            <option value="<?=$valores_calificacion_item['puntaje']?>"><?=$valores_calificacion_item['nom_valor_calificacion']?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4">
                        <label for="intervenciones_relevantes">Intervenciones relevantes</label>
                        <select class="form-select" name="intervenciones_relevantes" id="intervenciones_relevantes">
                            <option value=""></option>
                            <?php foreach ($valores_calificacion as $valores_calificacion_item) { ?>
                            <option value="<?=$valores_calificacion_item['puntaje']?>"><?=$valores_calificacion_item['nom_valor_calificacion']?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <label for="peso_presupuestario">Peso presupuestario</label>
                        <select class="form-select" name="peso_presupuestario" id="peso_presupuestario">
                            <option value=""></option>
                            <?php foreach ($valores_calificacion as $valores_calificacion_item) { ?>
                            <option value="<?=$valores_calificacion_item['puntaje']?>"><?=$valores_calificacion_item['nom_valor_calificacion']?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <label for="tiempo_ejecucion">Tiempo de ejecución</label>
                        <select class="form-select" name="tiempo_ejecucion" id="tiempo_ejecucion">
                            <option value=""></option>
                            <?php foreach ($valores_calificacion as $valores_calificacion_item) { ?>
                            <option value="<?=$valores_calificacion_item['puntaje']?>"><?=$valores_calificacion_item['nom_valor_calificacion']?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4">
                        <label for="informacion_disponible">Información disponible</label>
                        <select class="form-select" name="informacion_disponible" id="informacion_disponible">
                            <option value=""></option>
                            <?php foreach ($valores_calificacion as $valores_calificacion_item) { ?>
                            <option value="<?=$valores_calificacion_item['puntaje']?>"><?=$valores_calificacion_item['nom_valor_calificacion']?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <label for="mayor_cobertura">Mayor cobertura</label>
                        <select class="form-select" name="mayor_cobertura" id="mayor_cobertura">
                            <option value=""></option>
                            <?php foreach ($valores_calificacion as $valores_calificacion_item) { ?>
                            <option value="<?=$valores_calificacion_item['puntaje']?>"><?=$valores_calificacion_item['nom_valor_calificacion']?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <label for="tiempo_razonable">Tiempo razonable</label>
                        <select class="form-select" name="tiempo_razonable" id="tiempo_razonable">
                            <option value=""></option>
                            <?php foreach ($valores_calificacion as $valores_calificacion_item) { ?>
                            <option value="<?=$valores_calificacion_item['puntaje']?>"><?=$valores_calificacion_item['nom_valor_calificacion']?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <hr class="mt-5 mb-4" />

                <div class="row mb-3">
                    <div class="col-sm-3 text-center">
                    </div>
                    <div class="col-sm-3">
                        <label for="clasificacion_supervisor">Clasificación del supervisor</label>
                        <select class="form-select" name="clasificacion_supervisor" id="clasificacion_supervisor">
                            <option value=""></option>
                            <?php foreach ($clasificaciones_supervisor as $clasificaciones_supervisor_item) { ?>
                            <option value="<?=$clasificaciones_supervisor_item['cve_clasificacion_supervisor']?>"><?=$clasificaciones_supervisor_item['nom_clasificacion_supervisor']?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label for="comentarios">Comentarios</label>
                        <textarea rows="4" class="form-control" name="comentarios" id="comentarios"></textarea>
                    </div>
                </div>

                <input type="hidden" name="id_propuesta_evaluacion" value="<?= $id_propuesta_evaluacion ?>">
                <input type="hidden" name="cve_dependencia" value="<?= $cve_dependencia ?>">

                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <hr />
    <div class="form-group row">
        <div class="col-sm-10">
            <a href="<?=base_url()?>propuestas_evaluacion/detalle/<?= $id_propuesta_evaluacion ?>" class="btn btn-secondary boton">Volver</a>
        </div>
    </div>

</main>

