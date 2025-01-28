<div class="col-sm-8 offset-sm-2 mt-3">
    <div class="card mt-0 mb-3 tabla-datos">
        <div class="card-header text-white bg-primary">Propuesta de evaluación <?=$propuesta_evaluacion['nom_dependencia'] ?> <?=$propuesta_evaluacion['nom_tipo_evaluacion'] ?> </div>
        <div class="card-body">
            <form method="post" action="<?= base_url() ?>ejecucion/guardar_urls/">
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
                    <label for="url_sitio_if">Liga de la ubicación del informe final</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" name="url_sitio_if" id="url_sitio_if" value="<?=$propuesta_evaluacion['url_sitio_if']?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="url_arch_if">Liga de descarga del informe final</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" name="url_arch_if" id="url_arch_if" value="<?=$propuesta_evaluacion['url_arch_if']?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="url_sitio_fc">Liga de la ubicación de la ficha conac</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" name="url_sitio_fc" id="url_sitio_fc" value="<?=$propuesta_evaluacion['url_sitio_fc']?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="url_arch_fc">Liga de descarga de la ficha conac</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" name="url_arch_fc" id="url_arch_fc" value="<?=$propuesta_evaluacion['url_arch_fc']?>">
                    </div>
                </div>

                <input type="hidden" name="id_propuesta_evaluacion" value="<?= $propuesta_evaluacion['id_propuesta_evaluacion']; ?>">
                <div class="card-footer text-end">
                    <div class="row">

                        <div class="col-sm-12 text-end">
                            <?php
                                $permisos_requeridos = array(
                                'urls.can_edit',
                                'ejecucion.etapa_activa',
                                'anio_activo',
                                );
                            ?>
                            <?php if (has_permission_and($permisos_requeridos, $permisos_usuario)) { ?>
                                <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<hr />
<div class="form-group row">
    <div class="col-sm-10">
        <a href="<?=base_url()?>ejecucion" class="btn btn-secondary boton">Volver</a>
    </div>
</div>
