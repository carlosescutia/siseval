<main role="main" class="ml-sm-auto px-4 mb-3">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div class="col-sm-12 alternate-color">
            <div class="row">
                <div class="col-sm-10 text-start">
                    <h1 class="h2">Usuarios</h1>
                </div>
                <div class="col-sm-2 text-end">
                    <form method="post" action="<?= base_url() ?>usuarios/nuevo">
                        <button type="submit" class="btn btn-primary">Nuevo</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <div style="min-height: 46vh">
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-1 align-self-center">
                            <p class="small"><strong>Clave</strong></p>
                        </div>
                        <div class="col-sm-3 align-self-center">
                            <p class="small"><strong>Nombre</strong></p>
                        </div>
                        <div class="col-sm-2 align-self-center">
                            <p class="small"><strong>Usuario</strong></p>
                        </div>
                        <div class="col-sm-1 align-self-center">
                            <p class="small"><strong>Dependencia</strong></p>
                        </div>
                        <div class="col-sm-2 align-self-center">
                            <p class="small"><strong>Rol</strong></p>
                        </div>
                        <div class="col-sm-1 align-self-center">
                            <p class="small"><strong>Activo</strong></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php foreach ($usuarios as $usuarios_item) { ?>
                <div class="col-sm-12 alternate-color">
                    <div class="row">
                        <div class="col-sm-1 align-self-center">
                            <p><?= $usuarios_item['cve_usuario'] ?></p>
                        </div>
                        <div class="col-sm-3 align-self-center">
                            <p><a href="<?=base_url()?>usuarios/detalle/<?=$usuarios_item['cve_usuario']?>"><?= $usuarios_item['nom_usuario'] ?></a></p>
                        </div>
                        <div class="col-sm-2 align-self-center">
                            <p><?= $usuarios_item['usuario'] ?></p>
                        </div>
                        <div class="col-sm-1 align-self-center">
                            <p><?= $usuarios_item['nom_dependencia'] ?></p>
                        </div>
                        <div class="col-sm-2 align-self-center">
                            <p><?= $usuarios_item['nom_rol'] ?></p>
                        </div>
                        <div class="col-sm-1 align-self-center">
                            <p><?= $usuarios_item['activo'] ?></p>
                        </div>
                        <div class="col-sm-1">
                            <?php 
                            $item_eliminar = $usuarios_item['nom_usuario'] . " - " . $usuarios_item['nom_dependencia'] ;
                            $url = base_url() . "usuarios/eliminar/". $usuarios_item['cve_usuario']; 
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
