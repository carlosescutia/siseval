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
                <div class="col-sm-1 fw-bold">
                    <p>TdR</p>
                </div>
                <div class="col-sm-1 fw-bold">
                    <p>Informe</p>
                </div>
            </div>
        </div>
        <?php 

        // archivo etapa 1
        $etapa_e1 = 'g';
        $tipo_doc_e1 = 'tr';
        $icono_e1 = "bi-filetype-pdf";
        $tipo_archivo_e1 = 'pdf';
        $dir_docs_e1 = 'doc/';

        // archivo etapa 2
        $etapa_e2 = 'e';
        $tipo_doc_e2 = 'if';
        $icono_e2 = "bi-filetype-pdf";
        $tipo_archivo_e2 = 'pdf';
        $dir_docs_e2 = 'doc/';

        foreach ($proyectos as $proyectos_item) { 
            $nombre_archivo_e1 = $etapa_e1 . $tipo_doc_e1 . '_' . strtolower($proyectos_item['cve_proyecto']) . $proyectos_item['abrev_tipo_evaluacion'] . '.' . $tipo_archivo_e1 ;
            $nombre_archivo_e1_fs = './' . $dir_docs_e1 . $nombre_archivo_e1 ;
            $nombre_archivo_e1_url = base_url() . $dir_docs_e1 . $nombre_archivo_e1;

            $nombre_archivo_e2 = $etapa_e2 . $tipo_doc_e2 . '_' . strtolower($proyectos_item['cve_proyecto']) . $proyectos_item['abrev_tipo_evaluacion'] . '.' . $tipo_archivo_e2 ;
            $nombre_archivo_e2_fs = './' . $dir_docs_e2 . $nombre_archivo_e2 ;
            $nombre_archivo_e2_url = base_url() . $dir_docs_e2 . $nombre_archivo_e2;

            if ( file_exists($nombre_archivo_e1_fs) || file_exists($nombre_archivo_e2_fs) ) { ?>
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
                        <div class="col-sm-1">
                            <?php if ( file_exists($nombre_archivo_e1_fs) )  { ?>
                                <p><a href="<?=$nombre_archivo_e1_url?>" target="_blank"><i class="bi <?=$icono_e1?> documento-g"></i></a></p>
                            <?php } ?>
                        </div>
                        <div class="col-sm-1">
                            <?php if ( file_exists($nombre_archivo_e2_fs) )  { ?>
                                <p><a href="<?=$nombre_archivo_e2_url?>" target="_blank"><i class="bi <?=$icono_e2?> documento-g"></i></a></p>
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
