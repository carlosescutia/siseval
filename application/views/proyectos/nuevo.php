<?php
    $permisos_usuario = $userdata['permisos_usuario'];
    $cve_dependencia = $userdata['cve_dependencia'];
    $nom_dependencia = $userdata['nom_dependencia'];
    $anio_sesion = $userdata['anio_sesion'];
    $cve_rol = $userdata['cve_rol'];
?>
<main role="main" class="ml-sm-auto px-4">

    <form method="post" action="<?= base_url() ?>proyectos/guardar">

        <div class="col-md-12 mb-3 pb-2 pt-3 border-bottom">
            <div class="row">
                <div class="col-md-10">
                    <h1 class="h2">Nuevo proyecto</h1>
                </div>
                <div class="col-md-2 text-end">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group row">
                <label for="nom_proyecto" class="col-sm-2 col-form-label">Nombre del proyecto</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="nom_proyecto" id="nom_proyecto">
                </div>
            </div>
            <div class="form-group row">
                <label for="presupuesto_aprobado" class="col-sm-2 col-form-label">Presupuesto aprobado</label>
                <div class="col-sm-2">
                    <input type="number" class="form-control" name="presupuesto_aprobado" id="presupuesto_aprobado">
                </div>
            </div>
            <div class="form-group row">
                <label for="cve_tipo_gasto" class="col-sm-2 col-form-label">Tipo de gasto</label>
                <div class="col-sm-2">
                    <select class="form-select" name="cve_tipo_gasto" id="cve_tipo_gasto">
                        <option value=""></option>
                        <option value="P">P</option>
                        <option value="Q">Q</option>
                        <option value="PP">PP</option>
                        <option value="Politica">Política</option>
                        <option value="Estrategia">Estrategia</option>
                        <option value="Estudio">Estudio</option>
                        <option value="Diagnostico">Diagnóstico</option>
                        <option value="Ninguno">Ninguno</option>
                    </select>
                </div>
            </div>
        </div>

        <input type="hidden" name="cve_programa" value="PRO<?=$cve_dependencia?>">

    </form>


    <hr />

    <div class="form-group row">
        <div class="col-sm-10">
            <a href="<?=base_url()?>proyectos" class="btn btn-secondary boton">Volver</a>
        </div>
    </div>

</main>
