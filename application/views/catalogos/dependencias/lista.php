<main role="main" class="ml-sm-auto px-4 mb-3">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div class="col-sm-12 alternate-color">
            <div class="row">
                <div class="col-sm-10 text-left">
                    <h1 class="h2">Dependencias</h1>
                </div>
                <div class="col-sm-2 text-right">
                    <form method="post" action="<?= base_url() ?>dependencias/nuevo">
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
                            <p class="small"><strong>Clave</strong></p>
                        </div>
                        <div class="col-sm-5 align-self-center">
                            <p class="small"><strong>Nombre completo</strong></p>
                        </div>
                        <div class="col-sm-2 align-self-center">
                            <p class="small"><strong>Siglas</strong></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php foreach ($dependencias as $dependencias_item) { ?>
                <div class="col-sm-10 alternate-color">
                    <div class="row">
                        <div class="col-sm-2 align-self-center">
                            <p><?= $dependencias_item['cve_dependencia'] ?></p>
                        </div>
                        <div class="col-sm-5 align-self-center">
                            <p><a href="<?=base_url()?>dependencias/detalle/<?=$dependencias_item['cve_dependencia']?>"><?= $dependencias_item['nom_completo_dependencia'] ?></a></p>
                        </div>
                        <div class="col-sm-2 align-self-center">
                            <p><a href="<?=base_url()?>dependencias/detalle/<?=$dependencias_item['cve_dependencia']?>"><?= $dependencias_item['nom_dependencia'] ?></a></p>
                        </div>
                        <div class="col-sm-1">
                            <?php 
                            $item_eliminar = $dependencias_item['nom_dependencia']; 
                            $url = base_url() . "dependencias/eliminar/". $dependencias_item['cve_dependencia']; 
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
