<?php
    $permisos_requeridos = array(
    'plan_accion.can_edit',
    'valoracion.etapa_actual',
    );
?>
<?php if (has_permission_and($permisos_requeridos, $permisos_usuario)) { ?>
    <?php if ($plan_accion['status'] == 'aprobado') { ?>
        <div class="card mt-3 mb-3 d-print-none">
            <div class="card-header text-white bg-primary">Archivo</div>
            <div class="card-body">
                <div class="row text-danger">
                    <?php if ($error) { 
                    echo $error;
                    } ?>
                </div>
                <div class="col-sm-8 offset-sm-2 mt-3 mb-4 text-center">
                    <a href="javascript:window.print()" class="btn btn-primary boton">Imprimir Plan de acción</a>
                    <hr />
                </div>
                <?php 
                    $nombre_archivo = 'plan_ac_' . $plan_accion['id_plan_accion'] . '.pdf';
                    $nombre_archivo_fs = './doc/' . $nombre_archivo;
                    $nombre_archivo_url = base_url() . 'doc/' . $nombre_archivo;
                    if ( file_exists($nombre_archivo_fs) ) { ?>
                        <a href="<?= $nombre_archivo_url ?>" target="_blank"><span class="mr-2"><img src="<?=base_url()?>img/application-pdf.svg" height="30"></span>Plan de acción firmado</a>
                <?php } ?>
            </div>
            <div class="card-footer">
                <form method="post" enctype="multipart/form-data" action="<?=base_url()?>archivos/plan_accion">
                    <div class="row">
                        <div class="col-md-8">
                            <input type="file" class="form-control-file" name="subir_archivo">
                        </div>
                        <div class="col-md-4 text-end">
                            <button type="submit" class="btn btn-primary btn-sm">Subir pdf</button>
                        </div>
                    </div>
                    <input type="hidden" name="id_plan_accion" value="<?=$plan_accion['id_plan_accion']?>">
                    <input type="hidden" name="nombre_archivo" value="<?=$nombre_archivo?>">
                </form>
            </div>
        </div>
    <?php } ?>
<?php } ?>
