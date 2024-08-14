<main role="main" class="ml-sm-auto px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div class="col-sm-1">
            <img class="logo" src="<?=base_url()?>img/gto_iplaneg.png" class="d-inline-block align-top" alt="iplaneg">
        </div>
        <div class="col-sm-10 offset-sm-1">
            <h2>Documento de opinión de recomendaciones</h2>
        </div>
    </div>
    <div class="row mb-5">
        <div class="col-md-6 offset-md-1">
            <?php include 'datos_documento_opinion.php' ?>
        </div>
        <div class="col-md-4">
            <?php include 'valoracion_documento_opinion.php' ?>
        </div>
    </div>

    <hr />

    <div class="row mb-3">
        <div class="col-md-10 offset-md-1">
            <?php include 'recomendaciones.php' ?>
        </div>
    </div>

    <?php
        $permisos_requeridos = array(
        'documento_opinion.can_edit',
        'valoracion.etapa_actual',
        );
    ?>
    <?php if (has_permission_and($permisos_requeridos, $permisos_usuario)) { ?>
        <?php if ($documento_opinion['status'] == 2) { ?>
            <div class="row">
                <div class="col-md-10 d-print-none">
                    <a href="<?=base_url()?>valoracion/recomendaciones_nuevo/<?=$documento_opinion['cve_documento_opinion']?>" class="btn btn-primary">Nueva recomendación</a>
                </div>
            </div>
        <?php } ?>
    <?php } ?>

    <div class="row mt-3">
        <div class="col-md-10 offset-md-1 text-center d-none d-print-block">
            <h5>Nombre y firma del titular de la dependencia responsable</h5>
            <br />
            <br />
            <br />
            <br />
            <br />
            <br />
            <h5>Nombre y firma del enlace de evaluación de la dependencia responsable</h5>
        </div>
    </div>

    <hr />
    <div class="form-group row">
        <div class="col-sm-10 d-print-none">
            <a href="<?=base_url()?>valoracion" class="btn btn-secondary boton">Volver</a>
        </div>
    </div>

</main>
