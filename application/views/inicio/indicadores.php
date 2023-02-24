<div class="card mt-0 mb-3 text-center border-0">
    <div class="card-body">
        <div class="col-sm-12">
            <div class="col-sm-12">
                <div class="row mb-5">
                        <h3><?= $dependencia['nom_completo_dependencia'] ?></h3>
                        <?php if ($dependencia['carga_evaluaciones']) { ?>
                            <p>Actualmente con solicitud de evaluaciones para el ejercicio fiscal</p>
                            <form method="post" action="<?= base_url() ?>dependencias/desactivar_evaluaciones">
                                <input type="hidden" name="cve_dependencia" value="<?= $cve_dependencia ?>">
                                <button class="btn btn-primary" type="submit" >
                                    No se solicitarán evaluaciones para el ejercicio fiscal
                                </button>
                            </form>
                        <?php } else { ?>
                            <p>Sin solicitud de evaluaciones para el ejercicio fiscal</p>
                            <form method="post" action="<?= base_url() ?>dependencias/activar_evaluaciones">
                                <input type="hidden" name="cve_dependencia" value="<?= $cve_dependencia ?>">
                                <button class="btn btn-primary" type="submit" >
                                    Solicitar evaluaciones para el ejercicio fiscal
                                </button>
                            </form>
                        <?php } ?>
                    </form>
                </div>
                <div class="row mb-5">
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
</div>
