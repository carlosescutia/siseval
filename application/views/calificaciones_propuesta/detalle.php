<main role="main" class="ml-sm-auto px-4">
    <div class="card mt-0 mb-3 tabla-datos">
        <div class="card-header text-white bg-primary">Calificación <?= $calificacion_propuesta['nom_dependencia'] ?></div>
        <div class="card-body">
            <form method="post" action="<?= base_url() ?>calificaciones_propuesta/guardar/">
                <div class="row mb-3">
                    <div class="col-sm-1">
                    </div>
                    <div class="col-sm-4 text-center">
                        <label for="evaluacion_obligatoria">
                            ¿La evaluación es obligatoria?
                            <a data-bs-toggle="collapse" href="#ayuda_evaluacion_obligatoria" role="button" aria-expanded="false" aria-controls="ayuda_evaluacion_obligatoria">
                                <i class="bi bi-info-circle texto-menor"></i>
                            </a>
                        </label>
                        <div class="collapse" id="ayuda_evaluacion_obligatoria">
                            <div class="texto-ayuda">
                                Cuando la normativa existente obliga a evaluar la intervención pública
                            </div>
                        </div>                
                        <select class="form-select" name="evaluacion_obligatoria" id="evaluacion_obligatoria">
                            <option value="1" <?= ($calificacion_propuesta['evaluacion_obligatoria'] == '1') ? 'selected' : '' ?> >Si</option>
                            <option value="0" <?= ($calificacion_propuesta['evaluacion_obligatoria'] == '0') ? 'selected' : '' ?> >No</option>
                        </select>
                    </div>
                    <div class="col-sm-1">
                    </div>
                    <div class="col-sm-4 text-center">
                        <label for="criterio_institucional">
                            Criterio institucional del Supervisor
                            <a data-bs-toggle="collapse" href="#ayuda_criterio_institucional" role="button" aria-expanded="false" aria-controls="ayuda_criterio_institucional">
                                <i class="bi bi-info-circle texto-menor"></i>
                            </a>
                        </label>
                        <div class="collapse" id="ayuda_criterio_institucional">
                            <div class="texto-ayuda">
                                Seleccione "Si" si considera que el programa debe incorporarse en la Agenda Anual de Evaluación.
                            </div>
                        </div>                
                        <select class="form-select" name="criterio_institucional" id="criterio_institucional">
                            <option value="50" <?= ($calificacion_propuesta['criterio_institucional'] == '50') ? 'selected' : '' ?> >Si</option>
                            <option value="0" <?= ($calificacion_propuesta['criterio_institucional'] == '0') ? 'selected' : '' ?> >No</option>
                        </select>
                    </div>
                </div>
                <hr class="mt-5 mb-4" />

                <div class="row mb-3">
                    <div class="col-sm-8">
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <label for="agenda2030">
                                    Agenda 2030
                                    <a data-bs-toggle="collapse" href="#ayuda_agenda2030" role="button" aria-expanded="false" aria-controls="ayuda_agenda2030">
                                        <i class="bi bi-info-circle texto-menor"></i>
                                    </a>
                                </label>
                                <div class="collapse" id="ayuda_agenda2030">
                                    <div class="texto-ayuda">
                                        <ul>
                                            <li>Seleccione “Sí” cuando el Programa Presupuestario al que pertenece el programa a evaluar se alinea con dos o más metas de un ODS de la Agenda 2030.</li>
                                            <li>Seleccione “Parcialmente” cuando el Programa Presupuestario al que pertenece al programa a evaluar se alinea solamente con una meta ODS de la Agenda 2030.</li>
                                        </ul>
                                    </div>
                                </div>                
                                <select class="form-select" name="agenda2030" id="agenda2030">
                                    <option value="100" <?= ($calificacion_propuesta['agenda2030'] == '100') ? 'selected' : '' ?> >Si</option>
                                    <option value="50" <?= ($calificacion_propuesta['agenda2030'] == '50') ? 'selected' : '' ?> >Parcialmente</option>
                                    <option value="-1" <?= ($calificacion_propuesta['agenda2030'] == '-1') ? 'selected' : '' ?> >N/A</option>
                                </select>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="pertinencia_evaluacion">
                                    Pertinencia de evaluación
                                    <a data-bs-toggle="collapse" href="#ayuda_pertinencia_evaluacion" role="button" aria-expanded="false" aria-controls="ayuda_pertinencia_evaluacion">
                                        <i class="bi bi-info-circle texto-menor"></i>
                                    </a>
                                </label>
                                <div class="collapse" id="ayuda_pertinencia_evaluacion">
                                    <div class="texto-ayuda">
                                        <ul>
                                            <li>Seleccione “Sí” si el programa a evaluar no cuenta con evaluaciones previas en los últimos dos ejercicios fiscales o bien, se trata de un programa nuevo. </li>
                                            <li>Seleccione “No” si el programa a evaluar cuenta con evaluaciones previas en los últimos dos ejercicios fiscales. </li>
                                            <li>Seleccione N/A en caso de tratarse de auditorías al desempeño.</li>
                                        </ul>
                                    </div>
                                </div>                
                                <select class="form-select" name="pertinencia_evaluacion" id="pertinencia_evaluacion">
                                    <option value="100" <?= ($calificacion_propuesta['pertinencia_evaluacion'] == '100') ? 'selected' : '' ?> >Si</option>
                                    <option value="0" <?= ($calificacion_propuesta['pertinencia_evaluacion'] == '0') ? 'selected' : '' ?> >No</option>
                                    <option value="-1" <?= ($calificacion_propuesta['pertinencia_evaluacion'] == '-1') ? 'selected' : '' ?> >N/A</option>
                                </select>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="ciclo_evaluativo">
                                    Ciclo evaluativo
                                    <a data-bs-toggle="collapse" href="#ayuda_ciclo_evaluativo" role="button" aria-expanded="false" aria-controls="ayuda_ciclo_evaluativo">
                                        <i class="bi bi-info-circle texto-menor"></i>
                                    </a>
                                </label>
                                <div class="collapse" id="ayuda_ciclo_evaluativo">
                                    <div class="texto-ayuda">
                                        <p>El ciclo de evaluación está determinado por tipo de evaluación que debería ser aplicado a un programa de acuerdo al siguiente orden:</p>
                                        <ol type="I">
                                            <li>Diagnóstico</li>
                                            <li>Diseño</li>
                                            <li>Línea Base</li>
                                            <li>Específica de Desempeño</li>
                                            <li>Procesos</li>
                                            <li>Consistencia y Resultados</li>
                                            <li>Resultados 
                                            <ul>
                                                <li>Seleccione “Sí” en caso de tratarse de un programa nuevo que comienza su ciclo evaluativo o cuando el programa propuesto a evaluar cuenta con evaluaciones previas y considera pertinente que continúe el ciclo de evaluación. </li>
                                                <li>Seleccione “No” cuando considere que el programa propuesto a evaluar no debe tener más evaluaciones que las ya aplicadas previamente. </li>
                                                <li>Seleccione N/A en caso de que no aplique el ciclo de evaluación.</li>
                                            </ul>
                                            </li>
                                        </ol>
                                    </div>
                                </div>                

                                <select class="form-select" name="ciclo_evaluativo" id="ciclo_evaluativo">
                                    <option value="100" <?= ($calificacion_propuesta['ciclo_evaluativo'] == '100') ? 'selected' : '' ?> >Si</option>
                                    <option value="0" <?= ($calificacion_propuesta['ciclo_evaluativo'] == '0') ? 'selected' : '' ?> >No</option>
                                    <option value="-1" <?= ($calificacion_propuesta['ciclo_evaluativo'] == '-1') ? 'selected' : '' ?> >N/A</option>
                                </select>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="informacion_disponible">
                                    Información disponible
                                    <a data-bs-toggle="collapse" href="#ayuda_informacion_disponible" role="button" aria-expanded="false" aria-controls="ayuda_informacion_disponible">
                                        <i class="bi bi-info-circle texto-menor"></i>
                                    </a>
                                </label>
                                <div class="collapse" id="ayuda_informacion_disponible">
                                    <div class="texto-ayuda">
                                        De acuerdo con la información especificada por la dependencia responsable o coordinadora del programa a evaluar, seleccione la opción que mejor describa la información que servirá de insumo para realizar la evaluación:
                                        <ul>
                                            <li>Alta: tres o más fuentes</li>
                                            <li>Media: dos fuentes</li>
                                            <li>Baja: una o ninguna fuente</li>
                                        </ul>
                                    </div>
                                </div>                
                                <select class="form-select" name="informacion_disponible" id="informacion_disponible">
                                    <option value="100" <?= ($calificacion_propuesta['informacion_disponible'] == '100') ? 'selected' : '' ?> >Alta</option>
                                    <option value="50" <?= ($calificacion_propuesta['informacion_disponible'] == '50') ? 'selected' : '' ?> >Media</option>
                                    <option value="0" <?= ($calificacion_propuesta['informacion_disponible'] == '0') ? 'selected' : '' ?> >Baja</option>
                                    <option value="-1" <?= ($calificacion_propuesta['informacion_disponible'] == '-1') ? 'selected' : '' ?> >N/A</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 text-center">
                        <div class="row">
                            <div class="col-sm-2">
                            </div>
                            <div class="col-sm-8">
                                <?php
                                    $color = 'secondary';
                                    switch ($semaforo_proyecto['semaforo_22']) {
                                        case 'Aceptable':
                                            $color = 'success';
                                            break;
                                        case 'Medio':
                                            $color = 'warning';
                                            break;
                                        case 'Bajo':
                                            $color = 'danger';
                                            break;
                                        default:
                                            $color = 'secondary';
                                    }
                                ?>
                                <div class="card border-<?=$color?>">
                                    <div class="card-header">
                                        Semáforo de desempeño físico 2022
                                    </div>
                                    <div class="card-body text-<?=$color?>">
                                        <h2 class="card-text"><?= $semaforo_proyecto['semaforo_22'] ?></h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <!-- se desactivan campos recomendaciones_previas y justificacion_no_atencion -->
                    <!--
                        <div class="col-sm-4">
                            <label for="recomendaciones_previas">
                                Recomendaciones previas
                                <a data-bs-toggle="collapse" href="#ayuda_recomendaciones_previas" role="button" aria-expanded="false" aria-controls="ayuda_recomendaciones_previas">
                                    <i class="bi bi-info-circle texto-menor"></i>
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
                                <option value="100" <?= ($calificacion_propuesta['recomendaciones_previas'] == '100') ? 'selected' : '' ?> >Todas atendidas</option>
                                <option value="66" <?= ($calificacion_propuesta['recomendaciones_previas'] == '66') ? 'selected' : '' ?> >Atendidas más del 50%</option>
                                <option value="33" <?= ($calificacion_propuesta['recomendaciones_previas'] == '33') ? 'selected' : '' ?> >Atendidas menos del 50%</option>
                                <option value="0" <?= ($calificacion_propuesta['recomendaciones_previas'] == '0') ? 'selected' : '' ?> >Sin atender</option>
                                <option value="-1" <?= ($calificacion_propuesta['recomendaciones_previas'] == '-1') ? 'selected' : '' ?> >N/A</option>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label for="justificacion_no_atencion">
                                Justificación de no atención
                            </label>
                            <input type="text" class="form-control" name="justificacion_no_atencion" id="justificacion_no_atencion" value="<?=$calificacion_propuesta['justificacion_no_atencion']?>">
                        </div>
                    -->
                </div>

                <hr class="mt-5 mb-4" />

                <div class="row mb-3">
                    <div class="col-sm-2 text-center">
                        <label for="puntaje">Puntaje</label>
                        <h1><?= $calificacion_propuesta['puntaje'] ?></h1>
                    </div>
                    <div class="col-sm-4">
                        <label for="clasificacion_supervisor">
                            Clasificación del supervisor
                            <a data-bs-toggle="collapse" href="#ayuda_clasificacion_supervisor" role="button" aria-expanded="false" aria-controls="ayuda_clasificacion_supervisor">
                                <i class="bi bi-info-circle texto-menor"></i>
                            </a>
                        </label>
                        <div class="collapse" id="ayuda_clasificacion_supervisor">
                            <div class="texto-ayuda">
                                Seleccione la sección de la Agenda Anual de Evaluación en la deberá integrarse el programa a evaluar.
                            </div>
                        </div>                
                        <select class="form-select" name="clasificacion_supervisor" id="clasificacion_supervisor">
                            <?php foreach ($clasificaciones_supervisor as $clasificaciones_supervisor_item) { ?>
                            <option value="<?=$clasificaciones_supervisor_item['cve_clasificacion_supervisor']?>" <?= ($clasificaciones_supervisor_item['cve_clasificacion_supervisor'] == $calificacion_propuesta['clasificacion_supervisor']) ? 'selected' : '' ?> ><?=$clasificaciones_supervisor_item['nom_clasificacion_supervisor']?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label for="comentarios">
                            Comentarios
                            <a data-bs-toggle="collapse" href="#ayuda_comentarios" role="button" aria-expanded="false" aria-controls="ayuda_comentarios">
                                <i class="bi bi-info-circle texto-menor"></i>
                            </a>
                        </label>
                        <div class="collapse" id="ayuda_comentarios">
                            <div class="texto-ayuda">
                                En caso de tener algún comentario o aclaración respecto a la selección realizada en alguno o varios de los criterios anteriores, favor de especificarlo.
                            </div>
                        </div>                
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
