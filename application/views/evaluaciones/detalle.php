<main role="main" class="ml-sm-auto px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h2>Evaluación</h2>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped tabla-datos">
                <tbody>
                    <tr>
                        <td>Clave del proyecto</td>
                        <td><?= $evaluacion['cve_proyecto'] ?></td>
                    </tr>
                    <tr>
                        <td>Periodo</td>
                        <td><?= $evaluacion['periodo'] ?></td>
                    </tr>
                    <tr>
                        <td>Tipo de evaluación</td>
                        <td><?= $evaluacion['tipo_evaluacion'] ?></td>
                    </tr>
                    <tr>
                        <td>Fecha final del cronograma</td>
                        <td><?= $evaluacion['fecha_final_cronograma'] ?></td>
                    </tr>
                    <tr>
                        <td>Fecha final efectiva</td>
                        <td><?= $evaluacion['fecha_final_efectiva'] ?></td>
                    </tr>
                    <tr>
                        <td>¿Finalizó de acuerdo al cronograma?</td>
                        <td><?= $evaluacion['finalizo_cronograma'] ?></td>
                    </tr>
                    <tr>
                        <td>Método de financiamiento</td>
                        <td><?= $evaluacion['metodo_financiamiento'] ?></td>
                    </tr>
                    <tr>
                        <td>Evaluador</td>
                        <td><?= $evaluacion['nom_evaluador'] ?></td>
                    </tr>
                    <tr>
                        <td>Costo total de la evaluación</td>
                        <td>$ <?= number_format($evaluacion['costo_total_evaluacion'], 2) ?></td>
                    </tr>
                    <tr>
                        <td>Liga general del informe de evaluación</td>
                        <td><a href="<?= $evaluacion['liga_general_informe_evaluacion'] ?>" target="_blank"><?= $evaluacion['liga_general_informe_evaluacion'] ?></a></td>
                    </tr>
                    <tr>
                        <td>Liga directa del informe de evaluación</td>
                        <td><a href="<?= $evaluacion['liga_directa_informe_evaluacion'] ?>" target="_blank"><?= $evaluacion['liga_directa_informe_evaluacion'] ?></a></td>
                    </tr>
                    <tr>
                        <td>Origen AAE</td>
                        <td><?= $evaluacion['origen_aae'] ?></td>
                    </tr>
                    <tr>
                        <td>Documento probatorio del financiamiento</td>
                        <td><?= $evaluacion['documento_probatorio_financiamiento'] ?></td>
                    </tr>
                    <tr>
                        <td>Dependencia responsable</td>
                        <td><?= $evaluacion['dependencia_responsable'] ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <hr />
    <div class="form-group row">
        <div class="col-sm-10">
            <a href="<?=base_url()?>proyectos/detalle/<?=$proyecto['cve_proyecto']?>" class="btn btn-secondary">Volver</a>
        </div>
    </div>

</main>
