<main role="main" class="ml-sm-auto px-4">
    <div class="card mt-0 mb-3 tabla-datos">
        <div class="card-header text-white bg-primary">Nueva calificación</div>
        <div class="card-body">
            <form method="post" action="<?= base_url() ?>calificaciones_propuesta/guardar/">
                <div class="row mb-3">
                    <div class="col-sm-5 px-5">
                        <div class="row row-cols-1">
                            <div class="col mb-3">
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
                                    <option value="1">Si</option>
                                    <option value="0" selected>No</option>
                                </select>
                            </div>
                            <div class="col mb-3">
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
                                    <option value="50">Si</option>
                                    <option value="0" selected>No</option>
                                </select>
                            </div>
                            <hr class="mt-3 mb-4" />
                            <div class="col mb-3">
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
                                    <option value="100">Si</option>
                                    <option value="0">No</option>
                                    <option value="-1" selected>N/A</option>
                                </select>
                            </div>
                            <div class="col mb-3">
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
                                    <option value="100">Si</option>
                                    <option value="0">No</option>
                                    <option value="-1" selected>N/A</option>
                                </select>
                            </div>
                            <div class="col mb-3">
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
                                <textarea rows="4" class="form-control" name="comentarios" id="comentarios"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 offset-sm-2 text-center">
                        <div class="row row-cols-1">
                            <div class="col mb-2">
                                <?php
                                    $color = 'secondary';
                                    if ($semaforo_proyecto) {
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
                                    }
                                ?>
                                <div class="card border-<?=$color?>">
                                    <div class="card-header">
                                        Semáforo de desempeño físico <?= $anio_propuestas - 1 ?>
                                    </div>
                                    <div class="card-body text-<?=$color?>">
                                        <?php if ($semaforo_proyecto) { ?>
                                        <h2 class="card-text"><?= $semaforo_proyecto['semaforo_22'] ?></h2>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col mb-2">
                                <div class="card border-secondary">
                                    <div class="card-header">
                                        Agenda 2030
                                    </div>
                                    <div class="card-body text-start">
                                        <?php foreach ($ods as $ods_item) { ?>
                                        <h6><?= $ods_item['cve_objetivo_desarrollo'] ?> <?= $ods_item['nom_objetivo_desarrollo'] ?></h6>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col mb-2">
                                <div class="card border-secondary">
                                    <div class="card-header">
                                        Información disponible
                                    </div>
                                    <div class="card-body">
                                        <?php
                                            switch ($tot_info_disponible) {
                                                case 0:
                                                case 1:
                                                    $info_disp = 'Baja';
                                                    break;
                                                case 2:
                                                    $info_disp = 'Media';
                                                    break;
                                                default:
                                                    $info_disp = 'Alta';
                                            }
                                        ?>
                                        <h4><?= $info_disp ?></h4>
                                        <p><?= $tot_info_disponible ?> fuentes de información disponibles</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="id_propuesta_evaluacion" value="<?= $id_propuesta_evaluacion ?>">
                <input type="hidden" name="cve_dependencia" value="<?= $cve_dependencia ?>">
                <input type="hidden" name="clasificacion_supervisor" value="0">

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
