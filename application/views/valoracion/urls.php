<?php
    $permisos_usuario = $userdata['permisos_usuario'];
    $cve_dependencia = $userdata['cve_dependencia'];
    $nom_dependencia = $userdata['nom_dependencia'];
    $anio_sesion = $userdata['anio_sesion'];
    $cve_rol = $userdata['cve_rol'];
?>
<div class="col-sm-8 offset-sm-2 mt-3">
    <div class="card mt-0 mb-3 tabla-datos">
        <div class="card-header text-white bg-primary">
            Propuesta de evaluación <?=$propuesta_evaluacion['nom_dependencia'] ?> <?=$propuesta_evaluacion['nom_tipo_evaluacion'] ?> 
        </div>
        <form method="post" action="<?= base_url() ?>valoracion/guardar_urls/">
            <div class="card-body">
                <div class="form-group row">
                    <label for="cve_proyecto">Clave PP</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" name="cve_proyecto" id="cve_proyecto" value="<?=$propuesta_evaluacion['cve_proyecto']?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="objetivo">Objetivo</label>
                    <div class="col-sm-10">
                        <textarea rows="4" class="form-control" name="objetivo" id="objetivo"><?=$propuesta_evaluacion['objetivo']?></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="url_sitio_do">Liga de la ubicación del documento de opinión</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" name="url_sitio_do" id="url_sitio_do" value="<?=$propuesta_evaluacion['url_sitio_do']?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="url_arch_do">Liga de descarga del documento de opinión</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" name="url_arch_do" id="url_arch_do" value="<?=$propuesta_evaluacion['url_arch_do']?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="url_sitio_pa">Liga de la ubicación del plan de acción</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" name="url_sitio_pa" id="url_sitio_pa" value="<?=$propuesta_evaluacion['url_sitio_pa']?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="url_arch_pa">Liga de descarga del plan de acción</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" name="url_arch_pa" id="url_arch_pa" value="<?=$propuesta_evaluacion['url_arch_pa']?>">
                    </div>
                </div>

                <input type="hidden" name="id_propuesta_evaluacion" value="<?= $propuesta_evaluacion['id_propuesta_evaluacion']; ?>">
            </div>
            <?php
                $permisos_requeridos = array(
                'urls.can_edit',
                'valoracion.etapa_activa',
                'anio_activo',
                );
            ?>
            <?php if (has_permission_and($permisos_requeridos, $permisos_usuario)) { ?>
                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
                </div>
            <?php } ?>
        </form>
    </div>
</div>

<hr />
<div class="form-group row">
    <div class="col-sm-10">
        <a href="<?=base_url()?>valoracion" class="btn btn-secondary boton">Volver</a>
    </div>
</div>

