<main role="main" class="ml-sm-auto px-4 mb-3">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div class="col-sm-12 alternate-color">
            <div class="row">
                <div class="col-sm-10 text-start">
                    <h1 class="h2">Tipos de evaluación</h1>
                </div>
                <div class="col-sm-2 text-end">
                    <form method="post" action="<?= base_url() ?>tipos_evaluacion/nuevo">
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
                        <div class="col-sm-8 align-self-center">
                            <p class="small"><strong>Siglas</strong></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php foreach ($tipos_evaluacion as $tipos_evaluacion_item) { ?>
                <div class="col-sm-7 alternate-color">
                    <div class="row">
                        <div class="col-sm-3 align-self-center">
                            <p><?= $tipos_evaluacion_item['id_tipo_evaluacion'] ?></p>
                        </div>
                        <div class="col-sm-8 align-self-center">
                            <p><a href="<?=base_url()?>tipos_evaluacion/detalle/<?=$tipos_evaluacion_item['id_tipo_evaluacion']?>"><?= $tipos_evaluacion_item['nom_tipo_evaluacion'] ?></a></p>
                        </div>
                        <div class="col-sm-1">
                            <?php 
                            $item_eliminar = $tipos_evaluacion_item['nom_tipo_evaluacion']; 
                            $url = base_url() . "tipos_evaluacion/eliminar/". $tipos_evaluacion_item['id_tipo_evaluacion']; 
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
            <a href="<?=base_url()?>catalogos" class="btn btn-secondary">Volver</a>
        </div>
    </div>

</main>
