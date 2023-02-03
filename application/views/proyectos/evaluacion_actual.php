<div class="card mt-0 mb-3 tabla-datos">
    <div class="card-header text-white bg-primary">Ejercicio 2023</div>
    <div class="card-body">
        <form>
            <div class="row mb-3">
                <div class="col-sm-6">
                    <label for="tipo">Tipo</label>
                    <select class="form-select" name="tipo" id="tipo">
                        <option value=""></option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <label for="anios_ejecucion">Años de ejecución</label>
                    <select class="form-select" name="anios_ejecucion" id="anios_ejecucion">
                        <option value=""></option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <label for="duracion">Duración</label>
                    <select class="form-select" name="duracion" id="duracion">
                        <option value=""></option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-6">
                    <label for="justificacion">Justificación</label>
                    <select class="form-select" name="justificacion" id="justificacion">
                        <option value=""></option>
                    </select>
                </div>
                <div class="col-sm-6">
                    <label for="objetivo">Objetivo</label>
                    <textarea rows="4" class="form-control" name="objetivo" id="objetivo" readonly></textarea>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="recursos_propios">¿Recursos propios?</label>
                    <select class="form-select" name="recursos_propios" id="recursos_propios">
                        <option value=""></option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <label for="monto">Monto</label>
                    <input type="text" class="form-control" name="monto" id="monto">
                </div>
                <div class="col-sm-6">
                    <label for="observaciones">Observaciones</label>
                    <textarea rows="4" class="form-control" name="observaciones" id="observaciones" readonly></textarea>
                </div>
            </div>
        </form>
    </div>
    <?php if (in_array('99', $accesos_sistema_rol)) { ?>
    <div class="card-footer text-end">
        <form method="post" action="<?= base_url() ?>evaluacion_actual/guardar/">
            <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
        </form>
    </div>
    <?php } ?>
</div>
