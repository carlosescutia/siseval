<?php
    $permisos_usuario = $userdata['permisos_usuario'];
?>
<main role="main" class="ml-sm-auto px-4">

    <form method="post" action="<?= base_url() ?>periodos/guardar/<?= $periodo['id_periodo'] ?>">

        <div class="col-md-12 mb-3 pb-2 pt-3 border-bottom">
            <div class="row">
                <div class="col-md-10">
                    <h1 class="h2">Editar periodo</h1>
                </div>
                <div class="col-md-2 text-end">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group row">
                <label for="id_periodo" class="col-sm-2 col-form-label">Clave</label>
                <div class="col-sm-1">
                    <input type="text" class="form-control" name="id_periodo" id="id_periodo" value="<?=$periodo['id_periodo'] ?>" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="nom_periodo" class="col-sm-2 col-form-label">Periodo</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="nom_periodo" id="nom_periodo" value="<?=$periodo['nom_periodo'] ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="num_supervisores" class="col-sm-2 col-form-label">Número de supervisores</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="num_supervisores" id="num_supervisores" value="<?=$periodo['num_supervisores'] ?>">
                </div>
            </div>
        </div>

    </form>

    <?php
        $permisos_requeridos = array(
            'criterio_calificacion.can_edit',
        );
    ?>
    <?php if (has_permission_and($permisos_requeridos, $permisos_usuario)) { ?>
        <div class="col-md-12 mt-5">
            <div class="row">
                <div class="col-md-5 offset-md-1">
                    <?php include 'criterios_calificacion_periodo.php' ?>
                </div>
            </div>
        </div>
    <?php } ?>

    <hr />

    <div class="form-group row">
        <div class="col-sm-10">
            <a href="<?=base_url()?>periodos" class="btn btn-secondary boton">Volver</a>
        </div>
    </div>

</main>
