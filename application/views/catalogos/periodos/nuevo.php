<main role="main" class="ml-sm-auto px-4">

    <form method="post" action="<?= base_url() ?>periodos/guardar">

        <div class="col-md-12 mb-3 pb-2 pt-3 border-bottom">
            <div class="row">
                <div class="col-md-10">
                    <h1 class="h2">Nuevo periodo</h1>
                </div>
                <div class="col-md-2 text-end">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group row">
                <label for="nom_periodo" class="col-sm-2 col-form-label">Periodo</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="nom_periodo" id="nom_periodo">
                </div>
            </div>
            <div class="form-group row">
                <label for="num_supervisores" class="col-sm-2 col-form-label">Número de supervisores</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="num_supervisores" id="num_supervisores">
                </div>
            </div>
        </div>

    </form>


    <hr />

    <div class="form-group row">
        <div class="col-sm-10">
            <a href="<?=base_url()?>periodos" class="btn btn-secondary boton">Volver</a>
        </div>
    </div>

</main>
