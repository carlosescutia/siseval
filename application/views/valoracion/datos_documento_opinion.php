<div class="card mt-0 mb-3">
    <div class="card-body">
        <form method="post" action="<?= base_url() ?>valoracion/documento_opinion_guardar/<?=$documento_opinion['cve_documento_opinion']?>" id="doc_op">
            <table class="table table-striped table-sm">
                <tbody>
                    <tr>
                        <td>Fecha de elaboración</td>
                        <td><label><?= date('d/m/Y', strtotime($documento_opinion['fecha_elaboracion'])) ?></label></td>
                    </tr>
                    <tr>
                        <td>Nombre de la dependencia responsable</td>
                        <td><label><?=$propuesta_evaluacion['nom_dependencia'] ?></label></td>
                    </tr>
                    <tr>
                        <td>Nombre de la intervención pública</td>
                        <td><label><?=$propuesta_evaluacion['nom_proyecto'] ?></label></td>
                    </tr>
                    <tr>
                        <td>Tipo de evaluación</td>
                        <td><label><?=$propuesta_evaluacion['nom_tipo_evaluacion'] ?></label></td>
                    </tr>
                    <tr>
                        <td>Año de aplicación de la evaluación</td>
                        <td><label><?=$propuesta_evaluacion['periodo'] ?></label></td>
                    </tr>
                    <tr>
                        <td>Instancia evaluadora</td>
                        <td><input type="text" class="form-control" name="instancia_evaluadora" id="instancia_evaluadora" value="<?=$documento_opinion['instancia_evaluadora'] ?>" ></td>
                    </tr>
                    <tr>
                        <td>Elaborado por</td>
                        <td><input type="text" class="form-control" name="elaborado_por" id="elaborado_por" value="<?=$documento_opinion['elaborado_por'] ?>" ></td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td><label><?=$documento_opinion['desc_status_documento_opinion'] ?></label>
                            <?php
                                $permisos_requeridos = array(
                                'documento_opinion.can_edit',
                                'es_etapa_actual',
                                );
                            ?>
                            <?php if (has_permission_and($permisos_requeridos, $permisos_usuario)) { ?>
                                <!-- si están en status "En revision" y existe al menos una recomendación, activar botón "Enviar a revisión" -->
                                <?php if ($documento_opinion['status'] == 2 and $documento_opinion['num_recomendaciones'] > 0) { ?>
                                    <a href="<?=base_url()?>valoracion/documento_opinion_revision/<?=$documento_opinion['cve_documento_opinion']?>" class="btn btn-success btn-sm">Enviar a revisión</a>
                                <?php } ?>
                            <?php } ?>
                        </td>
                    </tr>
                </tbody>
                <input type="hidden" name="fecha_elaboracion" id="fecha_elaboracion" value="<?= date('Y-m-d') ?>">
            </table>
        </form>
    </div>
</div>

<div class="col-md-12 mt-4 mb-2">
    <h5>Antecedentes</h5>
    <textarea rows="4" class="form-control" name="antecedentes" id="antecedentes" form="doc_op"><?=$documento_opinion['antecedentes']?></textarea>
</div>

<?php
    $permisos_requeridos = array(
    'documento_opinion.can_edit',
    'es_etapa_actual',
    );
?>
<?php if (has_permission_and($permisos_requeridos, $permisos_usuario)) { ?>
    <?php if ($documento_opinion['status'] == 2) { ?>
        <div class="col-md-12 text-end d-print-none">
            <button type="submit" class="btn btn-primary" form="doc_op">Guardar</button>
        </div>
    <?php } ?>
<?php } ?>
