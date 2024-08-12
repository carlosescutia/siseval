<div class="col-sm-8 offset-sm-2">
    <div class="card mt-3 mb-3">
        <div class="card-header text-bg-primary">
            Valoración
        </div>
        <div class="card-body">
            <form method="post" action="<?= base_url() ?>valoracion/valoracion_documento_opinion_guardar" id="valoracion">
                <div class="row mb-3">
                    <div class="col-sm-4">
                        <label for="pertinencia">
                            Pertinencia de la postura
                            <a data-bs-toggle="collapse" href="#ayuda_pertinencia" role="button" aria-expanded="false" aria-controls="ayuda_pertinencia">
                                <i class="bi bi-info-circle texto-menor"></i>
                            </a>
                            <br />
                            <br />
                        </label>
                        <div class="collapse" id="ayuda_pertinencia">
                            <div class="texto-ayuda">
                                <ul>
                                    <li>Señale SI, cuando considere que la <strong>postura sobre la recomendación</strong> establecida por la dependencia responsable del programa es adecuada.</li>
                                    <li>Señale NO, cuando considere que la <strong>postura sobre la recomendación</strong> establecida por la dependencia responsable del programa no es adecuada.</li>
                                </ul>
                            </div>
                        </div>                
                        <select class="form-select" name="pertinencia" id="pertinencia" required>
                            <option value=""></option>
                            <option value="1" <?= $valoracion_documento_opinion['pertinencia'] == '1' ? 'selected' : '' ?> >Si</option>
                            <option value="0" <?= $valoracion_documento_opinion['pertinencia'] == '0' ? 'selected' : '' ?> >No</option>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <label for="prioridad">
                            Nivel de prioridad
                            <a data-bs-toggle="collapse" href="#ayuda_prioridad" role="button" aria-expanded="false" aria-controls="ayuda_prioridad">
                                <i class="bi bi-info-circle texto-menor"></i>
                            </a>
                            <br />
                            <br />
                        </label>
                        <div class="collapse" id="ayuda_prioridad">
                            <div class="texto-ayuda">
                                <ul>
                                    <li>Señale SI, cuando considere que el <strong>nivel de prioridad de la recomendación</strong> establecido por la dependencia responsable del programa es adecuado.</li>
                                    <li>Señale NO, cuando considere que el <strong>nivel de prioridad de la recomendación</strong> establecido por la dependencia responsable del programa no es adecuado.</li>
                                </ul>
                            </div>
                        </div>                
                        <select class="form-select" name="prioridad" id="prioridad" required>
                            <option value=""></option>
                            <option value="1" <?= $valoracion_documento_opinion['prioridad'] == '1' ? 'selected' : '' ?> >Si</option>
                            <option value="0" <?= $valoracion_documento_opinion['prioridad'] == '0' ? 'selected' : '' ?> >No</option>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <label for="fundamentada">
                            La justificación de la postura está adecuadamente fundamentada
                            <a data-bs-toggle="collapse" href="#ayuda_fundamentada" role="button" aria-expanded="false" aria-controls="ayuda_fundamentada">
                                <i class="bi bi-info-circle texto-menor"></i>
                            </a>
                        </label>
                        <div class="collapse" id="ayuda_fundamentada">
                            <div class="texto-ayuda">
                                <ul>
                                    <li>Señale SI, cuando considere que la <strong>justificación de la postura</strong> establecida por la dependencia responsable del programa evaluado es suficiente y adecuada.</li>
                                    <li>Señale NO, cuando considere que la <strong>justificación de la postura</strong> establecida por la dependencia responsable del programa evaluado es insuficiente e inadecuada.</li>
                                </ul>
                            </div>
                        </div>                
                        <select class="form-select" name="fundamentada" id="fundamentada" required>
                            <option value=""></option>
                            <option value="1" <?= $valoracion_documento_opinion['fundamentada'] == '1' ? 'selected' : '' ?> >Si</option>
                            <option value="0" <?= $valoracion_documento_opinion['fundamentada'] == '0' ? 'selected' : '' ?> >No</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-12">
                        <label for="observaciones">
                            Observaciones
                            <a data-bs-toggle="collapse" href="#ayuda_observaciones" role="button" aria-expanded="false" aria-controls="ayuda_observaciones">
                                <i class="bi bi-info-circle texto-menor"></i>
                            </a>
                        </label>
                        <div class="collapse" id="ayuda_observaciones">
                            <div class="texto-ayuda">
                                Especifique sus observaciones en caso de haberlas.
                            </div>
                        </div>                
                        <textarea rows="4" class="form-control" name="observaciones" id="observaciones"><?=$valoracion_documento_opinion['observaciones']?></textarea>
                    </div>
                </div>
                <input type="hidden" name="cve_valoracion_documento_opinion" id="cve_valoracion_documento_opinion" value="<?=$valoracion_documento_opinion['cve_valoracion_documento_opinion']?>">
                <input type="hidden" name="cve_documento_opinion" id="cve_documento_opinion" value="<?=$valoracion_documento_opinion['cve_documento_opinion']?>">
            </form>
        </div>
        <?php
            $permisos_requeridos = array(
            'documento_opinion_valoracion.can_edit',
            'es_etapa_actual',
            );
        ?>
        <?php if (has_permission_and($permisos_requeridos, $permisos_usuario)) { ?>
            <?php if ($cve_dependencia == $valoracion_documento_opinion['cve_dependencia']) { ?>
                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary btn-sm" form="valoracion">Guardar</button>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
</div>

<hr />
<div class="form-group row">
    <div class="col-sm-10 d-print-none">
        <a href="<?=base_url()?>valoracion/documento_opinion_detalle/<?=$valoracion_documento_opinion['cve_documento_opinion']?>" class="btn btn-secondary boton">Volver</a>
    </div>
</div>
