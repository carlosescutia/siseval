<main role="main" class="ml-sm-auto px-4">

    <form method="post" action="<?= base_url() ?>tipos_evaluacion/guardar">

        <div class="col-md-12 mb-3 pb-2 pt-3 border-bottom">
            <div class="row">
                <div class="col-md-10">
                    <h1 class="h2">Nuevo tipo de evaluación</h1>
                </div>
                <div class="col-md-2 text-end">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group row">
                <label for="nom_tipo_evaluacion" class="col-sm-2 col-form-label">Nombre</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="nom_tipo_evaluacion" id="nom_tipo_evaluacion">
                </div>
            </div>
            <div class="form-group row">
                <label for="orden" class="col-sm-2 col-form-label">Orden</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" name="orden" id="orden">
                </div>
            </div>
        </div>

    </form>


    <hr />

    <div class="form-group row">
        <div class="col-sm-10">
            <a href="<?=base_url()?>tipos_evaluacion" class="btn btn-secondary boton">Volver</a>
        </div>
    </div>

</main>
