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
            // archivos para publicación
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

            // documento de opinión
            $doc4_prefijo = '';
            $doc4_tipo_doc = 'doc_op';
            $doc4_icono = "bi-filetype-pdf";
            $doc4_tipo_archivo = 'pdf';
            $doc4_dir = 'doc/';

            // plan de acción
            $doc5_prefijo = '';
            $doc5_tipo_doc = 'plan_ac';
            $doc5_icono = "bi-filetype-pdf";
            $doc5_tipo_archivo = 'pdf';
            $doc5_dir = 'doc/';


            // archivos para determinar status
            // contrato
            $doc6_prefijo = 'g';
            $doc6_tipo_doc = 'ct';
            $doc6_tipo_archivo = 'pdf';
            $doc6_dir = 'doc/';

            // oficio de notificacion
            $doc7_prefijo = 'g';
            $doc7_tipo_doc = 'je';
            $doc7_tipo_archivo = 'pdf';
            $doc7_dir = 'doc/';

            // cancelacion
            $doc8_prefijo = 'cancel';
            $doc8_tipo_archivo = 'pdf';
            $doc8_dir = 'doc/';
        ?>

        <?php foreach ($proyectos as $proyectos_item) { 
            $doc1_nombre_archivo = $doc1_prefijo . $doc1_tipo_doc . '_' . strtolower($proyectos_item['cve_proyecto']) . $proyectos_item['abrev_tipo_evaluacion'] . '.' . $doc1_tipo_archivo ;
            $doc1_fs = './' . $doc1_dir . $doc1_nombre_archivo ;
            $doc1_url = base_url() . $doc1_dir . $doc1_nombre_archivo;

            $doc2_nombre_archivo = $doc2_prefijo . $doc2_tipo_doc . '_' . strtolower($proyectos_item['cve_proyecto']) . $proyectos_item['abrev_tipo_evaluacion'] . '.' . $doc2_tipo_archivo ;
            $doc2_fs = './' . $doc2_dir . $doc2_nombre_archivo ;
            $doc2_url = base_url() . $doc2_dir . $doc2_nombre_archivo;

            $doc3_nombre_archivo = $doc3_prefijo . $doc3_tipo_doc . '_' . strtolower($proyectos_item['cve_proyecto']) . $proyectos_item['abrev_tipo_evaluacion'] . '.' . $doc3_tipo_archivo ;
            $doc3_fs = './' . $doc3_dir . $doc3_nombre_archivo ;
            $doc3_url = base_url() . $doc3_dir . $doc3_nombre_archivo;

            $doc4_nombre_archivo = $doc4_prefijo . $doc4_tipo_doc . '_' . strtolower($proyectos_item['cve_documento_opinion']) . '.' . $doc4_tipo_archivo ;
            $doc4_fs = './' . $doc4_dir . $doc4_nombre_archivo ;
            $doc4_url = base_url() . $doc4_dir . $doc4_nombre_archivo;

            $doc5_nombre_archivo = $doc5_prefijo . $doc5_tipo_doc . '_' . strtolower($proyectos_item['id_plan_accion']) . '.' . $doc5_tipo_archivo ;
            $doc5_fs = './' . $doc5_dir . $doc5_nombre_archivo ;
            $doc5_url = base_url() . $doc5_dir . $doc5_nombre_archivo; 

            $doc6_nombre_archivo = $doc6_prefijo . $doc6_tipo_doc . '_' . strtolower($proyectos_item['cve_proyecto']) . $proyectos_item['abrev_tipo_evaluacion'] . '.' . $doc6_tipo_archivo ;
            $doc6_fs = './' . $doc6_dir . $doc6_nombre_archivo ;
            $doc6_url = base_url() . $doc6_dir . $doc6_nombre_archivo; 

            $doc7_nombre_archivo = $doc7_prefijo . $doc7_tipo_doc . '_' . strtolower($proyectos_item['cve_proyecto']) . $proyectos_item['abrev_tipo_evaluacion'] . '.' . $doc7_tipo_archivo ;
            $doc7_fs = './' . $doc7_dir . $doc7_nombre_archivo ;
            $doc7_url = base_url() . $doc7_dir . $doc7_nombre_archivo; 

            $doc8_nombre_archivo = $doc8_prefijo . '_' . $proyectos_item['id_propuesta_evaluacion'] . '.' . $doc8_tipo_archivo ;
            $doc8_fs = './' . $doc8_dir . $doc8_nombre_archivo ;
            $doc8_url = base_url() . $doc8_dir . $doc8_nombre_archivo; 

            $status = 'Por iniciar';
            if ( file_exists($doc6_fs) or file_exists($doc7_fs) ) {
                $status = 'En proceso' ;
            }
            if ( file_exists($doc2_fs) ) {
                $status = 'Concluído' ;
            }
            if ( file_exists($doc8_fs) ) {
                $status = 'Cancelado' ;
            } 
            ?>

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
                        <p><?= $status ?></p>
                    </div>
                    <?php if ( ! file_exists($doc8_fs) ) { ?>
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
                        <div class="col-sm-1 text-center">
                            <?php if ( file_exists($doc4_fs) )  { ?>
                                <p><a href="<?= $doc4_url ?>" target="_blank"><i class="bi <?= $doc4_icono ?> documento-g"></i></a></p>
                            <?php } ?>
                        </div>
                        <div class="col-sm-1 text-center">
                            <?php if ( file_exists($doc5_fs) )  { ?>
                                <p><a href="<?= $doc5_url ?>" target="_blank"><i class="bi <?= $doc5_icono ?> documento-g"></i></a></p>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    <hr />
    <p><?= $links ?></p>

</main>
