<?php
    $permisos_usuario = $userdata['permisos_usuario'];
?>
<table class="table table-sm table-bordered border-dark text-center">
    <thead>
        <tr>
            <th scope="col">Oficio de notificación</th>
            <th style="width: 10%" scope="col">status</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <?php 
                // valores comunes a todos los archivos
                $num_docs = 0; 
                $arch_requeridos = 0;
            ?>

            <td>
                <?php
                    $icono = "bi-filetype-pdf";
                    $tipo_archivo = 'pdf';
                    $prefijo = 'on';

                    $nombre_archivo = $prefijo . '_' . $proyectos_item['id_propuesta_evaluacion'] . '.' . $tipo_archivo ;
                    $dir_docs = './doc/';
                    $tipo_archivo = 'pdf';
                    $url_actual = uri_string();
                    $descripcion = 'oficio notif';
                ?>
                <?php
                    $nombre_archivo_fs = $dir_docs . $nombre_archivo ;
                    $nombre_archivo_url = base_url() . $dir_docs . $nombre_archivo;
                ?>

                <?php if ( file_exists($nombre_archivo_fs) ) { 
                    $num_docs += 1;
                    $arch_requeridos += 1;
                    ?>
                    <p><a href="<?=$nombre_archivo_url?>" target="_blank"><i class="bi <?=$icono?> documento-g"></i></a></p>
                <?php } ?>

                <?php
                    $permisos_requeridos = array(
                    'gestion.can_add_files',
                    'gestion.etapa_activa',
                    'anio_activo',
                    );
                ?>
                <?php if (has_permission_and($permisos_requeridos, $permisos_usuario)) { ?>
                    <form method="post" enctype="multipart/form-data" action="<?= base_url() ?>archivos/subir">
                        <label tabindex="0" name="btn_arch_<?=$prefijo?>_<?=strtolower($proyectos_item['id_propuesta_evaluacion'])?>" id="btn_arch_<?=$prefijo?>_<?=strtolower($proyectos_item['id_propuesta_evaluacion'])?>"><i class="bi bi-file-plus boton-archivo-sm"></i>
                            <input name="subir_archivo" id="subir_archivo" type="file" class="d-none" onchange="$('#btn_<?=$prefijo?>_<?=strtolower($proyectos_item['id_propuesta_evaluacion'])?>').removeClass('d-none'); $('#btn_arch_<?=$prefijo?>_<?=strtolower($proyectos_item['id_propuesta_evaluacion'])?>').addClass('d-none');">
                        </label>
                        <input type="hidden" name="dir_docs" value="<?=$dir_docs?>">
                        <input type="hidden" name="nombre_archivo" value="<?=$nombre_archivo?>">
                        <input type="hidden" name="tipo_archivo" value="<?=$tipo_archivo?>">
                        <input type="hidden" name="url_actual" value="<?=$url_actual?>">
                        <input type="hidden" name="descripcion" value="<?=$descripcion?>">
                        <button id="btn_<?=$prefijo?>_<?=strtolower($proyectos_item['id_propuesta_evaluacion'])?>" type="submit" class="btn btn-sm d-none" style="background: none; color: #28A745">
                            <i class="bi bi-upload boton-subir-sm"></i>
                        </button>
                        <?php if ( file_exists($nombre_archivo_fs) ) { 
                            $item_eliminar = $nombre_archivo;
                            ?>
                            &nbsp;
                            <a href="#dlg_borrar_archivos" data-bs-toggle="modal" onclick="pass_data('<?=$item_eliminar?>', '<?=$url_actual?>', '<?=$dir_docs?>')" ><i class="bi bi-x-circle boton-eliminar" ></i></a>
                        <?php } ?>
                    </form>
                <?php } ?>
            </td>

            <?php
                if ($arch_requeridos > 0) {
                    $fondo_actual = 'text-bg-success';
                } else {
                    $fondo_actual = 'text-bg-secondary';
                } 
            ?>
            <td><span class="badge rounded-pill <?=$fondo_actual?>"><?= $num_docs ?></span></td>
        </tr>
    </tbody>
</table>
