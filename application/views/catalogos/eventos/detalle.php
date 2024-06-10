<main role="main" class="ml-sm-auto px-4">

    <form method="post" action="<?= base_url() ?>eventos/guardar/<?= $evento['id_evento'] ?>">

        <div class="col-md-12 mb-3 pb-2 pt-3 border-bottom">
            <div class="row">
                <div class="col-md-10">
                    <h1 class="h2">Editar evento</h1>
                </div>
                <div class="col-md-2 text-end">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group row">
                <label for="id_evento" class="col-sm-2 col-form-label">Clave</label>
                <div class="col-sm-1">
                    <input type="text" class="form-control" name="id_evento" id="id_evento" value="<?=$evento['id_evento'] ?>" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="fecha_evento" class="col-sm-2 col-form-label">Fecha</label>
                <div class="col-sm-2">
                    <input type="date" class="form-control" name="fecha_evento" id="fecha_evento" value="<?=$evento['fecha_evento'] ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="desc_evento" class="col-sm-2 col-form-label">Descripción</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="desc_evento" id="desc_evento" value="<?=$evento['desc_evento'] ?>">
                </div>
            </div>
        </div>

    </form>

    <hr />

    <div class="form-group row">
        <div class="col-sm-10">
            <a href="<?=base_url()?>eventos" class="btn btn-secondary boton">Volver</a>
        </div>
    </div>

</main>
