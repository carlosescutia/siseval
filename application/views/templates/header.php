<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="icon" href="<?=base_url()?>img/favicon.png" sizes="16x16" type="image/png" />

        <title>Sistema de Evaluación de Guanajuato</title>

        <!-- global css -->
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>css/base.css" />
        <!-- app css -->
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>css/siseval.css" />

        <!-- bootstrap 5.3 -->
        <link href="<?=base_url()?>css/bootstrap.min.css" rel="stylesheet"/>
        <link href="<?=base_url()?>css/bootstrap-icons.css" rel="stylesheet"/>
        <script src="<?=base_url()?>js/bootstrap.bundle.min.js"></script>

        <!-- jquery -->
        <script src="<?=base_url()?>js/jquery-3.6.3.min.js"></script>
    </head>
    <body>
        <nav class="navbar navbar-expand-sm navbar-light fixed-top d-print-none pr-3">
            <!-- logo -->
            <div class="logo_menu">
                <img class="logo" src="<?=base_url()?>img/gto_iplaneg.png" class="d-inline-block align-top" alt="iplaneg">
            </div> <!-- logo -->

            <!-- boton para menu colapsado (pantallas pequeñas) -->
            <button class="navbar-toggler navbar-toggler-right pr-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" >
                <span class="navbar-toggler-icon"></span>
            </button> <!-- boton menu -->

            <!-- opciones del menu -->
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="col-sm-7 mt-2">
                    <div class="row">
                        <div class="col">
                            <h5 class="my-0 mr-md-auto texto-titulo">Sistema de Evaluación de Guanajuato</h5>
                        </div>
                        <div class="col">
                            <form method="post" name="frm_update_anio" action="<?= base_url() ?>Inicio/update_anio_sesion">
                                <select class="form-select text-primary-emphasis bg-primary-subtle fw-bold" name="anio_sesion" id="anio_sesion" onchange="frm_update_anio.submit()">
                                <?php foreach ($userdata['periodos'] as $periodos_item) { ?>
                                    <option value="<?=$periodos_item['periodo']?>" <?= ($periodos_item['periodo'] == $userdata['anio_sesion']) ? 'selected' : ''?> ><?=$periodos_item['periodo']?></option>
                                <?php } ?>
                                </select>
                                <input type="hidden" name="previous_url" value="<?= current_url() ?>">
                            </form>
                        </div>
                    </div>

                    <hr class="mb-0 mt-2 pt-0 pb-0 " />
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item d-print-none"><a class="nav-link" href="<?=base_url()?>">Inicio</a></li>
                        <?php
                            $permisos_usuario = $userdata['permisos_usuario'];
                        ?>
                        <?php
                            $permisos_requeridos = array(
                            'planificacion.can_view',
                            );
                            if (has_permission_or($permisos_requeridos, $permisos_usuario)) { ?>
                                <li class="nav-item d-print-none"><a class="nav-link" href="<?=base_url()?>proyectos">Planificación</a></li>
                            <?php }
                        ?>
                        <?php
                            $permisos_requeridos = array(
                            'gestion.can_view',
                            );
                            if (has_permission_or($permisos_requeridos, $permisos_usuario)) { ?>
                                <li class="nav-item d-print-none"><a class="nav-link" href="<?=base_url()?>gestion">Gestión</a></li>
                            <?php }
                        ?>
                        <?php
                            $permisos_requeridos = array(
                            'ejecucion.can_view',
                            );
                            if (has_permission_or($permisos_requeridos, $permisos_usuario)) { ?>
                                <li class="nav-item d-print-none"><a class="nav-link" href="<?=base_url()?>ejecucion">Ejecución</a></li>
                            <?php }
                        ?>
                        <?php
                            $permisos_requeridos = array(
                            'valoracion.can_view',
                            );
                            if (has_permission_or($permisos_requeridos, $permisos_usuario)) { ?>
                                <li class="nav-item d-print-none"><a class="nav-link" href="<?=base_url()?>valoracion">Valoración</a></li>
                            <?php }
                        ?>
                        <?php
                            $permisos_requeridos = array(
                            'seguimiento.can_view',
                            );
                            if (has_permission_or($permisos_requeridos, $permisos_usuario)) { ?>
                                <li class="nav-item d-print-none"><a class="nav-link" href="<?=base_url()?>seguimiento">Seguimiento</a></li>
                            <?php }
                        ?>
                        <?php
                            $permisos_requeridos = array(
                            'reportes.can_view',
                            );
                            if (has_permission_or($permisos_requeridos, $permisos_usuario)) { ?>
                                <li class="nav-item d-print-none"><a class="nav-link" href="<?=base_url()?>reportes">Reportes</a></li>
                            <?php }
                        ?>
                        <?php
                            $permisos_requeridos = array(
                            'catalogos.can_view',
                            );
                            if (has_permission_or($permisos_requeridos, $permisos_usuario)) { ?>
                                <li class="nav-item d-print-none"><a class="nav-link" href="<?=base_url()?>catalogos">Catálogos</a></li>
                            <?php }
                        ?>
                    </ul>
                </div>
                <div class="col-sm-5 text-end d-print-none">
                    <p class="m-2 texto-titulo"><?= $userdata['nom_usuario'] ?> · <?= $userdata['nom_dependencia'] ?> | <a class="m-2 texto-titulo" href="<?= base_url() ?>inicio/cerrar_sesion">Cerrar sesión</a></p>
                </div>
            </div> <!-- opciones del menu -->
        </nav>
        <div class="container-fluid">
            <div class="printer_margin d-none d-print-block">
            </div>

<script>
    function update_anio_sesion() {

    }
</script>
