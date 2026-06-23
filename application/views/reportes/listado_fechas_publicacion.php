<main role="main" class="ml-sm-auto px-4 mb-3 col-print-12">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div class="col-sm-12 alternate-color">
            <div class="row">
                <div class="col-sm-8 text-start">
                    <h1 class="h2">Fechas de publicación</h1>
                </div>
            </div>
        </div>
    </div>

    <div style="min-height: 46vh">
        <div class="row">
            <div class="col-md-12">
                <table id="tbl_publico" class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th scope="col">Clave PP</th>
                            <th scope="col">Clave P/Q</th>
                            <th scope="col">Evaluación</th>
                            <th scope="col">Año</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Responsable</th>
                            <th scope="col" class="text-center" data-orderable="false">Informe final</th>
                            <th scope="col" class="text-center" data-orderable="false">Ficha Conac</th>
                            <th scope="col" class="text-center" data-orderable="false">Doc. Op.</th>
                            <th scope="col" class="text-center" data-orderable="false">Plan acc.</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $tipo_archivo = 'pdf';
                            $dir_docs = 'doc/';
                            $icono = "bi-filetype-pdf";
                            $fmt = datefmt_create(
                                'es_MX',
                                IntlDateFormatter::NONE,
                                IntlDateFormatter::NONE,
                                null,
                                IntlDateFormatter::GREGORIAN,
                                'dd/MM/yy'
                            );
                        ?>
                        <?php foreach ($proyectos as $proyectos_item) { ?>
                        <tr>
                            <td><?= $proyectos_item['cve_programa'] ?></td>
                            <td><?= $proyectos_item['cve_proyecto'] ?></td>
                            <td><?= $proyectos_item['nom_proyecto'] ?></td>
                            <td class="text-center"><?= $proyectos_item['periodo'] ?></td>
                            <td><?= $proyectos_item['nom_tipo_evaluacion'] ?></td>
                            <td><?= $proyectos_item['nom_dependencia'] ?></td>
                            <td>
                                <?php
                                    // Informe final
                                    $prefijo = 'if' ;
                                    $nombre_archivo = $prefijo . '_' . $proyectos_item['id_propuesta_evaluacion'] . '.' . $tipo_archivo;
                                    $nombre_archivo_fs = $dir_docs . $nombre_archivo;
                                    $nombre_archivo_url = base_url() . $dir_docs . $nombre_archivo;
                                ?>
                                <?php if ( file_exists($nombre_archivo_fs) ):
                                    $fecha = filemtime($nombre_archivo_fs);
                                ?>
                                    <?= datefmt_format($fmt, $fecha) ?>
                                <?php endif ?>
                            </td>
                            <td>
                                <?php
                                    // Ficha conac
                                    $prefijo = 'fc' ;
                                    $nombre_archivo = $prefijo . '_' . $proyectos_item['id_propuesta_evaluacion'] . '.' . $tipo_archivo;
                                    $nombre_archivo_fs = $dir_docs . $nombre_archivo;
                                    $nombre_archivo_url = base_url() . $dir_docs . $nombre_archivo;
                                ?>
                                <?php if ( file_exists($nombre_archivo_fs) ):
                                    $fecha = filemtime($nombre_archivo_fs);
                                ?>
                                    <?= datefmt_format($fmt, $fecha) ?>
                                <?php endif ?>
                            </td>
                            <td>
                                <?php
                                    // Documento de opinion
                                    $prefijo = 'doc_op' ;
                                    $nombre_archivo = $prefijo . '_' . $proyectos_item['id_propuesta_evaluacion'] . '.' . $tipo_archivo;
                                    $nombre_archivo_fs = $dir_docs . $nombre_archivo;
                                    $nombre_archivo_url = base_url() . $dir_docs . $nombre_archivo;
                                ?>
                                <?php if ( file_exists($nombre_archivo_fs) ):
                                    $fecha = filemtime($nombre_archivo_fs);
                                ?>
                                    <?= datefmt_format($fmt, $fecha) ?>
                                <?php endif ?>
                            </td>
                            <td>
                                <?php
                                    // Plan de acción
                                    $prefijo = 'plan_ac' ;
                                    $nombre_archivo = $prefijo . '_' . $proyectos_item['id_propuesta_evaluacion'] . '.' . $tipo_archivo;
                                    $nombre_archivo_fs = $dir_docs . $nombre_archivo;
                                    $nombre_archivo_url = base_url() . $dir_docs . $nombre_archivo;
                                ?>
                                <?php if ( file_exists($nombre_archivo_fs) ):
                                    $fecha = filemtime($nombre_archivo_fs);
                                ?>
                                    <?= datefmt_format($fmt, $fecha) ?>
                                <?php endif ?>
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</main>

