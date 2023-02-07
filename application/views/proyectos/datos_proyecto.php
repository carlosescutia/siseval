<div class="card mt-0 mb-3 tabla-datos">
    <div class="card-body">
        <table class="table table-striped tabla-datos">
            <tbody>
                <tr>
                    <td>Clave programa presupuestario</td>
                    <td><?= $programa['cve_programa'] ?></td>
                </tr>
                <tr>
                    <td>Nombre programa presupuestario</td>
                    <td><?= $programa['nom_programa'] ?></td>
                </tr>
                <tr>
                    <td>Presupuesto aprobado</td>
                    <td>$ <?= number_format($proyecto['presupuesto_aprobado'], 2) ?></td>
                </tr>
                <tr>
                    <td>Tipo de gasto</td>
                    <td><?= $proyecto['cve_tipo_gasto'] ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>