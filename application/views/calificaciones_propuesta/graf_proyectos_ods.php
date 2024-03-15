<div>
    <canvas id="graf_proyectos_ods"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('graf_proyectos_ods');

    var claves = <?php echo json_encode(array_column($num_proyectos_ods, 'cve_objetivo_desarrollo')); ?>;
    var datos = <?php echo json_encode(array_column($num_proyectos_ods, 'num_proyectos_ods')); ?>;
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: claves,
            datasets: [{
                label: 'Proyectos por ODS',
                data: datos,
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
