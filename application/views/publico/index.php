<main role="main" class="ml-sm-auto px-4">
    <div class="col-sm-12 mt-2">
        <div class="row">
            <div class="col-sm-1 fw-bold">
                <p>Clave P/Q</p>
            </div>
            <div class="col-sm-2 fw-bold">
                <p>Evaluación</p>
            </div>
            <div class="col-sm-1 fw-bold">
                <p>Año</p>
            </div>
            <div class="col-sm-1 fw-bold">
                <p>Tipo</p>
            </div>
            <div class="col-sm-1 fw-bold">
                <p>Responsable</p>
            </div>
            <div class="col-sm-1 fw-bold">
                <p>Status</p>
            </div>
            <div class="col-sm-1 fw-bold text-center">
                <p>TdR</p>
            </div>
            <div class="col-sm-1 fw-bold text-center">
                <p>Informe</p>
            </div>
            <div class="col-sm-1 fw-bold text-center">
                <p>Ficha Conac</p>
            </div>
            <div class="col-sm-1 fw-bold text-center">
                <p>Doc. Op.</p>
            </div>
            <div class="col-sm-1 fw-bold text-center">
                <p>Plan acc.</p>
            </div>
        </div>
        <?php
            $tipo_archivo = 'pdf';
            $dir_docs = './doc/';
            $icono = "bi-filetype-pdf";
        ?>

        <?php foreach ($proyectos as $proyectos_item) { ?>
            <div class="col-sm-12 alternate-color">
                <div class="row">
                    <div class="col-sm-1">
                        <p><?= $proyectos_item['cve_proyecto'] ?></p>
                    </div>
                    <div class="col-sm-2">
                        <p> <?= $proyectos_item['nom_proyecto'] ?> </p>
                    </div>
                    <div class="col-sm-1">
                        <p><?= $proyectos_item['periodo'] ?></p>
                    </div>
                    <div class="col-sm-1">
                        <p><?= $proyectos_item['nom_tipo_evaluacion'] ?></p>
                    </div>
                    <div class="col-sm-1">
                        <p><?= $proyectos_item['nom_dependencia'] ?></p>
                    </div>
                    <div class="col-sm-1">
                        <p><?= $proyectos_item['status'] ?></p>
                    </div>
                    <?php if ( $proyectos_item['status'] !== 'cancelado' ) { ?>
                        <?php
                            // Términos de referencia
                            $prefijo = 'tr' ;
                            $nombre_archivo = $prefijo . '_' . $proyectos_item['id_propuesta_evaluacion'] . '.' . $tipo_archivo;
                            $nombre_archivo_fs = $dir_docs . $nombre_archivo;
                            $nombre_archivo_url = base_url() . $dir_docs . $nombre_archivo;
                        ?>
                        <div class="col-sm-1 text-center">
                            <?php if ( file_exists($nombre_archivo_fs) )  { ?>
                                <p><a href="<?= $nombre_archivo_url ?>" target="_blank"><i class="bi <?= $icono ?> documento-g"></i></a></p>
                            <?php } ?>
                        </div>

                        <?php
                            // Informe final
                            $prefijo = 'if' ;
                            $nombre_archivo = $prefijo . '_' . $proyectos_item['id_propuesta_evaluacion'] . '.' . $tipo_archivo;
                            $nombre_archivo_fs = $dir_docs . $nombre_archivo;
                            $nombre_archivo_url = base_url() . $dir_docs . $nombre_archivo;
                        ?>
                        <div class="col-sm-1 text-center">
                            <?php if ( file_exists($nombre_archivo_fs) )  { ?>
                                <p><a href="<?= $nombre_archivo_url ?>" target="_blank"><i class="bi <?= $icono ?> documento-g"></i></a></p>
                            <?php } ?>
                        </div>

                        <?php
                            // Ficha Conac
                            $prefijo = 'fc' ;
                            $nombre_archivo = $prefijo . '_' . $proyectos_item['id_propuesta_evaluacion'] . '.' . $tipo_archivo;
                            $nombre_archivo_fs = $dir_docs . $nombre_archivo;
                            $nombre_archivo_url = base_url() . $dir_docs . $nombre_archivo;
                        ?>
                        <div class="col-sm-1 text-center">
                            <?php if ( file_exists($nombre_archivo_fs) )  { ?>
                                <p><a href="<?= $nombre_archivo_url ?>" target="_blank"><i class="bi <?= $icono ?> documento-g"></i></a></p>
                            <?php } ?>
                        </div>

                        <?php
                            // Documento de opinión
                            $prefijo = 'doc_op' ;
                            $nombre_archivo = $prefijo . '_' . $proyectos_item['cve_documento_opinion'] . '.' . $tipo_archivo;
                            $nombre_archivo_fs = $dir_docs . $nombre_archivo;
                            $nombre_archivo_url = base_url() . $dir_docs . $nombre_archivo;
                        ?>
                        <div class="col-sm-1 text-center">
                            <?php if ( file_exists($nombre_archivo_fs) )  { ?>
                                <p><a href="<?= $nombre_archivo_url ?>" target="_blank"><i class="bi <?= $icono ?> documento-g"></i></a></p>
                            <?php } ?>
                        </div>

                        <?php
                            // Plan de acción
                            $prefijo = 'plan_ac' ;
                            $nombre_archivo = $prefijo . '_' . $proyectos_item['id_plan_accion'] . '.' . $tipo_archivo;
                            $nombre_archivo_fs = $dir_docs . $nombre_archivo;
                            $nombre_archivo_url = base_url() . $dir_docs . $nombre_archivo;
                        ?>
                        <div class="col-sm-1 text-center">
                            <?php if ( file_exists($nombre_archivo_fs) )  { ?>
                                <p><a href="<?= $nombre_archivo_url ?>" target="_blank"><i class="bi <?= $icono ?> documento-g"></i></a></p>
                            <?php } ?>
                        </div>

                    <?php } ?>
                </div>
            </div>
        <?php } ?>

    </div>

    <hr />

    <p><?= $links ?></p>

</main>
