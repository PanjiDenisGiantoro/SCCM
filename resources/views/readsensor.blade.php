<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Sensor Motor</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<!-- ... kode <head> tetap sama ... -->

<body class="bg-light">
<div class="container mt-4">
    <h2 class="text-center mb-4">Data Sensor Motor</h2>

    <div class="row">
        <!-- Grafik per sensor -->
        <div class="col-md-6 mb-4">
            <div class="card shadow p-3">
                <h5>Listrik (V)</h5>
                <canvas id="chartListrik"></canvas>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card shadow p-3">
                <h5>RPM</h5>
                <canvas id="chartRPM"></canvas>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card shadow p-3">
                <h5>Vibrasi</h5>
                <canvas id="chartVibrasi"></canvas>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card shadow p-3">
                <h5>Suhu (°C)</h5>
                <canvas id="chartSuhu"></canvas>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card shadow p-3">
                <h5>Axis</h5>
                <canvas id="chartAxis"></canvas>
            </div>
        </div>

        <!-- Tabel Data -->
        <div class="col-12">
            <div class="card shadow p-3">
                <div class="card-body">
                    <h5 class="card-title">Tabel Data Sensor</h5>
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Listrik (V)</th>
                            <th>RPM</th>
                            <th>Vibrasi</th>
                            <th>Suhu (°C)</th>
                            <th>Axis</th>
                            <th>Waktu</th>
                        </tr>
                        </thead>
                        <tbody id="sensorData"></tbody>
                    </table>
                    <div id="paginationLinks" class="text-center"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function loadSensorData(page = 1) {
        $.ajax({
            url: '{{ url('getSeonsor') }}?page=' + page,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                let tableData = '';
                let counter = (response.current_page - 1) * response.per_page;

                response.data.forEach((sensor, index) => {
                    tableData += `
                        <tr>
                            <td>${counter + index + 1}</td>
                            <td>${sensor.listrik}</td>
                            <td>${sensor.rpm}</td>
                            <td>${sensor.vibrasi}</td>
                            <td>${sensor.suhu}</td>
                            <td>${sensor.axis}</td>
                            <td>${sensor.created_at}</td>
                        </tr>
                    `;
                });

                $('#sensorData').html(tableData);

                let pagination = '';
                for (let i = 1; i <= response.last_page; i++) {
                    pagination += `<a href="#" class="btn btn-sm btn-outline-primary pagination-link mx-1" data-page="${i}">${i}</a>`;
                }
                $('#paginationLinks').html(pagination);

                $('.pagination-link').click(function (e) {
                    e.preventDefault();
                    loadSensorData($(this).data('page'));
                });
            }
        });
    }

    loadSensorData();
    setInterval(() => loadSensorData(), 5000);
</script>

<script>
    const chartConfigs = (label, color) => ({
        type: 'line',
        data: { labels: [], datasets: [{ label: label, borderColor: color, data: [], fill: false }] },
        options: {
            responsive: true,
            scales: {
                x: { title: { display: true, text: 'Waktu' } },
                y: { title: { display: true, text: label } }
            }
        }
    });

    const ctxListrik = document.getElementById('chartListrik').getContext('2d');
    const ctxRPM = document.getElementById('chartRPM').getContext('2d');
    const ctxVibrasi = document.getElementById('chartVibrasi').getContext('2d');
    const ctxSuhu = document.getElementById('chartSuhu').getContext('2d');
    const ctxAxis = document.getElementById('chartAxis').getContext('2d');

    const chartListrik = new Chart(ctxListrik, chartConfigs('Listrik (V)', 'red'));
    const chartRPM = new Chart(ctxRPM, chartConfigs('RPM', 'blue'));
    const chartVibrasi = new Chart(ctxVibrasi, chartConfigs('Vibrasi', 'green'));
    const chartSuhu = new Chart(ctxSuhu, chartConfigs('Suhu (°C)', 'orange'));
    const chartAxis = new Chart(ctxAxis, chartConfigs('Axis (°C)', 'yellow'));

    function updateCharts() {
        $.ajax({
            url: '{{ url('getSeonsor') }}',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                const labels = [], listrik = [], rpm = [], vibrasi = [], suhu = [], axis = [];

                response.data.forEach(sensor => {
                    labels.push(new Date(sensor.created_at).toLocaleTimeString());
                    listrik.push(parseFloat(sensor.listrik));
                    rpm.push(parseFloat(sensor.rpm));
                    vibrasi.push(parseFloat(sensor.vibrasi));
                    suhu.push(parseFloat(sensor.suhu));
                    axis.push(parseFloat(sensor.axis));
                });

                // Update each chart
                [chartListrik, chartRPM, chartVibrasi, chartSuhu,chartAxis].forEach(chart => {
                    chart.data.labels = labels;
                });

                chartListrik.data.datasets[0].data = listrik;
                chartRPM.data.datasets[0].data = rpm;
                chartVibrasi.data.datasets[0].data = vibrasi;
                chartSuhu.data.datasets[0].data = suhu;
                chartAxis.data.datasets[0].data = axis;

                chartListrik.update();
                chartRPM.update();
                chartVibrasi.update();
                chartSuhu.update();
                chartAxis.update();
            }
        });
    }

    updateCharts();
    setInterval(() => updateCharts(), 5000);
</script>

</body>
</html>

