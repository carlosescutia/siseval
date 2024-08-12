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

        <!-- bootstrap 5.3 
        <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        -->

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
                <div class="col-sm-7">
                <h5 class="my-0 mr-md-auto texto-titulo">Sistema de Evaluación de Guanajuato</h5>
                    <hr class="mb-0 mt-2 pt-0 pb-0 " />
                    <ul class="navbar-nav mr-auto">
                        <?php foreach ($opciones_sistema as $opciones_sistema_item) {
                            if ( in_array($opciones_sistema_item['cod_opcion'], $permisos_usuario) 
                                && $opciones_sistema_item['es_menu'] ) { ?>
                                <li class="nav-item d-print-none"><a class="nav-link" href="<?=base_url()?><?=$opciones_sistema_item['url'] ?>"><?=$opciones_sistema_item['nom_opcion'] ?></a></li>
                            <?php } 
                        } ?>
                    </ul>
                </div>
                <div class="col-sm-5 text-end d-print-none">
                    <p class="m-2 texto-titulo"><?php echo $nom_usuario ?> · <?php echo $nom_dependencia ?> | <a class="m-2 texto-titulo" href="<?= base_url() ?>inicio/cerrar_sesion">Cerrar sesión</a></p>
                </div>
            </div> <!-- opciones del menu -->
        </nav>
        <div class="container-fluid">
        <div class="printer_margin d-none d-print-block">
        </div>
