<main role="main" class="ml-sm-auto px-4">

    <form method="post" action="<?= base_url() ?>probabilidades_inclusion/guardar/<?= $probabilidad_inclusion['id_probabilidad_inclusion'] ?>">

        <div class="col-md-12 mb-3 pb-2 pt-3 border-bottom">
            <div class="row">
                <div class="col-md-10">
                    <h1 class="h2">Editar probabilidad de inclusión</h1>
                </div>
                <div class="col-md-2 text-end">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group row">
                <label for="id_probabilidad_inclusion" class="col-sm-2 col-form-label">Clave</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="id_probabilidad_inclusion" id="id_probabilidad_inclusion" value="<?=$probabilidad_inclusion['id_probabilidad_inclusion'] ?>" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="nom_probabilidad_inclusion" class="col-sm-2 col-form-label">Probabilidad</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="nom_probabilidad_inclusion" id="nom_probabilidad_inclusion" value="<?=$probabilidad_inclusion['nom_probabilidad_inclusion'] ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="min" class="col-sm-2 col-form-label">Min</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="min" id="min" value="<?=$probabilidad_inclusion['min'] ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="max" class="col-sm-2 col-form-label">Max</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="max" id="max" value="<?=$probabilidad_inclusion['max'] ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="orden" class="col-sm-2 col-form-label">Orden</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="orden" id="orden" value="<?=$probabilidad_inclusion['orden'] ?>">
                </div>
            </div>
        </div>

    </form>

    <hr />

    <div class="form-group row">
        <div class="col-sm-10">
            <a href="<?=base_url()?>probabilidades_inclusion" class="btn btn-secondary boton">Volver</a>
        </div>
    </div>

</main>
