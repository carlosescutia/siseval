<main role="main" class="ml-sm-auto px-4">

    <form method="post" action="<?= base_url() ?>opciones_sistema/guardar">

        <div class="col-md-12 mb-3 pb-2 pt-3 border-bottom">
            <div class="row">
                <div class="col-md-10">
                    <h1 class="h2">Nueva opción</h1>
                </div>
                <div class="col-md-2 text-end">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group row">
                <label for="cod_opcion" class="col-sm-2 col-form-label">Código</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="cod_opcion" id="cod_opcion" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="nom_opcion" class="col-sm-2 col-form-label">Nombre</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="nom_opcion" id="nom_opcion" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="otorgable" class="col-sm-2 col-form-label">Otorgable</label>
                <div class="col-sm-1">
                    <input type="text" class="form-control" name="otorgable" id="otorgable">
                </div>
            </div>
        </div>

    </form>


    <hr />

    <div class="form-group row">
        <div class="col-sm-10">
            <a href="<?=base_url()?>opciones_sistema" class="btn btn-secondary boton">Volver</a>
        </div>
    </div>

</main>
