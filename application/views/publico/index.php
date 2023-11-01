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
                <div class="col-sm-3 fw-bold">
                    <p>TdR</p>
                </div>
            </div>
        </div>
        <?php 
        $prefijo = 'gtr';
        $icono = "bi-filetype-pdf";
        $tipo_archivo = 'pdf';
        $ruta = 'doc/';
        foreach ($proyectos as $proyectos_item) { 
            $nombre_archivo = $prefijo . '_' . strtolower($proyectos_item['cve_proyecto']) . '.' . $tipo_archivo ;
            $nombre_archivo_fs = './' . $ruta . $nombre_archivo ;
            $nombre_archivo_url = base_url() . $ruta . $nombre_archivo;
            if ( file_exists($nombre_archivo_fs) ) { ?>
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
                        <div class="col-sm-3">
                            <p><a href="<?=$nombre_archivo_url?>" target="_blank"><i class="bi <?=$icono?> documento-g"></i></a></p>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
    <hr />

</main>
