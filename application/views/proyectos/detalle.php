<main role="main" class="ml-sm-auto px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h2><?= $proyecto['cve_proyecto'] ?> <?= $proyecto['nom_proyecto'] ?></h2>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php include 'datos_proyecto.php' ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?php include 'evaluacion_actual.php' ?>
        </div>
        <div class="col-md-6">
            <?php include 'historico_evaluaciones.php' ?>
        </div>
    </div>

    <hr />
    <div class="form-group row">
        <div class="col-sm-10">
            <a href="<?=base_url()?>proyectos" class="btn btn-secondary">Volver</a>
        </div>
    </div>

</main>
