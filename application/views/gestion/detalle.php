<div class="col-sm-8 offset-sm-2 mt-3">
    <div class="card mt-0 mb-3 tabla-datos">
        <div class="card-header text-white bg-primary">Propuesta de evaluación <?=$propuesta_evaluacion['nom_dependencia'] ?> <?=$propuesta_evaluacion['nom_tipo_evaluacion'] ?> </div>
        <div class="card-body">
            <form method="post" action="<?= base_url() ?>gestion/guardar_monto/">
                <div class="form-group row">
                    <label for="id_tipo_evaluacion">Clave PP</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" name="cve_proyecto" id="cve_proyecto" value="<?=$propuesta_evaluacion['cve_proyecto']?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="id_tipo_evaluacion">Objetivo</label>
                    <div class="col-sm-10">
                        <textarea rows="4" class="form-control" name="objetivo" id="objetivo"><?=$propuesta_evaluacion['objetivo']?></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="id_tipo_evaluacion">Monto de contratación</label>
                    <div class="col-sm-4">
                        <input type="number" class="form-control" name="monto_contratacion" id="monto_contratacion" value="<?=$propuesta_evaluacion['monto_contratacion']?>">
                    </div>
                </div>

                <input type="hidden" name="id_propuesta_evaluacion" value="<?= $propuesta_evaluacion['id_propuesta_evaluacion']; ?>">
                <input type="hidden" name="cve_proyecto" value="<?= $propuesta_evaluacion['cve_proyecto']; ?>">
                <input type="hidden" name="cve_dependencia" value="<?= $cve_dependencia ?>">
                <div class="card-footer text-end">
                    <div class="row">

                        <div class="col-sm-6 text-start">
                            <?php
                                $permisos_requeridos = array(
                                'gestion.can_edit',
                                'gestion.etapa_actual',
                                );
                            ?>
                            <?php if (has_permission_and($permisos_requeridos, $permisos_usuario)) { ?>
                                <?php if ($cve_dependencia == $propuesta_evaluacion['cve_dependencia']) { ?>
                                    <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
                                <?php } ?>
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
        <a href="<?=base_url()?>gestion" class="btn btn-secondary boton">Volver</a>
    </div>
</div>
