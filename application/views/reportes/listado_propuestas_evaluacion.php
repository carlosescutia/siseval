<main role="main" class="ml-sm-auto px-4 mb-3 col-print-12">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div class="col-sm-12 alternate-color">
            <div class="row">
                <div class="col-sm-8 text-start">
                    <h1 class="h2">Propuestas de evaluación</h1>
                </div>
                <div class="col-sm-4 text-end d-print-none">
                    <form method="post" action="<?= base_url() ?>reportes/listado_propuestas_evaluacion">
                        <button type="submit" class="btn btn-primary">Exportar a excel</button>
                        <a href="javascript:window.print()" class="btn btn-primary boton">Generar pdf</a>
                        <input type="hidden" name="salida" value="csv">
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
                            <th scope="col">Dependencia</th>
                            <th scope="col">Clave PP</th>
                            <th scope="col">Nombre PP</th>
                            <th scope="col">Clave P/Q</th>
                            <th scope="col">Nombre P/Q</th>
                            <th scope="col">Tipo de evaluación</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($propuestas_evaluacion as $propuestas_evaluacion_item) { ?>
                        <tr>
                            <td><?= $propuestas_evaluacion_item['nom_dependencia'] ?></td>
                            <td><?= $propuestas_evaluacion_item['cve_programa'] ?></td>
                            <td><?= $propuestas_evaluacion_item['nom_programa'] ?></td>
                            <td><?= $propuestas_evaluacion_item['cve_proyecto'] ?></td>
                            <td><?= $propuestas_evaluacion_item['nom_proyecto'] ?></td>
                            <td><?= $propuestas_evaluacion_item['nom_tipo_evaluacion'] ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</main>
