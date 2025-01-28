<main role="main" class="ml-sm-auto px-4 mb-3 col-print-12">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div class="col-sm-12 alternate-color">
            <div class="row">
                <div class="col-sm-8 text-start">
                    <h1 class="h2">Directorio de evaluadores</h1>
                </div>
                <div class="col-sm-4 text-end d-print-none">
                    <form method="post">
                        <button formaction="<?= base_url() ?>reportes/listado_evaluadores/csv" class="btn btn-primary">Exportar a excel</button>
                        <a href="javascript:window.print()" class="btn btn-primary boton">Generar pdf</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div style="min-height: 46vh">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th scope="col" class="align-self-center">Número de proveedor</th>
                            <th scope="col" class="align-self-center">Nombre</th>
                            <th scope="col" class="align-self-center">Observaciones</th>
                            <th scope="col" class="align-self-center text-center">Evaluaciones</th>
                            <th scope="col" class="align-self-center text-center">Puntaje promedio</th>
                            <th scope="col" class="align-self-center">Valoración</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($evaluadores as $evaluadores_item) { ?>
                            <?php
                                $puntaje_valoracion_evaluador = $evaluadores_item['promedio'];
                                switch(true) {
                                    case $puntaje_valoracion_evaluador >= 0 and $puntaje_valoracion_evaluador <= 19:
                                        $valoracion_evaluador = 'Mal desempeño';
                                        break;
                                    case $puntaje_valoracion_evaluador >= 20 and $puntaje_valoracion_evaluador <= 29:
                                        $valoracion_evaluador = 'Desempeño bajo';
                                        break;
                                    case $puntaje_valoracion_evaluador >= 30 and $puntaje_valoracion_evaluador <= 39:
                                        $valoracion_evaluador = 'Desempeño medio';
                                        break;
                                    case $puntaje_valoracion_evaluador >= 40 and $puntaje_valoracion_evaluador <= 49:
                                        $valoracion_evaluador = 'Buen desempeño';
                                        break;
                                    case $puntaje_valoracion_evaluador = 50:
                                        $valoracion_evaluador = 'Desempeño destacado';
                                        break;
                                    default:
                                        $valoracion_evaluador = '';
                                        break;
                                }
                            ?>
                        <tr>
                            <td><?= $evaluadores_item['id_evaluador'] ?></td>
                            <td><?= $evaluadores_item['nom_evaluador'] ?></td>
                            <td><?= $evaluadores_item['observaciones'] ?></td>
                            <td class="text-center"><?= $evaluadores_item['num_evaluaciones'] ?></td>
                            <td class="text-center"><?= $evaluadores_item['promedio'] ?></td>
                            <td><?= $valoracion_evaluador ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</main>

