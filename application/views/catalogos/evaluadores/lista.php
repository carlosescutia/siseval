<main role="main" class="ml-sm-auto px-4 mb-3">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div class="col-sm-12 alternate-color">
            <div class="row">
                <div class="col-sm-10 text-start">
                    <h1 class="h2">Evaluadores</h1>
                </div>
                <div class="col-sm-2 text-end">
                    <form method="post" action="<?= base_url() ?>evaluadores/nuevo">
                        <button type="submit" class="btn btn-primary">Nuevo</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <div style="min-height: 46vh">
            <div class="row">
                <div class="col-sm-10">
                    <div class="row">
                        <div class="col-sm-2 align-self-center">
                            <p class="small"><strong>Número de proveedor</strong></p>
                        </div>
                        <div class="col-sm-4 align-self-center">
                            <p class="small"><strong>Nombre</strong></p>
                        </div>
                        <div class="col-sm-3 align-self-center">
                            <p class="small"><strong>Observaciones</strong></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php foreach ($evaluadores as $evaluadores_item) { ?>
                <div class="col-sm-10 alternate-color">
                    <div class="row">
                        <div class="col-sm-1 align-self-center">
                            <p><?= $evaluadores_item['id_evaluador'] ?></p>
                        </div>
                        <div class="col-sm-4 align-self-center">
                            <p><a href="<?=base_url()?>evaluadores/detalle/<?=$evaluadores_item['id_evaluador']?>"><?= $evaluadores_item['nom_evaluador'] ?></a></p>
                        </div>
                        <div class="col-sm-3 align-self-center">
                            <p><?= $evaluadores_item['observaciones'] ?></p>
                        </div>
                        <div class="col-sm-1">
                            <?php 
                            $item_eliminar = $evaluadores_item['nom_evaluador']; 
                            $url = base_url() . "evaluadores/eliminar/". $evaluadores_item['id_evaluador']; 
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
