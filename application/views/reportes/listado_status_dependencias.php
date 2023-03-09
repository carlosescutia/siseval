<main role="main" class="ml-sm-auto px-4 mb-3 col-print-12">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div class="col-sm-12 alternate-color">
            <form method="post" action="<?= base_url() ?>reportes/listado_status_dependencias">
                <div class="row">
                    <div class="col-sm-8 text-start">
                        <h1 class="h2">Estatus de dependencias</h1>
                    </div>
                    <div class="col-sm-4 text-end d-print-none">
                        <button formaction="<?= base_url() ?>reportes/listado_status_dependencias_csv" class="btn btn-primary">Exportar a excel</button>
                        <a href="javascript:window.print()" class="btn btn-primary boton">Generar pdf</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 align-self-center">
                        <div class="row">
                            <div class="col-3">
                                <select class="form-select form-select-sm" name="evaluaciones">
                                    <option value="" <?= ($evaluaciones == '') ? 'selected' : '' ?>>Con y sin solicitud de evaluación</option>
                                    <option value="1" <?= ($evaluaciones == '1') ? 'selected' : '' ?>>Con solicitud de evaluación</option>
                                    <option value="0" <?= ($evaluaciones == '0') ? 'selected' : '' ?>>Sin solicitud de evaluación</option>
                                </select>
                            </div>
                            <div class="col-3">
                                <select class="form-select form-select-sm" name="propuestas">
                                    <option value="" <?= ($propuestas == '') ? 'selected' : '' ?>>Con y sin propuestas de evaluación</option>
                                    <option value="1" <?= ($propuestas == '1') ? 'selected' : '' ?>>Con propuestas de evaluación</option>
                                    <option value="0" <?= ($propuestas == '0') ? 'selected' : '' ?>>Sin propuestas de evaluación</option>
                                </select>
                            </div>
                            <div class="col-1 d-print-none">
                                <button class="btn btn-success btn-sm">Filtrar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div style="min-height: 46vh">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th scope="col">Siglas</th>
                            <th scope="col">Nombre Dependencia</th>
                            <th scope="col">¿Solicita evaluaciones?</th>
                            <th scope="col">Propuestas</th>
                            <th scope="col">Oficio</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($status_dependencias as $status_dependencias_item) { ?>
                        <tr>
                            <td><?= $status_dependencias_item['nom_dependencia'] ?></td>
                            <td><?= $status_dependencias_item['nom_completo_dependencia'] ?></td>
                            <td class="text-center"><?= $status_dependencias_item['solicita_evaluaciones'] ?></td>
                            <td class="text-center"><?= $status_dependencias_item['num_propuestas'] ?></td>
                            <td>
                            <?php 
                            $nombre_archivo = 'oficio_' . $status_dependencias_item['nom_dependencia'] . '.pdf';
                            $nombre_archivo_fs = './oficios/' . $nombre_archivo;
                            $nombre_archivo_url = base_url() . 'oficios/' . $nombre_archivo;
                            if ( file_exists($nombre_archivo_fs) ) { ?>
                                <a href="<?= $nombre_archivo_url ?>" target="_blank"><span class="mr-2"><img src="<?=base_url()?>img/application-pdf.svg" height="20"></span><span class="d-print-none">Ver</span></a>
                            <?php } ?>
                            </td>

                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</main>
