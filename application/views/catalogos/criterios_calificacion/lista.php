<main role="main" class="ml-sm-auto px-4 mb-3">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div class="col-sm-12 alternate-color">
            <div class="row">
                <div class="col-sm-10 text-start">
                    <h1 class="h2">Criterios de calificación</h1>
                </div>
                <div class="col-sm-2 text-end">
                    <form method="post" action="<?= base_url() ?>criterios_calificacion/nuevo">
                        <button type="submit" class="btn btn-primary">Nuevo</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <div style="min-height: 46vh">
            <div class="row">
                <div class="col-sm-7">
                    <div class="row">
                        <div class="col-sm-3 align-self-center">
                            <p class="small"><strong>Clave</strong></p>
                        </div>
                        <div class="col-sm-4 align-self-center">
                            <p class="small"><strong>Nombre</strong></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php foreach ($criterios_calificacion as $criterios_calificacion_item) { ?>
                <div class="col-sm-7 alternate-color">
                    <div class="row">
                        <div class="col-sm-3 align-self-center">
                            <p><?= $criterios_calificacion_item['id_criterio_calificacion'] ?></p>
                        </div>
                        <div class="col-sm-4 align-self-center">
                            <p><a href="<?=base_url()?>criterios_calificacion/detalle/<?=$criterios_calificacion_item['id_criterio_calificacion']?>"><?= $criterios_calificacion_item['nom_criterio'] ?></a></p>
                        </div>
                        <div class="col-sm-1">
                            <?php 
                            $item_eliminar = $criterios_calificacion_item['nom_criterio']; 
                            $url = base_url() . "criterios_calificacion/eliminar/". $criterios_calificacion_item['id_criterio_calificacion']; 
                            ?>
                            <p><a href="#dlg_borrar" data-bs-toggle="modal" onclick="pass_data('<?=$item_eliminar?>', '<?=$url?>')" ><i class="bi bi-x-circle boton-eliminar" ></i>
                            </a></p>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <hr />

    <div class="form-group row">
        <div class="col-sm-10">
            <a href="<?=base_url()?>catalogos" class="btn btn-secondary boton">Volver</a>
        </div>
    </div>

</main>
