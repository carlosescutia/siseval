<main role="main" class="ml-sm-auto px-4 mb-3">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div class="col-sm-12 alternate-color">
            <div class="row">
                <div class="col-sm-10 text-start">
                    <h1 class="h2">Probabilidades de inclusión</h1>
                </div>
                <div class="col-sm-2 text-end">
                    <form method="post" action="<?= base_url() ?>probabilidades_inclusion/nuevo">
                        <button type="submit" class="btn btn-primary">Nuevo</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <div style="min-height: 46vh">
            <div class="row">
                <div class="col-sm-8">
                    <div class="row">
                        <div class="col-sm-2 align-self-center">
                            <p class="small"><strong>Clave</strong></p>
                        </div>
                        <div class="col-sm-2 align-self-center">
                            <p class="small"><strong>Probabilidad</strong></p>
                        </div>
                        <div class="col-sm-1 align-self-center">
                            <p class="small"><strong>Min</strong></p>
                        </div>
                        <div class="col-sm-1 align-self-center">
                            <p class="small"><strong>Max</strong></p>
                        </div>
                        <div class="col-sm-2 align-self-center text-center">
                            <p class="small"><strong>Orden</strong></p>
                        </div>
                        <div class="col-sm-2 align-self-center">
                            <p class="small"><strong>Periodo</strong></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php foreach ($probabilidades_inclusion as $probabilidades_inclusion_item) { ?>
                <div class="col-sm-8 alternate-color">
                    <div class="row">
                        <div class="col-sm-2 align-self-center">
                            <p><?= $probabilidades_inclusion_item['id_probabilidad_inclusion'] ?></p>
                        </div>
                        <div class="col-sm-2 align-self-center">
                            <p><a href="<?=base_url()?>probabilidades_inclusion/detalle/<?=$probabilidades_inclusion_item['id_probabilidad_inclusion']?>"><?= $probabilidades_inclusion_item['nom_probabilidad_inclusion'] ?></a></p>
                        </div>
                        <div class="col-sm-1 align-self-center">
                            <p><?= $probabilidades_inclusion_item['min'] ?></p>
                        </div>
                        <div class="col-sm-1 align-self-center">
                            <p><?= $probabilidades_inclusion_item['max'] ?></p>
                        </div>
                        <div class="col-sm-2 align-self-center text-center">
                            <p><?= $probabilidades_inclusion_item['orden'] ?></p>
                        </div>
                        <div class="col-sm-2 align-self-center">
                            <p><?= $probabilidades_inclusion_item['periodo'] ?></p>
                        </div>
                        <div class="col-sm-1">
                            <?php 
                            $item_eliminar = $probabilidades_inclusion_item['nom_probabilidad_inclusion']; 
                            $url = base_url() . "probabilidades_inclusion/eliminar/". $probabilidades_inclusion_item['id_probabilidad_inclusion']; 
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
