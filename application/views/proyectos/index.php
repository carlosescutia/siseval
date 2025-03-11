<?php
    $permisos_usuario = $userdata['permisos_usuario'];
    $cve_dependencia = $userdata['cve_dependencia'];
    $nom_dependencia = $userdata['nom_dependencia'];
    $anio_sesion = $userdata['anio_sesion'];
    $cve_rol = $userdata['cve_rol'];
?>
<main role="main" class="ml-sm-auto px-4">
    <div class="pt-3 pb-2 mb-3 border-bottom">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-3">
                    <h2>Planificación</h2>
                </div>
            </div>
            <div class="col-sm-12 align-self-center mb-2">
                <div class="row">
                    <div class="col-sm-11 align-self-center">
                        <form method="post" action="<?= base_url() ?>proyectos">
                            <div class="row">
                                <div class="col-2">
                                    <select class="form-select form-select-sm" name="cve_dependencia_filtro">
                                        <?php if ($cve_rol != 'usr') { ?>
                                            <option value="%" <?= ($cve_dependencia_filtro == '') ? 'selected' : '' ?> >Todas las dependencias</option>
                                        <?php } ?>
                                        <?php foreach ($dependencias_filtro as $dependencias_filtro_item) { ?>
                                        <option value="<?= $dependencias_filtro_item['cve_dependencia']?>" <?= ($cve_dependencia_filtro == $dependencias_filtro_item['cve_dependencia']) ? 'selected' : '' ?> ><?=$dependencias_filtro_item['nom_dependencia']?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-3">
                                    <select class="form-select form-select-sm" name="anexo_social">
                                        <option value="0" <?= ($anexo_social == '0') ? 'selected' : '' ?> >Todos los proyectos</option>
                                        <option value="1" <?= ($anexo_social == '1') ? 'selected' : '' ?>>Solamente proyectos del anexo social</option>
                                    </select>
                                </div>
                                <div class="col-3">
                                    <select class="form-select form-select-sm" name="evaluaciones_propuestas">
                                        <option value="0" <?= ($evaluaciones_propuestas == '0') ? 'selected' : '' ?> >Con y sin evaluaciones propuestas</option>
                                        <option value="1" <?= ($evaluaciones_propuestas == '1') ? 'selected' : '' ?> >Solamente proyectos con evaluaciones propuestas</option>
                                        <option value="2" <?= ($evaluaciones_propuestas == '2') ? 'selected' : '' ?> >Solamente proyectos sin evaluaciones propuestas</option>
                                    </select>
                                </div>
                                <div class="col-1">
                                    <button class="btn btn-success btn-sm">Filtrar</button>
                                </div>
                                <?php
                                    $permisos_requeridos = array(
                                        'proyecto.can_edit',
                                    );
                                ?>
                                <?php if (has_permission_and($permisos_requeridos, $permisos_usuario)) { ?>
                                    <div class="col-3">
                                        <a class="btn btn-secondary btn-sm" data-bs-toggle="collapse" href="#tablero-dependencia" role="button" aria-expanded="false" aria-controls="tablero-dependencia">
                                            Tablero de dependencia
                                        </a>
                                    </div>
                                <?php } ?>
                            </div>
                        </form>
                    </div>
                    <?php
                        $permisos_requeridos = array(
                            'proyecto.can_edit',
                            'planificacion.etapa_activa',
                            'anio_activo',
                        );
                    ?>
                    <?php if (has_permission_and($permisos_requeridos, $permisos_usuario)) { ?>
                        <div class="col-sm-1 text-end">
                            <form method="post" action="<?= base_url() ?>proyectos/nuevo">
                                <button type="submit" class="btn btn-primary btn-sm">Nuevo</button>
                            </form>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <div class="col-sm-12 mt-3 collapse text-center" id="tablero-dependencia">
                <div class="row">
                    <h4><?= $dependencia['nom_completo_dependencia'] ?></h4>

                    <div class="col-sm-12">
                        <div class="card text-center border-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4 border-end">
                                        <h1><?= $estadisticas_proyectos['num_proyectos'] ?></h1>
                                        <p>Proyectos de la dependencia</p>
                                    </div>
                                    <div class="col-sm-4 border-end">
                                        <h1><?= $estadisticas_proyectos['num_proyectos_propuesta'] ?></h1>
                                        <p>Propuestas de evaluación</p>
                                    </div>
                                    <div class="col-sm-4">
                                        <h1><?= $estadisticas_proyectos['num_propuestas_calificadas'] ?></h1>
                                        <p>Propuestas calificadas</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="row mb-2">
                            <div class="col-sm-6 text-start">
                                <div class="card mt-0 mb-3 border-0 texto-menor">
                                    <div class="card-body">
                                        <?php if ($dependencia['carga_evaluaciones']) { ?>
                                            <p>Actualmente con solicitud de evaluaciones para el ejercicio fiscal</p>
                                            <?php if (has_permission_and($permisos_requeridos, $permisos_usuario)) { ?>
                                                <form method="post" action="<?= base_url() ?>nocarga_evaluaciones/guardar">
                                                    <input type="hidden" name="cve_dependencia" value="<?= $cve_dependencia ?>">
                                                    <input type="hidden" name="periodo" value="<?= $anio_sesion ?>">
                                                    <button class="btn btn-primary" type="submit" >
                                                        No se solicitarán evaluaciones para el ejercicio fiscal
                                                    </button>
                                                </form>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <p>Sin solicitud de evaluaciones para el ejercicio fiscal</p>
                                            <?php if (has_permission_and($permisos_requeridos, $permisos_usuario)) { ?>
                                                <form method="post" action="<?= base_url() ?>nocarga_evaluaciones/eliminar">
                                                    <input type="hidden" name="cve_dependencia" value="<?= $cve_dependencia ?>">
                                                    <input type="hidden" name="periodo" value="<?= $anio_sesion ?>">
                                                    <button class="btn btn-primary" type="submit" >
                                                        Solicitar evaluaciones para el ejercicio fiscal
                                                    </button>
                                                </form>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 text-start">
                                <div class="card mt-0 mb-3 border-0 texto-menor">
                                    <div class="card-body">
                                        <h4>Oficio de solicitud de evaluaciones</h4>
                                        <p>Una vez cargada la propuesta de evaluaciones a realizar en <?=$anio_sesion?>, favor de adjuntar el oficio mediante el que se hace la solicitud.</p>
                                        <p>Cargar un sólo documento en formato PDF incluyendo el oficio y el reporte de propuestas de evaluación.</p>
                                        <p>En caso de no solicitar evaluaciones para el ejercicio fiscal actual, de igual forma le solicitamos cargar el oficio de confirmación.</p>
                                        <p class="text-end">Máximo 9 MB.</p>
                                        <div class="mt-3">
                                            <?php
                                                $prefijo = 'sol_ev' ;
                                                $tipo_archivo = 'pdf';
                                                $nombre_archivo = $prefijo . '_' . $cve_dependencia . '_' . $anio_sesion . '.' . $tipo_archivo;
                                                $dir_docs = './doc/';
                                                $url_actual = base_url() . 'proyectos' ;
                                                $descripcion = 'solicitud evaluacion';
                                            ?>
                                            <?php 
                                                $nombre_archivo_fs = $dir_docs . $nombre_archivo;
                                                $nombre_archivo_url = base_url() . $dir_docs . $nombre_archivo;
                                                if ( file_exists($nombre_archivo_fs) ) { ?>
                                                <a href="<?= $nombre_archivo_url ?>" target="_blank"><span class="mr-2"><img src="<?=base_url()?>img/application-pdf.svg" height="30"></span>Oficio cargado</a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <?php if (has_permission_and($permisos_requeridos, $permisos_usuario)) { ?>
                                        <div class="card-footer text-center">
                                            <form method="post" enctype="multipart/form-data" action="<?=base_url()?>archivos/subir">
                                                <div class="row text-danger">
                                                    <?php if ($error) { 
                                                        echo $error;
                                                    } ?>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <input type="file" class="form-control-file" name="subir_archivo">
                                                    </div>
                                                    <div class="col-md-4 text-end">
                                                        <button type="submit" class="btn btn-primary btn-sm">Subir oficio</button>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="nombre_archivo" value="<?=$nombre_archivo?>">
                                                <input type="hidden" name="dir_docs" value="<?=$dir_docs?>">
                                                <input type="hidden" name="tipo_archivo" value="<?=$tipo_archivo?>">
                                                <input type="hidden" name="url_actual" value="<?=$url_actual?>">
                                                <input type="hidden" name="descripcion" value="<?=$descripcion?>">
                                            </form>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>


    <div class="row">
        <?php foreach ($dependencias as $dependencias_item) { ?>
        <h3 class="header-dependencia"><?= $dependencias_item['nom_dependencia'] ?><span class="h6"><?= ($dependencias_item['carga_evaluaciones']) ? '' : ' - No solicita evaluaciones para el ejercicio fiscal' ?></span></h3>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="row fw-bold">
                            <div class="col-sm-1">
                                <p>Clave PP</p>
                            </div>
                            <div class="col-sm-3">
                                <p>Nombre PP</p>
                            </div>
                            <div class="col-sm-1">
                                <p>Clave P/Q</p>
                            </div>
                            <div class="col-sm-3">
                                <p>Nombre P/Q</p>
                            </div>
                            <div class="col-sm-1 text-center">
                                <p>Periodo</p>
                            </div>
                            <div class="col-sm-1">
                                <p>Presupuesto</p>
                            </div>
                            <div class="col-sm-2 text-center">
                                <p>Status</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-5">
                    <?php foreach ($proyectos as $proyectos_item) { 
                        if ($proyectos_item['cve_dependencia'] == $dependencias_item['cve_dependencia']) { ?>
                            <div class="col-sm-12 alternate-color">
                                <div class="row">
                                    <div class="col-sm-1">
                                        <p><?= $proyectos_item['cve_programa'] ?></p>
                                    </div>
                                    <div class="col-sm-3">
                                        <p><?= $proyectos_item['nom_programa'] ?></p>
                                    </div>
                                    <div class="col-sm-1">
                                        <p><?= $proyectos_item['cve_proyecto'] ?></p>
                                    </div>
                                    <div class="col-sm-3">
                                        <?php if ($err_proyectos) { ?>
                                            <?php if ($err_proyectos['cve_proyecto'] == $proyectos_item['cve_proyecto']) { ?>
                                                <div class="alert alert-warning alert-dismissible fade show texto-menor" role="alert">
                                                    <?= $err_proyectos['error'] ?>
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>
                                            <?php } ?>
                                        <?php } ?>
                                        <p>
                                        <a href="<?=base_url()?>proyectos/detalle/<?=$proyectos_item['id_proyecto']?>"><?= $proyectos_item['nom_proyecto'] ?></a>
                                        <?php if (has_permission_and($permisos_requeridos, $permisos_usuario)) { ?>
                                            <?php if ($cve_dependencia == $proyectos_item['cve_dependencia'] and ($proyectos_item['cve_programa'] == 'PRO'.$cve_dependencia)) { ?>
                                                <?php
                                                $item_eliminar = 'Proyecto: '.$proyectos_item['cve_proyecto']. ' ' .$proyectos_item['nom_proyecto'];
                                                $url = base_url() . "proyectos/eliminar/". $proyectos_item['id_proyecto']; ?>
                                                <a class="ps-3" href="#dlg_borrar" data-bs-toggle="modal" onclick="pass_data('<?=$item_eliminar?>', '<?=$url?>')" ><i class="bi bi-x-circle boton-eliminar" ></i></a>
                                            <?php } ?>
                                        <?php } ?>
                                        </p>
                                    </div>
                                    <div class="col-sm-1 text-center">
                                        <p><?= $proyectos_item['periodo'] ?></p>
                                    </div>
                                    <div class="col-sm-1 text-end">
                                        <p><?= number_format($proyectos_item['presupuesto_aprobado'], 0) ?></p>
                                    </div>
                                    <div class="col-sm-2">
                                        <?php

                                        if ($proyectos_item['evaluaciones_propuestas'] == '0') {
                                            $fondo_actual = 'bg-secondary';
                                        } else{
                                            $fondo_actual = 'bg-primary';
                                        }

                                        $fondo_calificadas = 'bg-dark';
                                        if ($proyectos_item['status_propuesta'] == 'totalmente_calificada') {
                                            $fondo_calificadas = 'bg-success';
                                        }
                                        if ($proyectos_item['status_propuesta'] == 'parcialmente_calificada') {
                                            $fondo_calificadas = 'bg-warning';
                                        }
                                        if ($proyectos_item['status_propuesta'] == 'no_calificada') {
                                            $fondo_calificadas = 'bg-danger';
                                        }
                                        if ($proyectos_item['evaluaciones_propuestas'] == '0') {
                                            $fondo_calificadas = 'bg-secondary';
                                        }

                                        if ($proyectos_item['evaluaciones_previas'] == '0') {
                                            $fondo_previo = 'bg-secondary';
                                        } else{
                                            $fondo_previo = 'bg-primary';
                                        } ?>
                                        <p><span class="badge rounded-pill <?=$fondo_actual?>"><?= $proyectos_item['evaluaciones_propuestas'] ?></span> evaluaciones propuestas<br>
                                        <span class="badge rounded-pill <?=$fondo_calificadas?>"><?= $proyectos_item['propuestas_calificadas'] ?></span> propuestas calificadas<br>
                                        <span class="badge rounded-pill <?=$fondo_previo?>"><?= $proyectos_item['evaluaciones_previas'] ?></span> evaluaciones previas</p>
                                    </div>
                                </div>
                            </div>
                        <?php } 
                     } ?>
                </div>
            </div>
        <?php } ?>
    </div>
    <hr />

</main>
