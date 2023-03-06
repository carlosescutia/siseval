<div class="card mt-0 mb-3 mx-5 border-0 texto-menor">
    <div class="card-body">
        <h4>Oficio de solicitud de evaluaciones</h4>
        <p>Una vez cargada la propuesta de evaluaciones a realizar en 2023, favor de adjuntar el oficio mediante el que se hace la solicitud.</p>
        <p>Cargar un sólo documento en formato PDF incluyendo el oficio y el reporte de propuestas de evaluación.</p>
        <p>En caso de no solicitar evaluaciones para el ejercicio fiscal actual, de igual forma le solicitamos cargar el oficio de confirmación.</p>
        <p class="text-end">Máximo 9 MB.</p>
        <div class="mt-3">
            <?php 
            $nombre_archivo = 'oficio_' . $nom_dependencia . '.pdf';
            $nombre_archivo_fs = './oficios/' . $nombre_archivo;
            $nombre_archivo_url = base_url() . 'oficios/' . $nombre_archivo;
            if ( file_exists($nombre_archivo_fs) ) { ?>
            <a href="<?= $nombre_archivo_url ?>" target="_blank"><span class="mr-2"><img src="<?=base_url()?>img/application-pdf.svg" height="30"></span>Oficio cargado</a>
            <?php } ?>
        </div>
    </div>
    <div class="card-footer text-center">
        <form method="post" enctype="multipart/form-data" action="<?=base_url()?>archivos/oficio_dependencia">
            <div class="row text-danger">
                <?php if ($error) { 
                echo $error;
                } ?>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <input type="file" class="form-control-file" name="subir_archivo">
                </div>
                <div class="col-md-4 text-end">
                    <button type="submit" class="btn btn-primary btn-sm">Subir oficio</button>
                </div>
            </div>
            <input type="hidden" name="nombre_archivo" value="<?=$nombre_archivo?>">
        </form>
    </div>
</div>
