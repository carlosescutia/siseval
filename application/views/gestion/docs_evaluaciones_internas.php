<table class="table table-sm table-bordered border-dark text-center">
    <thead>
        <tr>
            <th scope="col">Justificación de evaluación</th>
            <th scope="col">Docs complementarios</th>
            <th style="width: 10%" scope="col">status</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <?php 
                $num_docs = 0; 
                $arch_requeridos = 0; 
            ?>
            <td>
                <?php
                    $prefijo = 'gje';
                    $icono = "bi-filetype-pdf";
                    $tipo_archivo = 'pdf';
                    $dir_docs = 'doc/';
                    $url_actual = base_url() . "gestion"; 
                    $nombre_archivo = $prefijo . '_' . strtolower($proyectos_item['cve_proyecto']) . '.' . $tipo_archivo ;
                    $nombre_archivo_fs = './' . $dir_docs . $nombre_archivo ;
                    $nombre_archivo_url = base_url() . $dir_docs . $nombre_archivo;
                ?>
                
                <?php if ( file_exists($nombre_archivo_fs) ) { 
                    $num_docs += 1;
                    $arch_requeridos += 1;
                    ?>
                    <p><a href="<?=$nombre_archivo_url?>" target="_blank"><i class="bi <?=$icono?> documento-g"></i></a></p>
                <?php } ?>

                <?php if (in_array('99', $accesos_sistema_rol)) { ?>
                <div class="row">
                    <div class="col text-end">
                        <form method="post" enctype="multipart/form-data" action="<?= base_url() ?>archivos/subir">
                            <label tabindex="0" name="btn_arch_<?=$prefijo?>_<?=strtolower($proyectos_item['cve_proyecto'])?>" id="btn_arch_<?=$prefijo?>_<?=strtolower($proyectos_item['cve_proyecto'])?>"><i class="bi bi-file-plus boton-archivo-sm"></i>
                                <input name="subir_archivo" id="subir_archivo" type="file" class="d-none" onchange="$('#btn_sub_<?=$prefijo?>_<?=strtolower($proyectos_item['cve_proyecto'])?>').removeClass('d-none'); $('#btn_arch_<?=$prefijo?>_<?=strtolower($proyectos_item['cve_proyecto'])?>').addClass('d-none');">
                            </label>
                            <input type="hidden" name="dir_docs" value="<?=$dir_docs?>">
                            <input type="hidden" name="nombre_archivo" value="<?=$nombre_archivo?>">
                            <input type="hidden" name="tipo_archivo" value="<?=$tipo_archivo?>">
                            <input type="hidden" name="url_actual" value="<?=$url_actual?>">
                            <button id="btn_sub_<?=$prefijo?>_<?=strtolower($proyectos_item['cve_proyecto'])?>" type="submit" class="btn btn-sm d-none" style="background: none; color: #28A745">
                                <i class="bi bi-upload boton-subir-sm"></i>
                            </button>
                        </form>
                    </div>
                    <div class="col text-start mt-1">
                        <?php if ( file_exists($nombre_archivo_fs) ) { 
                            $item_eliminar = $nombre_archivo;
                            ?>
                            <a href="#dlg_borrar_archivos" data-bs-toggle="modal" onclick="pass_data('<?=$item_eliminar?>', '<?=$url_actual?>', '<?=$dir_docs?>')" ><i class="bi bi-x-circle boton-eliminar" ></i></a>
                        <?php } ?>
                    </div>
                </div>
                <?php } ?>
            </td>
            <td>
                <?php
                    $prefijo = 'gdc';
                    $icono = "bi-file-zip";
                    $tipo_archivo = 'zip';
                    $nombre_archivo = $prefijo . '_' . strtolower($proyectos_item['cve_proyecto']) . '.' . $tipo_archivo ;
                    $nombre_archivo_fs = './' . $dir_docs . $nombre_archivo ;
                    $nombre_archivo_url = base_url() . $dir_docs . $nombre_archivo;
                ?>
                
                <?php if ( file_exists($nombre_archivo_fs) ) { 
                    $num_docs += 1;
                    ?>
                    <p><a href="<?=$nombre_archivo_url?>" target="_blank"><i class="bi <?=$icono?> documento-g"></i></a></p>
                <?php } ?>

                <?php if (in_array('99', $accesos_sistema_rol)) { ?>
                <div class="row">
                    <div class="col text-end">
                        <form method="post" enctype="multipart/form-data" action="<?= base_url() ?>archivos/subir">
                            <label tabindex="0" name="btn_arch_<?=$prefijo?>_<?=strtolower($proyectos_item['cve_proyecto'])?>" id="btn_arch_<?=$prefijo?>_<?=strtolower($proyectos_item['cve_proyecto'])?>"><i class="bi bi-file-plus boton-archivo-sm"></i>
                                <input name="subir_archivo" id="subir_archivo" type="file" class="d-none" onchange="$('#btn_sub_<?=$prefijo?>_<?=strtolower($proyectos_item['cve_proyecto'])?>').removeClass('d-none'); $('#btn_arch_<?=$prefijo?>_<?=strtolower($proyectos_item['cve_proyecto'])?>').addClass('d-none');">
                            </label>
                            <input type="hidden" name="dir_docs" value="<?=$dir_docs?>">
                            <input type="hidden" name="nombre_archivo" value="<?=$nombre_archivo?>">
                            <input type="hidden" name="tipo_archivo" value="<?=$tipo_archivo?>">
                            <input type="hidden" name="url_actual" value="<?=$url_actual?>">
                            <button id="btn_sub_<?=$prefijo?>_<?=strtolower($proyectos_item['cve_proyecto'])?>" type="submit" class="btn btn-sm d-none" style="background: none; color: #28A745">
                                <i class="bi bi-upload boton-subir-sm"></i>
                            </button>
                        </form>
                    </div>
                    <div class="col text-start mt-1">
                        <?php if ( file_exists($nombre_archivo_fs) ) { 
                            $item_eliminar = $nombre_archivo;
                            ?>
                            &nbsp;
                            <a href="#dlg_borrar_archivos" data-bs-toggle="modal" onclick="pass_data('<?=$item_eliminar?>', '<?=$url_actual?>', '<?=$dir_docs?>')" ><i class="bi bi-x-circle boton-eliminar" ></i></a>
                        <?php } ?>
                    </div>
                </div>
                <?php } ?>
            </td>
            <?php
                if ($arch_requeridos > 0) {
                    $fondo_actual = 'bg-success';
                } else {
                    $fondo_actual = 'bg-danger';
                } 
            ?>
            <td><span class="badge rounded-pill <?=$fondo_actual?>"><?= $num_docs ?></span></td>
        </tr>
    </tbody>
</table>
