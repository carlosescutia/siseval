<main role="main" class="ml-sm-auto px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h2>Reportes</h2>
    </div>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6">
                <h3>Listados</h3>
                <?php if (in_array('04101', $accesos_sistema_rol)) include "btn_listado_programas_agenda_evaluacion_01.php" ?>
                <?php include "btn_listado_propuestas_evaluacion_01.php"; ?>
                <?php include "btn_listado_bitacora_01.php"; ?>
            </div>
        </div>
    </div>

    <hr />

</main>
