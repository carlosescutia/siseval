<main role="main" class="ml-sm-auto px-4">
    <div class="card mt-0 mb-3 tabla-datos">
        <div class="card-header text-white header-nivel3">Calificación <?= $calificacion_propuesta['nom_dependencia'] ?></div>
        <div class="card-body">
            <form method="post" action="<?= base_url() ?>calificaciones_propuesta/guardar/">
                <div class="row mb-3">
                    <div class="col-sm-6">
                        <label for="evaluacion_obligatoria">¿La evaluación es obligatoria?</label>
                        <select class="form-select" name="evaluacion_obligatoria" id="evaluacion_obligatoria">
                            <option value="1" <?= ($calificacion_propuesta['evaluacion_obligatoria'] == '1') ? 'selected' : '' ?> >Si</option>
                            <option value="0" <?= ($calificacion_propuesta['evaluacion_obligatoria'] == '0') ? 'selected' : '' ?> >No</option>
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label for="incidencias_programa">¿El programa tiene incidencias?</label>
                        <select class="form-select" name="incidencias_programa" id="incidencias_programa">
                            <option value="1" <?= ($calificacion_propuesta['incidencias_programa'] == '1') ? 'selected' : '' ?> >Si</option>
                            <option value="0" <?= ($calificacion_propuesta['incidencias_programa'] == '0') ? 'selected' : '' ?> >No</option>
                        </select>
                    </div>
                </div>
                <hr class="mt-5 mb-4" />
                <div class="row mb-3">
                    <div class="col-sm-4">
                        <label for="agenda2030">Agenda 2030</label>
                        <select class="form-select" name="agenda2030" id="agenda2030">
                            <option value="100" <?= ($calificacion_propuesta['agenda2030'] == '100') ? 'selected' : '' ?> >Si</option>
                            <option value="50" <?= ($calificacion_propuesta['agenda2030'] == '50') ? 'selected' : '' ?> >Parcialmente</option>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <label for="pertinencia_evaluación">Pertinencia de evaluación</label>
                        <select class="form-select" name="pertinencia_evaluacion" id="pertinencia_evaluacion">
                            <option value="100" <?= ($calificacion_propuesta['pertinencia_evaluacion'] == '100') ? 'selected' : '' ?> >Si</option>
                            <option value="0" <?= ($calificacion_propuesta['pertinencia_evaluacion'] == '0') ? 'selected' : '' ?> >No</option>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <label for="ciclo_evaluativo">Ciclo evaluativo</label>
                        <select class="form-select" name="ciclo_evaluativo" id="ciclo_evaluativo">
                            <option value="100" <?= ($calificacion_propuesta['ciclo_evaluativo'] == '100') ? 'selected' : '' ?> >Si</option>
                            <option value="0" <?= ($calificacion_propuesta['ciclo_evaluativo'] == '0') ? 'selected' : '' ?> >No</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4">
                        <label for="recomendaciones_previas">Recomendaciones previas</label>
                        <select class="form-select" name="recomendaciones_previas" id="recomendaciones_previas">
                            <option value="100" <?= ($calificacion_propuesta['recomendaciones_previas'] == '100') ? 'selected' : '' ?> >Todas atendidas</option>
                            <option value="66" <?= ($calificacion_propuesta['recomendaciones_previas'] == '66') ? 'selected' : '' ?> >Atendidas más del 50%</option>
                            <option value="33" <?= ($calificacion_propuesta['recomendaciones_previas'] == '33') ? 'selected' : '' ?> >Atendidas menos del 50%</option>
                            <option value="0" <?= ($calificacion_propuesta['recomendaciones_previas'] == '0') ? 'selected' : '' ?> >Sin atender</option>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <label for="informacion_disponible">Información disponible</label>
                        <select class="form-select" name="informacion_disponible" id="informacion_disponible">
                            <option value="100" <?= ($calificacion_propuesta['informacion_disponible'] == '100') ? 'selected' : '' ?> >Alta</option>
                            <option value="50" <?= ($calificacion_propuesta['informacion_disponible'] == '50') ? 'selected' : '' ?> >Media</option>
                            <option value="0" <?= ($calificacion_propuesta['informacion_disponible'] == '0') ? 'selected' : '' ?> >Baja</option>
                        </select>
                    </div>
                </div>

                <hr class="mt-5 mb-4" />

                <div class="row mb-3">
                    <div class="col-sm-2 text-center">
                        <label for="puntaje">Puntaje</label>
                        <h1><?= $calificacion_propuesta['puntaje'] ?></h1>
                    </div>
                    <div class="col-sm-4">
                        <label for="clasificacion_supervisor">Clasificación del supervisor</label>
                        <select class="form-select" name="clasificacion_supervisor" id="clasificacion_supervisor">
                            <?php foreach ($clasificaciones_supervisor as $clasificaciones_supervisor_item) { ?>
                            <option value="<?=$clasificaciones_supervisor_item['cve_clasificacion_supervisor']?>" <?= ($clasificaciones_supervisor_item['cve_clasificacion_supervisor'] == $calificacion_propuesta['clasificacion_supervisor']) ? 'selected' : '' ?> ><?=$clasificaciones_supervisor_item['nom_clasificacion_supervisor']?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label for="comentarios">Comentarios</label>
                        <textarea rows="4" class="form-control" name="comentarios" id="comentarios"><?=$calificacion_propuesta['comentarios']?></textarea>
                    </div>
                </div>

                <input type="hidden" name="id_calificacion_propuesta" value="<?= $calificacion_propuesta['id_calificacion_propuesta'] ?>">
                <input type="hidden" name="id_propuesta_evaluacion" value="<?= $calificacion_propuesta['id_propuesta_evaluacion'] ?>">
                <input type="hidden" name="cve_dependencia" value="<?= $calificacion_propuesta['cve_dependencia'] ?>">

                <?php if (in_array('99', $accesos_sistema_rol)) { ?>
                    <?php if ($cve_dependencia == $calificacion_propuesta['cve_dependencia']) { ?>
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
                        </div>
                    <?php } ?>
                <?php } ?>
            </form>
        </div>
    </div>

    <hr />
    <div class="form-group row">
        <div class="col-sm-10">
            <a href="<?=base_url()?>propuestas_evaluacion/detalle/<?= $calificacion_propuesta['id_propuesta_evaluacion']?>" class="btn btn-secondary boton">Volver</a>
        </div>
    </div>

</main>
