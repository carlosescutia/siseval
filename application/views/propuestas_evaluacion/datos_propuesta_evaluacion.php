<div class="card mt-0 mb-3 tabla-datos">
    <div class="card-header text-white bg-primary">Propuesta de evaluación <?=$propuesta_evaluacion['nom_dependencia'] ?> <?=$propuesta_evaluacion['nom_tipo_evaluacion'] ?> </div>
    <div class="card-body">
        <form method="post" action="<?= base_url() ?>propuestas_evaluacion/guardar/">
            <div class="row mb-3">
                <div class="col-sm-6">
                    <label for="id_tipo_evaluacion">
                        Tipo de evaluación
                        <a data-bs-toggle="collapse" href="#ayuda_id_tipo_evaluacion" role="button" aria-expanded="false" aria-controls="ayuda_id_tipo_evaluacion">
                            <i class="bi bi-info-circle"></i>
                        </a>
                    </label>
                    <div class="collapse" id="ayuda_id_tipo_evaluacion">
                        <div class="texto-ayuda">
                            Seleccione el tipo de evaluación. Si no se encuentra en la lista desplegable seleccione “otro”
                        </div>
                    </div>                
                    <select class="form-select" name="id_tipo_evaluacion" id="id_tipo_evaluacion">
                        <option value=""></option>
                        <?php foreach ($tipos_evaluacion as $tipos_evaluacion_item) { ?>
                        <option value="<?=$tipos_evaluacion_item['id_tipo_evaluacion']?>" <?= ($tipos_evaluacion_item['id_tipo_evaluacion'] == $propuesta_evaluacion['id_tipo_evaluacion']) ? 'selected' : '' ?> ><?=$tipos_evaluacion_item['nom_tipo_evaluacion']?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-sm-6">
                    <label for="otro_tipo_evaluacion">
                        Especifique en caso de Otro tipo
                        <a data-bs-toggle="collapse" href="#ayuda_otro_tipo_evaluacion" role="button" aria-expanded="false" aria-controls="ayuda_otro_tipo_evaluacion">
                            <i class="bi bi-info-circle"></i>
                        </a>
                    </label>
                    <div class="collapse" id="ayuda_otro_tipo_evaluacion">
                        <div class="texto-ayuda">
                            Si seleccionó “otro” en la casilla previa, especificar el tipo de evaluación.
                        </div>
                    </div>                
                    <input type="text" class="form-control" name="otro_tipo_evaluacion" id="otro_tipo_evaluacion" value="<?=$propuesta_evaluacion['otro_tipo_evaluacion']?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-6">
                    <label for="id_justificacion_evaluacion">
                        Justificación
                        <a data-bs-toggle="collapse" href="#ayuda_id_justificacion_evaluacion" role="button" aria-expanded="false" aria-controls="ayuda_id_justificacion_evaluacion">
                            <i class="bi bi-info-circle"></i>
                        </a>
                    </label>
                    <div class="collapse" id="ayuda_id_justificacion_evaluacion">
                        <div class="texto-ayuda">
                            Seleccione la opción que justifica mejor la realización de la evaluación a su programa. Si no se encuentra en la lista desplegable seleccione “otro”.
                        </div>
                    </div>                
                    <select class="form-select" name="id_justificacion_evaluacion" id="id_justificacion_evaluacion">
                        <option value=""></option>
                        <?php foreach ($justificaciones_evaluacion as $justificaciones_evaluacion_item) { ?>
                        <option value="<?=$justificaciones_evaluacion_item['id_justificacion_evaluacion']?>" <?= ($justificaciones_evaluacion_item['id_justificacion_evaluacion'] == $propuesta_evaluacion['id_justificacion_evaluacion']) ? 'selected' : '' ?>><?=$justificaciones_evaluacion_item['nom_justificacion_evaluacion']?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-sm-6">
                    <label for="otra_justificacion_evaluacion">
                        Especifique en caso de Otra Justificación
                        <a data-bs-toggle="collapse" href="#ayuda_otra_justificacion_evaluacion" role="button" aria-expanded="false" aria-controls="ayuda_otra_justificacion_evaluacion">
                            <i class="bi bi-info-circle"></i>
                        </a>
                    </label>
                    <div class="collapse" id="ayuda_otra_justificacion_evaluacion">
                        <div class="texto-ayuda">
                            Si seleccionó “otro” en la casilla previa, especificar el motivo que justifica la realización de la evaluación a su programa.
                        </div>
                    </div>                
                    <input type="text" class="form-control" name="otra_justificacion_evaluacion" id="otra_justificacion_evaluacion" value="<?=$propuesta_evaluacion['otra_justificacion_evaluacion']?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-4">
                    <label for="recursos_propios">
                        ¿Se financiará con recursos propios?
                        <a data-bs-toggle="collapse" href="#ayuda_recursos_propios" role="button" aria-expanded="false" aria-controls="ayuda_recursos_propios">
                            <i class="bi bi-info-circle"></i>
                        </a>
                    </label>
                    <div class="collapse" id="ayuda_recursos_propios">
                        <div class="texto-ayuda">
                            <ul>
                                <li>Seleccione “Sí” si cuenta con recursos propios para realizar la evaluación. </li>
                                <li>Seleccione “No” en caso de que la evaluación se vaya a financiar con recursos de otra dependencia o se propone para financiarse con recursos del Sistema de Evaluación del Estado.</li>
                                <li>Seleccione “N/A” en caso de que la evaluación se vaya a realizar con personal propio de la dependencia (evaluación interna).</li>
                            </ul>
                        </div>
                    </div>                
                    <select class="form-select" name="recursos_propios" id="recursos_propios">
                        <option value=""></option>
                        <option value="S" <?= ($propuesta_evaluacion['recursos_propios'] == 'S') ? 'selected' : '' ?> >Si</option>
                        <option value="N" <?= ($propuesta_evaluacion['recursos_propios'] == 'N') ? 'selected' : '' ?> >No</option>
                        <option value="NA" <?= ($propuesta_evaluacion['recursos_propios'] == 'NA') ? 'selected' : '' ?> >N/A</option>
                    </select>
                </div>
                <div class="col-sm-2">
                    <label for="monto">
                        Monto
                        <a data-bs-toggle="collapse" href="#ayuda_monto" role="button" aria-expanded="false" aria-controls="ayuda_monto">
                            <i class="bi bi-info-circle"></i>
                        </a>
                    </label>
                    <div class="collapse" id="ayuda_monto">
                        <div class="texto-ayuda">
                            En caso de que su respuesta en el apartado anterior haya sido “Sí”, especifique el presupuesto con el que cuenta su dependencia para realizar la evaluación.
                        </div>
                    </div>                
                    <input type="text" class="form-control" name="monto" id="monto" value="<?=$propuesta_evaluacion['monto']?>">
                </div>
                <div class="col-sm-6">
                    <label for="recomendaciones_previas">
                        Recomendaciones previas
                        <a data-bs-toggle="collapse" href="#ayuda_recomendaciones_previas" role="button" aria-expanded="false" aria-controls="ayuda_recomendaciones_previas">
                            <i class="bi bi-info-circle"></i>
                        </a>
                    </label>
                    <div class="collapse" id="ayuda_recomendaciones_previas">
                        <div class="texto-ayuda">
                            <ul>
                                <li>Seleccione la opción que mejor corresponda al avance en la atención de las recomendaciones de evaluaciones previas aplicadas al programa de acuerdo a lo señalado por la dependencia que lo propone. </li>
                                <li>Seleccione N/A cuando el programa no cuente con evaluaciones previas. </li>
                            </ul>
                        </div>
                    </div>                
                    <select class="form-select" name="recomendaciones_previas" id="recomendaciones_previas">
                        <option value=""></option>
                        <option value="100" <?= ($propuesta_evaluacion['recomendaciones_previas'] == '100') ? 'selected' : '' ?> >Todas atendidas</option>
                        <option value="66" <?= ($propuesta_evaluacion['recomendaciones_previas'] == '66') ? 'selected' : '' ?> >Atendidas más del 50%</option>
                        <option value="33" <?= ($propuesta_evaluacion['recomendaciones_previas'] == '33') ? 'selected' : '' ?> >Atendidas menos del 50%</option>
                        <option value="0" <?= ($propuesta_evaluacion['recomendaciones_previas'] == '0') ? 'selected' : '' ?> >Sin atender</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-6">
                    <label for="objetivo">
                        Objetivo
                        <a data-bs-toggle="collapse" href="#ayuda_objetivo" role="button" aria-expanded="false" aria-controls="ayuda_objetivo">
                            <i class="bi bi-info-circle"></i>
                        </a>
                    </label>
                    <div class="collapse" id="ayuda_objetivo">
                        <div class="texto-ayuda">
                            Especifique brevemente el objetivo de la evaluación a realizar.
                        </div>
                    </div>                
                    <textarea rows="4" class="form-control" name="objetivo" id="objetivo"><?=$propuesta_evaluacion['objetivo']?></textarea>
                </div>
                <div class="col-sm-6">
                    <label for="observaciones">
                        Observaciones
                        <a data-bs-toggle="collapse" href="#ayuda_observaciones" role="button" aria-expanded="false" aria-controls="ayuda_observaciones">
                            <i class="bi bi-info-circle"></i>
                        </a>
                    </label>
                    <div class="collapse" id="ayuda_observaciones">
                        <div class="texto-ayuda">
                            En caso de tener alguna observación o aclaración respecto a la evaluación a realizar a su programa, favor de especificarla.
                        </div>
                    </div>                
                    <textarea rows="4" class="form-control" name="observaciones" id="observaciones"><?=$propuesta_evaluacion['observaciones']?></textarea>
                </div>
            </div>

            <input type="hidden" name="id_propuesta_evaluacion" value="<?= $propuesta_evaluacion['id_propuesta_evaluacion']; ?>">
            <input type="hidden" name="cve_proyecto" value="<?= $propuesta_evaluacion['cve_proyecto']; ?>">
            <input type="hidden" name="cve_dependencia" value="<?= $cve_dependencia ?>">
            <?php if (in_array('99', $accesos_sistema_rol)) {
                if ($cve_dependencia == $propuesta_evaluacion['cve_dependencia']) { ?>
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
                    </div>
                <?php } 
            } ?>
        </form>
    </div>
</div>
