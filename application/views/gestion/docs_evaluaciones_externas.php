<table class="table table-sm table-bordered border-dark text-center">
    <thead>
        <tr>
            <th scope="col" title="Términos de referencia">TR</th>
            <th scope="col" title="Base de participación">BP</th>
            <th scope="col" title="Convocatoria">CV</th>
            <th scope="col" title="Contrato">CT</th>
            <th scope="col" title="Emisión de fallo">EF</th>
            <th style="width: 10%" scope="col">status</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <?php 
                // valores comunes a todos los archivos
                $num_docs = 0; 
                $prefijo_etapa = 'g';
                $dir_docs = 'doc/';
                $url_actual = base_url() . 'gestion';
            ?>

            <td>
                <?php
                    $tipo_doc = 'tr';
                    $icono = "bi-filetype-pdf";
                    $tipo_archivo = 'pdf';
                    $nombre_archivo = $prefijo_etapa . $tipo_doc . '_' . strtolower($proyectos_item['cve_proyecto']) . $proyectos_item['abrev_tipo_evaluacion'] . '.' . $tipo_archivo ;
                    $nombre_archivo_fs = './' . $dir_docs . $nombre_archivo ;
                    $nombre_archivo_url = base_url() . $dir_docs . $nombre_archivo;
                ?>
                
                <?php if ( file_exists($nombre_archivo_fs) ) { 
                    $num_docs += 1;
                    ?>
                    <p><a href="<?=$nombre_archivo_url?>" target="_blank"><i class="bi <?=$icono?> documento-g"></i></a></p>
                <?php } ?>

                <?php
                    $permisos_requeridos = array(
                    'gestion.can_add_files',
                    'gestion.etapa_actual',
                    );
                ?>
                <?php if (has_permission_and($permisos_requeridos, $permisos_usuario)) { ?>
                    <form method="post" enctype="multipart/form-data" action="<?= base_url() ?>archivos/subir">
                        <label tabindex="0" name="btn_arch_<?=$tipo_doc?>_<?=strtolower($proyectos_item['cve_proyecto'])?><?=$proyectos_item['abrev_tipo_evaluacion']?>" id="btn_arch_<?=$tipo_doc?>_<?=strtolower($proyectos_item['cve_proyecto'])?><?=$proyectos_item['abrev_tipo_evaluacion']?>"><i class="bi bi-file-plus boton-archivo-sm"></i>
                            <input name="subir_archivo" id="subir_archivo" type="file" class="d-none" onchange="$('#btn_<?=$tipo_doc?>_<?=strtolower($proyectos_item['cve_proyecto'])?><?=$proyectos_item['abrev_tipo_evaluacion']?>').removeClass('d-none'); $('#btn_arch_<?=$tipo_doc?>_<?=strtolower($proyectos_item['cve_proyecto'])?><?=$proyectos_item['abrev_tipo_evaluacion']?>').addClass('d-none');">
                        </label>
                        <input type="hidden" name="dir_docs" value="<?=$dir_docs?>">
                        <input type="hidden" name="nombre_archivo" value="<?=$nombre_archivo?>">
                        <input type="hidden" name="tipo_archivo" value="<?=$tipo_archivo?>">
                        <input type="hidden" name="url_actual" value="<?=$url_actual?>">
                        <button id="btn_<?=$tipo_doc?>_<?=strtolower($proyectos_item['cve_proyecto'])?><?=$proyectos_item['abrev_tipo_evaluacion']?>" type="submit" class="btn btn-sm d-none" style="background: none; color: #28A745">
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
            <td>
                <?php
                    $tipo_doc = 'bp';
                    $icono = "bi-filetype-pdf";
                    $tipo_archivo = 'pdf';
                    $nombre_archivo = $prefijo_etapa . $tipo_doc . '_' . strtolower($proyectos_item['cve_proyecto']) . $proyectos_item['abrev_tipo_evaluacion'] . '.' . $tipo_archivo ;
                    $nombre_archivo_fs = './' . $dir_docs . $nombre_archivo ;
                    $nombre_archivo_url = base_url() . $dir_docs . $nombre_archivo;
                ?>
                
                <?php if ( file_exists($nombre_archivo_fs) ) { 
                    $num_docs += 1;
                    ?>
                    <p><a href="<?=$nombre_archivo_url?>" target="_blank"><i class="bi <?=$icono?> documento-g"></i></a></p>
                <?php } ?>

                <?php if (has_permission_and($permisos_requeridos, $permisos_usuario)) { ?>
                    <form method="post" enctype="multipart/form-data" action="<?= base_url() ?>archivos/subir">
                        <label tabindex="0" name="btn_arch_<?=$tipo_doc?>_<?=strtolower($proyectos_item['cve_proyecto'])?><?=$proyectos_item['abrev_tipo_evaluacion']?>" id="btn_arch_<?=$tipo_doc?>_<?=strtolower($proyectos_item['cve_proyecto'])?><?=$proyectos_item['abrev_tipo_evaluacion']?>"><i class="bi bi-file-plus boton-archivo-sm"></i>
                            <input name="subir_archivo" id="subir_archivo" type="file" class="d-none" onchange="$('#btn_<?=$tipo_doc?>_<?=strtolower($proyectos_item['cve_proyecto'])?><?=$proyectos_item['abrev_tipo_evaluacion']?>').removeClass('d-none'); $('#btn_arch_<?=$tipo_doc?>_<?=strtolower($proyectos_item['cve_proyecto'])?><?=$proyectos_item['abrev_tipo_evaluacion']?>').addClass('d-none');">
                        </label>
                        <input type="hidden" name="dir_docs" value="<?=$dir_docs?>">
                        <input type="hidden" name="nombre_archivo" value="<?=$nombre_archivo?>">
                        <input type="hidden" name="tipo_archivo" value="<?=$tipo_archivo?>">
                        <input type="hidden" name="url_actual" value="<?=$url_actual?>">
                        <button id="btn_<?=$tipo_doc?>_<?=strtolower($proyectos_item['cve_proyecto'])?><?=$proyectos_item['abrev_tipo_evaluacion']?>" type="submit" class="btn btn-sm d-none" style="background: none; color: #28A745">
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
            <td>
                <?php
                    $tipo_doc = 'cv';
                    $icono = "bi-filetype-pdf";
                    $tipo_archivo = 'pdf';
                    $nombre_archivo = $prefijo_etapa . $tipo_doc . '_' . strtolower($proyectos_item['cve_proyecto']) . $proyectos_item['abrev_tipo_evaluacion'] . '.' . $tipo_archivo ;
                    $nombre_archivo_fs = './' . $dir_docs . $nombre_archivo ;
                    $nombre_archivo_url = base_url() . $dir_docs . $nombre_archivo;
                ?>
                
                <?php if ( file_exists($nombre_archivo_fs) ) { 
                    $num_docs += 1;
                    ?>
                    <p><a href="<?=$nombre_archivo_url?>" target="_blank"><i class="bi <?=$icono?> documento-g"></i></a></p>
                <?php } ?>

                <?php if (has_permission_and($permisos_requeridos, $permisos_usuario)) { ?>
                    <form method="post" enctype="multipart/form-data" action="<?= base_url() ?>archivos/subir">
                        <label tabindex="0" name="btn_arch_<?=$tipo_doc?>_<?=strtolower($proyectos_item['cve_proyecto'])?><?=$proyectos_item['abrev_tipo_evaluacion']?>" id="btn_arch_<?=$tipo_doc?>_<?=strtolower($proyectos_item['cve_proyecto'])?><?=$proyectos_item['abrev_tipo_evaluacion']?>"><i class="bi bi-file-plus boton-archivo-sm"></i>
                            <input name="subir_archivo" id="subir_archivo" type="file" class="d-none" onchange="$('#btn_<?=$tipo_doc?>_<?=strtolower($proyectos_item['cve_proyecto'])?><?=$proyectos_item['abrev_tipo_evaluacion']?>').removeClass('d-none'); $('#btn_arch_<?=$tipo_doc?>_<?=strtolower($proyectos_item['cve_proyecto'])?><?=$proyectos_item['abrev_tipo_evaluacion']?>').addClass('d-none');">
                        </label>
                        <input type="hidden" name="dir_docs" value="<?=$dir_docs?>">
                        <input type="hidden" name="nombre_archivo" value="<?=$nombre_archivo?>">
                        <input type="hidden" name="tipo_archivo" value="<?=$tipo_archivo?>">
                        <input type="hidden" name="url_actual" value="<?=$url_actual?>">
                        <button id="btn_<?=$tipo_doc?>_<?=strtolower($proyectos_item['cve_proyecto'])?><?=$proyectos_item['abrev_tipo_evaluacion']?>" type="submit" class="btn btn-sm d-none" style="background: none; color: #28A745">
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
            <td>
                <?php
                    $tipo_doc = 'ct';
                    $icono = "bi-filetype-pdf";
                    $tipo_archivo = 'pdf';
                    $nombre_archivo = $prefijo_etapa . $tipo_doc . '_' . strtolower($proyectos_item['cve_proyecto']) . $proyectos_item['abrev_tipo_evaluacion'] . '.' . $tipo_archivo ;
                    $nombre_archivo_fs = './' . $dir_docs . $nombre_archivo ;
                    $nombre_archivo_url = base_url() . $dir_docs . $nombre_archivo;
                ?>
                
                <?php if ( file_exists($nombre_archivo_fs) ) { 
                    $num_docs += 1;
                    ?>
                    <p><a href="<?=$nombre_archivo_url?>" target="_blank"><i class="bi <?=$icono?> documento-g"></i></a></p>
                <?php } ?>

                <?php if (has_permission_and($permisos_requeridos, $permisos_usuario)) { ?>
                    <form method="post" enctype="multipart/form-data" action="<?= base_url() ?>archivos/subir">
                        <label tabindex="0" name="btn_arch_<?=$tipo_doc?>_<?=strtolower($proyectos_item['cve_proyecto'])?><?=$proyectos_item['abrev_tipo_evaluacion']?>" id="btn_arch_<?=$tipo_doc?>_<?=strtolower($proyectos_item['cve_proyecto'])?><?=$proyectos_item['abrev_tipo_evaluacion']?>"><i class="bi bi-file-plus boton-archivo-sm"></i>
                            <input name="subir_archivo" id="subir_archivo" type="file" class="d-none" onchange="$('#btn_<?=$tipo_doc?>_<?=strtolower($proyectos_item['cve_proyecto'])?><?=$proyectos_item['abrev_tipo_evaluacion']?>').removeClass('d-none'); $('#btn_arch_<?=$tipo_doc?>_<?=strtolower($proyectos_item['cve_proyecto'])?><?=$proyectos_item['abrev_tipo_evaluacion']?>').addClass('d-none');">
                        </label>
                        <input type="hidden" name="dir_docs" value="<?=$dir_docs?>">
                        <input type="hidden" name="nombre_archivo" value="<?=$nombre_archivo?>">
                        <input type="hidden" name="tipo_archivo" value="<?=$tipo_archivo?>">
                        <input type="hidden" name="url_actual" value="<?=$url_actual?>">
                        <button id="btn_<?=$tipo_doc?>_<?=strtolower($proyectos_item['cve_proyecto'])?><?=$proyectos_item['abrev_tipo_evaluacion']?>" type="submit" class="btn btn-sm d-none" style="background: none; color: #28A745">
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
            <td>
                <?php
                    $tipo_doc = 'ef';
                    $icono = "bi-filetype-pdf";
                    $tipo_archivo = 'pdf';
                    $nombre_archivo = $prefijo_etapa . $tipo_doc . '_' . strtolower($proyectos_item['cve_proyecto']) . $proyectos_item['abrev_tipo_evaluacion'] . '.' . $tipo_archivo ;
                    $nombre_archivo_fs = './' . $dir_docs . $nombre_archivo ;
                    $nombre_archivo_url = base_url() . $dir_docs . $nombre_archivo;
                ?>
                
                <?php if ( file_exists($nombre_archivo_fs) ) { 
                    $num_docs += 1;
                    ?>
                    <p><a href="<?=$nombre_archivo_url?>" target="_blank"><i class="bi <?=$icono?> documento-g"></i></a></p>
                <?php } ?>

                <?php if (has_permission_and($permisos_requeridos, $permisos_usuario)) { ?>
                    <form method="post" enctype="multipart/form-data" action="<?= base_url() ?>archivos/subir">
                        <label tabindex="0" name="btn_arch_<?=$tipo_doc?>_<?=strtolower($proyectos_item['cve_proyecto'])?><?=$proyectos_item['abrev_tipo_evaluacion']?>" id="btn_arch_<?=$tipo_doc?>_<?=strtolower($proyectos_item['cve_proyecto'])?><?=$proyectos_item['abrev_tipo_evaluacion']?>"><i class="bi bi-file-plus boton-archivo-sm"></i>
                            <input name="subir_archivo" id="subir_archivo" type="file" class="d-none" onchange="$('#btn_<?=$tipo_doc?>_<?=strtolower($proyectos_item['cve_proyecto'])?><?=$proyectos_item['abrev_tipo_evaluacion']?>').removeClass('d-none'); $('#btn_arch_<?=$tipo_doc?>_<?=strtolower($proyectos_item['cve_proyecto'])?><?=$proyectos_item['abrev_tipo_evaluacion']?>').addClass('d-none');">
                        </label>
                        <input type="hidden" name="dir_docs" value="<?=$dir_docs?>">
                        <input type="hidden" name="nombre_archivo" value="<?=$nombre_archivo?>">
                        <input type="hidden" name="tipo_archivo" value="<?=$tipo_archivo?>">
                        <input type="hidden" name="url_actual" value="<?=$url_actual?>">
                        <button id="btn_<?=$tipo_doc?>_<?=strtolower($proyectos_item['cve_proyecto'])?><?=$proyectos_item['abrev_tipo_evaluacion']?>" type="submit" class="btn btn-sm d-none" style="background: none; color: #28A745">
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
                switch ($num_docs) {
                case 0:
                    $fondo_actual = 'bg-danger';
                    break;
                case 5:
                    $fondo_actual = 'bg-success';
                    break;
                default:
                    $fondo_actual = 'bg-warning';
                    break;
                } 
            ?>
            <td><span class="badge rounded-pill <?=$fondo_actual?>"><?= $num_docs ?></span></td>
        </tr>
    </tbody>
</table>
