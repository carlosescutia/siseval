<main role="main" class="ml-sm-auto px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div class="col-sm-1">
            <img class="logo" src="<?=base_url()?>img/gto_iplaneg.png" class="d-inline-block align-top" alt="iplaneg">
        </div>
        <div class="col-sm-10 offset-sm-1">
            <h2>Plan de acción</h2>
        </div>
    </div>
    <div class="row mb-5">
        <div class="col-md-6 offset-md-1">
            <?php include 'datos_plan_accion.php' ?>
        </div>
        <div class="col-md-5">
            <div class="row">
                <div class="col-md-12">
                    <?php include 'valoracion_plan_accion.php' ?>
                </div>
                <div class="col-md-12">
                    <?php include 'pdf_plan_accion.php' ?>
                </div>
            </div>
        </div>
    </div>

    <hr />

    <div class="row mb-3">
        <div class="col-md-10 offset-md-1">
            <?php include 'recomendaciones_plan_accion.php' ?>
        </div>
    </div>

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
