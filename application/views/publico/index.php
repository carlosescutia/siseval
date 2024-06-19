<main role="main" class="ml-sm-auto px-4">
    <div class="row">
        <div class="col-sm-12 mt-2">
            <div class="row">
                <div class="col-sm-1 fw-bold">
                    <p>Clave P/Q</p>
                </div>
                <div class="col-sm-4 fw-bold">
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
                <div class="col-sm-1 fw-bold text-center">
                    <p>TdR</p>
                </div>
                <div class="col-sm-1 fw-bold text-center">
                    <p>Informe</p>
                </div>
                <div class="col-sm-1 fw-bold text-center">
                    <p>Ficha Conac</p>
                </div>
            </div>
        </div>
        <?php 

        // terminos de referencia
        $doc1_prefijo = 'g';
        $doc1_tipo_doc = 'tr';
        $doc1_icono = "bi-filetype-pdf";
        $doc1_tipo_archivo = 'pdf';
        $doc1_dir = 'doc/';

        // Informe final
        $doc2_prefijo = 'e';
        $doc2_tipo_doc = 'if';
        $doc2_icono = "bi-filetype-pdf";
        $doc2_tipo_archivo = 'pdf';
        $doc2_dir = 'doc/';

        // ficha conac
        $doc3_prefijo = 'e';
        $doc3_tipo_doc = 'fc';
        $doc3_icono = "bi-filetype-pdf";
        $doc3_tipo_archivo = 'pdf';
        $doc3_dir = 'doc/';

        foreach ($proyectos as $proyectos_item) { 
            $doc1_nombre_archivo = $doc1_prefijo . $doc1_tipo_doc . '_' . strtolower($proyectos_item['cve_proyecto']) . $proyectos_item['abrev_tipo_evaluacion'] . '.' . $doc1_tipo_archivo ;
            $doc1_fs = './' . $doc1_dir . $doc1_nombre_archivo ;
            $doc1_url = base_url() . $doc1_dir . $doc1_nombre_archivo;

            $doc2_nombre_archivo = $doc2_prefijo . $doc2_tipo_doc . '_' . strtolower($proyectos_item['cve_proyecto']) . $proyectos_item['abrev_tipo_evaluacion'] . '.' . $doc2_tipo_archivo ;
            $doc2_fs = './' . $doc2_dir . $doc2_nombre_archivo ;
            $doc2_url = base_url() . $doc2_dir . $doc2_nombre_archivo;

            $doc3_nombre_archivo = $doc3_prefijo . $doc3_tipo_doc . '_' . strtolower($proyectos_item['cve_proyecto']) . $proyectos_item['abrev_tipo_evaluacion'] . '.' . $doc3_tipo_archivo ;
            $doc3_fs = './' . $doc3_dir . $doc3_nombre_archivo ;
            $doc3_url = base_url() . $doc3_dir . $doc3_nombre_archivo;

            if ( file_exists($doc1_fs) || file_exists($doc2_fs) || file_exists($doc3_fs) ) { ?>
                <div class="col-sm-12 alternate-color">
                    <div class="row">
                        <div class="col-sm-1">
                            <p><?= $proyectos_item['cve_proyecto'] ?></p>
                        </div>
                        <div class="col-sm-4">
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
                        <div class="col-sm-1 text-center">
                            <?php if ( file_exists($doc1_fs) )  { ?>
                                <p><a href="<?= $doc1_url ?>" target="_blank"><i class="bi <?= $doc1_icono ?> documento-g"></i></a></p>
                            <?php } ?>
                        </div>
                        <div class="col-sm-1 text-center">
                            <?php if ( file_exists($doc2_fs) )  { ?>
                                <p><a href="<?= $doc2_url ?>" target="_blank"><i class="bi <?= $doc2_icono ?> documento-g"></i></a></p>
                            <?php } ?>
                        </div>
                        <div class="col-sm-1 text-center">
                            <?php if ( file_exists($doc3_fs) )  { ?>
                                <p><a href="<?= $doc3_url ?>" target="_blank"><i class="bi <?= $doc3_icono ?> documento-g"></i></a></p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
    <hr />
    <p><?= $links ?></p>

</main>
