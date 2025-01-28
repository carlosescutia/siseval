<?php
    $permisos_usuario = $userdata['permisos_usuario'];
    $cve_dependencia = $userdata['cve_dependencia'];
    $nom_dependencia = $userdata['nom_dependencia'];
    $anio_sesion = $userdata['anio_sesion'];
    $cve_rol = $userdata['cve_rol'];
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <div class="col-sm-10 offset-sm-1">
        <h2>Seguimiento</h2>
        <h6><?= $proyecto['cve_proyecto'] ?>&nbsp;&nbsp;<?= $proyecto['nom_proyecto'] ?>&nbsp;&nbsp;<?= $proyecto['periodo'] ?>&nbsp;&nbsp;<?= $proyecto['nom_tipo_evaluacion'] ?>&nbsp;&nbsp;<?= $proyecto['nom_dependencia_propuesta'] ?></h6>
    </div>
</div>

<div class="col-sm-8 offset-sm-2">
    <?php $num_rec = 0; ?>

    <?php foreach ($recomendaciones as $recomendaciones_item) { ?>
        <?php $num_rec += 1; ?>
        <div class="card mt-3 mb-5">
            <div class="card-header text-bg-success">
            Recomendación <?=$num_rec?> <?=$recomendaciones_item['desc_recomendacion']?> - ponderación: <?=$recomendaciones_item['ponderacion'] ?>
            </div>
            <div class="card-body">
                <?php if (in_array($recomendaciones_item['cve_recomendacion'], array_column($actividades, 'cve_recomendacion'))) { ?>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <?php include 'actividades.php' ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <?php
                $permisos_requeridos = array(
                'seguimiento.can_edit',
                'seguimiento.etapa_activa',
                'anio_activo',
                );
            ?>
            <?php if (has_permission_and($permisos_requeridos, $permisos_usuario)) { ?>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-5">
                            <?php
                                $prefijo = 'vf_seg' ;
                                $tipo_archivo = 'zip';
                                $nombre_archivo = $prefijo . '_' . $recomendaciones_item['cve_recomendacion'] . '.' . $tipo_archivo;
                                $dir_docs = './doc/';
                                $url_actual = base_url() . 'seguimiento/detalle/' . $recomendaciones_item['cve_recomendacion'] ;
                                $descripcion = 'verif seguimto';
                                $nombre_archivo_fs = $dir_docs . $nombre_archivo;
                                $nombre_archivo_url = base_url() . $dir_docs . $nombre_archivo;
                            ?>
                            <?php if ( file_exists($nombre_archivo_fs) ) { ?>
                                <a href="<?= $nombre_archivo_url ?>" target="_blank"><span class="mr-2"><img src="<?=base_url()?>img/application-zip.svg" height="30"></span>Medio de verificación</a>
                            <?php } ?>
                        </div>
                        <div class="col-md-7">
                            <form method="post" enctype="multipart/form-data" action="<?=base_url()?>archivos/subir">
                                <div class="row">
                                    <div class="col-md-8">
                                        <input type="file" class="form-control-file" name="subir_archivo">
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <button type="submit" class="btn btn-primary btn-sm">Subir archivo zip</button>
                                    </div>
                                </div>
                                <input type="hidden" name="nombre_archivo" value="<?=$nombre_archivo?>">
                                <input type="hidden" name="dir_docs" value="<?=$dir_docs?>">
                                <input type="hidden" name="tipo_archivo" value="<?=$tipo_archivo?>">
                                <input type="hidden" name="url_actual" value="<?=$url_actual?>">
                                <input type="hidden" name="descripcion" value="<?=$descripcion?>">
                            </form>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
</div>

<hr />

<div class="form-group row">
    <div class="col-sm-10">
        <a href="<?=base_url()?>seguimiento" class="btn btn-secondary boton">Volver</a>
    </div>
</div>

