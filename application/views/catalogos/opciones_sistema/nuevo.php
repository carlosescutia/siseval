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
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="cod_opcion" id="cod_opcion">
                </div>
            </div>
            <div class="form-group row">
                <label for="nom_opcion" class="col-sm-2 col-form-label">Nombre</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="nom_opcion" id="nom_opcion">
                </div>
            </div>
            <div class="form-group row">
                <label for="url" class="col-sm-2 col-form-label">Url</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="url" id="url">
                </div>
            </div>
            <div class="form-group row">
                <label for="es_menu" class="col-sm-2 col-form-label">Es menú?</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="es_menu" id="es_menu">
                </div>
            </div>
            <div class="form-group row">
                <label for="etapa" class="col-sm-2 col-form-label">Etapa Siseval</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="etapa" id="etapa">
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
