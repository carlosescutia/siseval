<main role="main" class="ml-sm-auto px-4 mb-3">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1>Catálogos</h1>
    </div>
    <div class="row">
        <div class="col-md-9 p-3">
            <h2>Aplicación</h2>
            <div class="row mb-3">
                <div class="col-md-4">
                    <?php include "dependencias/boton.php" ?>
                </div>
                <div class="col-md-4">
                    <?php include "clasificaciones_supervisor/boton.php" ?>
                </div>
                <div class="col-md-4">
                    <?php include "justificaciones_evaluacion/boton.php" ?>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <?php include "probabilidades_inclusion/boton.php" ?>
                </div>
                <div class="col-md-4">
                    <?php include "tipos_evaluacion/boton.php" ?>
                </div>
            </div>
        </div>
        <div class="col-md-3 p-3 border bg-light">
            <h2>Sistema</h2>
            <div class="row mb-3">
                <div class="col-md-12">
                    <?php include "usuarios/boton.php" ?>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <?php include "roles/boton.php" ?>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <?php include "opciones_sistema/boton.php" ?>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <?php include "accesos_sistema/boton.php" ?>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <?php include "parametros_sistema/boton.php" ?>
                </div>
            </div>
        </div>
    </div>
</main>
