<main role="main" class="ml-sm-auto px-4">

    <form method="post" action="<?= base_url() ?>evaluadores/guardar">

        <div class="col-md-12 mb-3 pb-2 pt-3 border-bottom">
            <div class="row">
                <div class="col-md-10">
                    <h1 class="h2">Nuevo evaluador</h1>
                </div>
                <div class="col-md-2 text-end">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group row">
                <label for="id_evaluador" class="col-sm-2 col-form-label">Número de proveedor</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="id_evaluador" id="id_evaluador" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="nom_evaluador" class="col-sm-2 col-form-label">Nombre</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="nom_evaluador" id="nom_evaluador" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="observaciones" class="col-sm-2 col-form-label">Observaciones</label>
                <div class="col-sm-10">
                    <textarea rows="4" class="form-control" name="observaciones" id="observaciones"></textarea>
                </div>
            </div>
        </div>

    </form>


    <hr />

    <div class="form-group row">
        <div class="col-sm-10">
            <a href="<?=base_url()?>evaluadores" class="btn btn-secondary boton">Volver</a>
        </div>
    </div>

</main>
