<div class="col-sm-8 offset-sm-2 mt-3">
    <form method="post" enctype="multipart/form-data" action="<?= base_url() ?>archivos/cancelacion_proyecto" id="frm_cancelacion">
    </form>
    <div class="card mt-0 mb-3 tabla-datos">
        <div class="card-header text-white bg-primary">
            Propuesta de evaluación <?=$propuesta_evaluacion['nom_dependencia'] ?> <?=$propuesta_evaluacion['nom_tipo_evaluacion'] ?>
        </div>
        <form method="post" action="<?= base_url() ?>gestion/guardar_monto/">
            <div class="card-body">
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
                <div class="row">
                    <div class="col">
                        <label for="id_tipo_evaluacion">Monto de contratación</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" name="monto_contratacion" id="monto_contratacion" value="<?=$propuesta_evaluacion['monto_contratacion']?>">
                        </div>
                    </div>
                    <?php
                        $permisos_requeridos = array(
                        'gestion.can_cancel',
                        );
                    ?>
                    <?php if (has_permission_and($permisos_requeridos, $permisos_usuario)) { ?>
                        <div class="col text-center">
                            <div class="col-sm-12 border">
                                <label class="border-bottom mb-2">Documento probatorio para cancelación</label>
                                <div class="row text-danger small">
                                    <?php if ($error) { 
                                    echo $error;
                                    } ?>
                                </div>
                                <?php 
                                    $nombre_archivo = 'cancel_' . $propuesta_evaluacion['id_propuesta_evaluacion'] . '.pdf';
                                    $nombre_archivo_fs = './doc/' . $nombre_archivo;
                                    $nombre_archivo_url = base_url() . 'doc/' . $nombre_archivo;
                                    $url_actual = base_url() . 'gestion/detalle/'. $propuesta_evaluacion['id_propuesta_evaluacion'];
                                    $dir_docs = 'doc/';
                                ?>

                                <?php if ( file_exists($nombre_archivo_fs) ) { ?>
                                    <a href="<?= $nombre_archivo_url ?>" target="_blank"><i class="bi bi-filetype-pdf documento-g me-3"></i></a>
                                <?php } ?>

                                <label tabindex="0" name="btn_arch" id="btn_arch"><i class="bi bi-file-plus boton-archivo-sm"></i>
                                    <input name="subir_archivo" id="subir_archivo" type="file" class="d-none" onchange="$('#btn_subir').removeClass('d-none'); $('#btn_arch').addClass('d-none');" form="frm_cancelacion">
                                </label>
                                <input type="hidden" name="nombre_archivo" value="<?=$nombre_archivo?>" form="frm_cancelacion">
                                <input type="hidden" name="id_propuesta_evaluacion" value="<?=$propuesta_evaluacion['id_propuesta_evaluacion']?>" form="frm_cancelacion">
                                <button id="btn_subir" type="submit" class="btn btn-sm d-none" style="background: none; color: #28A745" form="frm_cancelacion">
                                    <i class="bi bi-upload boton-subir-sm"></i>
                                </button>
                                <?php if ( file_exists($nombre_archivo_fs) ) { 
                                    $item_eliminar = $nombre_archivo;
                                    ?>
                                    &nbsp;
                                    <a href="#dlg_borrar_archivos" data-bs-toggle="modal" onclick="pass_data('<?=$item_eliminar?>', '<?=$url_actual?>', '<?=$dir_docs?>')" ><i class="bi bi-x-circle boton-eliminar" ></i></a>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <input type="hidden" name="id_propuesta_evaluacion" value="<?= $propuesta_evaluacion['id_propuesta_evaluacion']; ?>">
                <input type="hidden" name="cve_proyecto" value="<?= $propuesta_evaluacion['cve_proyecto']; ?>">
                <input type="hidden" name="cve_dependencia" value="<?= $cve_dependencia ?>">
            </div>
            <?php
                $permisos_requeridos = array(
                'gestion.can_edit',
                'gestion.etapa_actual',
                );
            ?>
            <?php if (has_permission_and($permisos_requeridos, $permisos_usuario)) { ?>
                <div class="card-footer text-start">
                    <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
                </div>
            <?php } ?>
        </form>
    </div>
</div>

<hr />
<div class="form-group row">
    <div class="col-sm-10">
        <a href="<?=base_url()?>gestion" class="btn btn-secondary boton">Volver</a>
    </div>
</div>
