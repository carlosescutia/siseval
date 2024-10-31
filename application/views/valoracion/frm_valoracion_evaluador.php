<?php
    $puntaje_valoracion_evaluador = $valoracion_evaluador['puntaje_valoracion_evaluador'];
    switch(true) {
        case $puntaje_valoracion_evaluador == '':
            $valoracion = '';
            break;
        case $puntaje_valoracion_evaluador >= 0 and $puntaje_valoracion_evaluador <= 19:
            $valoracion = 'Mal desempeño';
            break;
        case $puntaje_valoracion_evaluador >= 20 and $puntaje_valoracion_evaluador <= 29:
            $valoracion = 'Desempeño bajo';
            break;
        case $puntaje_valoracion_evaluador >= 30 and $puntaje_valoracion_evaluador <= 39:
            $valoracion = 'Desempeño medio';
            break;
        case $puntaje_valoracion_evaluador >= 40 and $puntaje_valoracion_evaluador <= 49:
            $valoracion = 'Buen desempeño';
            break;
        case $puntaje_valoracion_evaluador == 50:
            $valoracion = 'Desempeño destacado';
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
                    <h5 class="text-center">Valoración del evaluador</h5>
                    <br>
                    <p>Nombre de la evaluación: <?=$valoracion_evaluador['cve_proyecto']?> - <?=$valoracion_evaluador['nom_proyecto']?></p>
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

                <p>Le comento que se ha llevado a cabo la revisión del Informe final de la evaluación <?=$valoracion_evaluador['nom_proyecto']?> aplicada al programa <?=$valoracion_evaluador['nom_programa']?>, misma que fue realizada por <?=$valoracion_evaluador['nom_evaluador']?>.</p>

                <p>A continuación, me permito darle a conocer la valoración del desempeño de la consultoría encargada de realizar este trabajo. Para cada aspecto revisado se emite una calificación del 1 al 10, donde 1 es un desempeño muy bajo y 10 es un desempeño destacado.</p>

                <div class="col-10 offset-1 mb-5">
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th colspan="2"><strong>Tabla de valoración del evaluador</strong></th>
                            </tr>
                            <tr>
                                <th scope="col">Criterio</th>
                                <th class="text-center" scope="col">Calificación</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Puntualidad en la entrega de los productos señalados en los Términos de Referencia</td>
                                <td class="text-center"><?=$valoracion_evaluador['puntualidad']?></td>
                            </tr>
                            <tr>
                                <td>Solidez técnica y coherencia metodológica</td>
                                <td class="text-center"><?=$valoracion_evaluador['solidez']?></td>
                            </tr>
                            <tr>
                                <td>Objetividad en las recomendaciones emitidas</td>
                                <td class="text-center"><?=$valoracion_evaluador['objetividad']?></td>
                            </tr>
                            <tr>
                                <td>Claridad y coherencia en la narrativa</td>
                                <td class="text-center"><?=$valoracion_evaluador['claridad']?></td>
                            </tr>
                            <tr>
                                <td>Disponibilidad para atención de requerimientos</td>
                                <td class="text-center"><?=$valoracion_evaluador['disponibilidad']?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Puntaje total</td>
                                <td class="text-center"><strong><?=$valoracion_evaluador['puntaje_valoracion_evaluador']?></strong></td>
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
                <p>Elaboró: <?=$valoracion_evaluador['elaborado']?></p>
                <p>Cargo: <?=$valoracion_evaluador['cargo']?></p>
            </div>
        </div>
    </div>
</div>

<div class="col-sm-10 d-print-none">
    <hr />
    <a href="<?=base_url()?>valoracion/valoracion_evaluador_detalle/<?= $valoracion_evaluador['id_valoracion_evaluador']?>" class="btn btn-secondary boton">Volver</a>
</div>

