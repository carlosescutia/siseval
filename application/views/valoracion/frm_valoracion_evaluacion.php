<?php
    $puntaje_valoracion_evaluacion = $valoracion_evaluacion['puntaje_valoracion_evaluacion'];
    switch(true) {
        case $puntaje_valoracion_evaluacion == '':
            $valoracion = '';
            break;
        case $puntaje_valoracion_evaluacion <= 24:
            $valoracion = 'Calidad insuficiente';
            break;
        case $puntaje_valoracion_evaluacion >= 25 and $puntaje_valoracion_evaluacion <= 34:
            $valoracion = 'Calidad incipiente';
            break;
        case $puntaje_valoracion_evaluacion >= 35 and $puntaje_valoracion_evaluacion <= 44:
            $valoracion = 'Calidad buena';
            break;
        case $puntaje_valoracion_evaluacion >= 45:
            $valoracion = 'Calidad sobresaliente';
            break;
        default:
            $valoracion = '';
            break;
    }
?>
<div class="col-12 mt-3 text-center d-print-none">
    <a href="javascript:window.print()" class="btn btn-primary boton">Generar pdf</a>
</div>
<div class="col-sm-12">
    <div class="card mt-0 mb-3 border-0">
        <div class="card-body">
            <div class="logo_menu">
                <img class="logo" src="<?=base_url()?>img/gto_iplaneg.png" class="d-inline-block align-top" alt="iplaneg">
            </div> <!-- logo -->
            <div class="row mb-3">
                <div class="col-12 text-start">
                    <h5 class="text-center">Metaevaluación</h5>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12 text-end">
                    <p><?= date('d/m/Y', time())?></p>
                </div>
            </div>
            <div class="row mb-3 text-start">
                <p><strong>Arq. Graciela de la Luz Amaro Hernández<br>
                Directora General del Instituto de Planeación, Estadística y Geografía del Estado de Guanajuato</strong></p>

                <p>Le comento que se ha llevado a cabo la revisión del Informe final de la evaluación de <?=$valoracion_evaluacion['nom_tipo_evaluacion']?> aplicada al programa <?=$valoracion_evaluacion['nom_proyecto']?>, misma que fue realizada por <?=$valoracion_evaluacion['nom_evaluador']?>.</p>

                <p>A continuación, me permito darle a conocer la valoración de dicha evaluación. Para cada aspecto revisado se emite una calificación del 1 al 4, donde 1 es insuficiente, 2 aceptable, 3 bueno y 4 sobresaliente.</p>

                <div class="col-10 offset-1 mb-5">
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th colspan="2"><strong>Tabla de valoración de la evaluación</strong></th>
                            </tr>
                            <tr>
                                <th scope="col">Criterio</th>
                                <th class="text-center" scope="col">Calificación</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Informe técnico</td>
                                <td class="text-center"><?=$valoracion_evaluacion['informe']?></td>
                            </tr>
                            <tr>
                                <td>Antecedentes del Informe</td>
                                <td class="text-center"><?=$valoracion_evaluacion['antecedentes']?></td>
                            </tr>
                            <tr>
                                <td>Metodología confiable</td>
                                <td class="text-center"><?=$valoracion_evaluacion['metodologia']?></td>
                            </tr>
                            <tr>
                                <td>Información confiable</td>
                                <td class="text-center"><?=$valoracion_evaluacion['informacion']?></td>
                            </tr>
                            <tr>
                                <td>Análisis de resultados y datos</td>
                                <td class="text-center"><?=$valoracion_evaluacion['analisis']?></td>
                            </tr>
                            <tr>
                                <td>Conclusiones y recomendaciones justificadas y vinculantes</td>
                                <td class="text-center"><?=$valoracion_evaluacion['conclusiones']?></td>
                            </tr>
                            <tr>
                                <td>Acuerdos institucionales</td>
                                <td class="text-center"><?=$valoracion_evaluacion['acuerdos_institucionales']?></td>
                            </tr>
                            <tr>
                                <td>Acuerdos de confidencialidad</td>
                                <td class="text-center"><?=$valoracion_evaluacion['acuerdos_confidencialidad']?></td>
                            </tr>
                            <tr>
                                <td>Derechos y respeto</td>
                                <td class="text-center"><?=$valoracion_evaluacion['derechos']?></td>
                            </tr>
                            <tr>
                                <td>Orientación receptiva e inclusiva</td>
                                <td class="text-center"><?=$valoracion_evaluacion['orientacion']?></td>
                            </tr>
                            <tr>
                                <td>Autonomía</td>
                                <td class="text-center"><?=$valoracion_evaluacion['autonomia']?></td>
                            </tr>
                            <tr>
                                <td>Género</td>
                                <td class="text-center"><?=$valoracion_evaluacion['genero']?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Puntaje total</td>
                                <td class="text-center"><strong><?=$valoracion_evaluacion['puntaje_valoracion_evaluacion']?></strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>


                <p>Por lo anterior, se considera que el trabajo realizado por el proveedor tuvo el siguiente desempeño: <?= $valoracion ?></p>

                <p>Agradeciendo su apoyo y compromiso, le envío mis más cordiales saludos.</p>

            </div>
            <div class="col-12 text-center">
                <h5>Atentamente</h5>
                <br>
                <br>
                <br>
                <p>Elaboró: <?=$valoracion_evaluacion['elaborado']?></p>
                <p>Cargo: <?=$valoracion_evaluacion['cargo']?></p>
            </div>
        </div>
    </div>
</div>

<div class="col-sm-10 d-print-none">
    <hr />
    <a href="<?=base_url()?>valoracion/valoracion_evaluacion_detalle/<?= $valoracion_evaluacion['id_valoracion_evaluacion']?>" class="btn btn-secondary boton">Volver</a>
</div>
