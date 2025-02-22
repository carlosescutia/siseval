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
            <form method="post" action="<?= base_url() ?>gestion">
                <div class="row">
                    <div class="col-sm-3">
                        <h2>Gestión</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 align-self-center">
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
                            <div class="col-1">
                                <button class="btn btn-success btn-sm">Filtrar</button>
                            </div>
                            <div class="col-9 text-end">
                                <div class="row text-danger">
                                    <?php if ($error) { 
                                    echo $error;
                                    } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <?php foreach ($dependencias as $dependencias_item) { ?>
        <h3 class="header-dependencia"><?= $dependencias_item['nom_dependencia'] ?></h3>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="row fw-bold">
                            <div class="col-sm-3">
                                <p>P/Q</p>
                            </div>
                            <div class="col-sm-3 fw-bold">
                                <p>Objetivo</p>
                            </div>
                            <div class="col-sm-1 fw-bold">
                                <p>Monto de contratación</p>
                            </div>
                            <div class="col-sm-2 fw-bold">
                                <p>Tipo - Proponente</p>
                            </div>
                            <div class="col-sm-3 text-center">
                                <p>Documentación</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-5">
                    <?php foreach ($proyectos as $proyectos_item) { 
                        if ($proyectos_item['cve_dependencia'] == $dependencias_item['cve_dependencia']) { ?>
                            <div class="col-sm-12 alternate-color">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p><a href="<?=base_url()?>gestion/detalle/<?=$proyectos_item['id_propuesta_evaluacion']?>">
                                        <?= $proyectos_item['cve_proyecto'] ?> <?= $proyectos_item['nom_proyecto'] ?>
                                        </a></p>
                                    </div>
                                    <div class="col-sm-3">
                                        <p><a href="<?=base_url()?>gestion/detalle/<?=$proyectos_item['id_propuesta_evaluacion']?>">
                                            <?= $proyectos_item['objetivo'] ?>
                                        </a></p>
                                    </div>
                                    <div class="col-sm-1">
                                        <p><a href="<?=base_url()?>gestion/detalle/<?=$proyectos_item['id_propuesta_evaluacion']?>">
                                            <?= $proyectos_item['monto_contratacion'] ?>
                                        </a></p>
                                    </div>
                                    <div class="col-sm-2">
                                        <p><?= $proyectos_item['nom_tipo_evaluacion'] ?> <?= $proyectos_item['nom_dependencia_propuesta'] ?></p>
                                    </div>
                                    <div class="col-sm-3">
                                        <?php 
                                            if ( in_array($proyectos_item['cve_clasificacion_supervisor'], array('1','2','4','7')) ) {
                                                include 'docs_evaluaciones_externas.php' ;
                                            } else {
                                                include 'docs_evaluaciones_internas.php' ;
                                            } 
                                        ?>
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
