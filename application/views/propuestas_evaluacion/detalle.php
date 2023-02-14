<main role="main" class="ml-sm-auto px-4">
    <?php include 'datos_propuesta_evaluacion.php' ?>

    <?php if ($cve_rol !== 'usr') { ?>
        <?php include 'calificaciones_propuesta.php' ?>
    <?php } ?>

    <hr />
    <div class="form-group row">
        <div class="col-sm-10">
            <a href="<?=base_url()?>proyectos/detalle/<?=$propuesta_evaluacion['cve_proyecto']?>" class="btn btn-secondary boton">Volver</a>
        </div>
    </div>

</main>
