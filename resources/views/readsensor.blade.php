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
<body class="bg-light">
<div class="container mt-4">
    <h2 class="text-center mb-4">Data Sensor Motor</h2>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow p-3">
                <div class="card-body">
                    <canvas id="sensorChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
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
                            <th>Waktu</th>
                        </tr>
                        </thead>
                        <tbody id="sensorData">
                        <!-- Data akan diisi dengan AJAX -->
                        </tbody>
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
                    let page = $(this).data('page');
                    loadSensorData(page);
                });
            }
        });
    }
    loadSensorData();
    setInterval(() => { loadSensorData(); }, 5000);
</script>

<script>
    let ctx = document.getElementById('sensorChart').getContext('2d');
    let sensorChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [
                { label: 'Listrik', borderColor: 'red', data: [], fill: false },
                { label: 'RPM', borderColor: 'blue', data: [], fill: false },
                { label: 'Vibrasi', borderColor: 'green', data: [], fill: false },
                { label: 'Suhu', borderColor: 'orange', data: [], fill: false }
            ]
        },
        options: {
            responsive: true,
            scales: {
                x: { title: { display: true, text: 'Waktu' } },
                y: { title: { display: true, text: 'Sensor Value' } }
            }
        }
    });

    function updateChart() {
        $.ajax({
            url: '{{ url('getSeonsor') }}',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                let labels = [], listrikData = [], rpmData = [], vibrasiData = [], suhuData = [];
                response.data.forEach(sensor => {
                    labels.push(new Date(sensor.created_at).toLocaleTimeString());
                    listrikData.push(parseFloat(sensor.listrik));
                    rpmData.push(parseFloat(sensor.rpm));
                    vibrasiData.push(parseFloat(sensor.vibrasi));
                    suhuData.push(parseFloat(sensor.suhu));
                });

                sensorChart.data.labels = labels;
                sensorChart.data.datasets[0].data = listrikData;
                sensorChart.data.datasets[1].data = rpmData;
                sensorChart.data.datasets[2].data = vibrasiData;
                sensorChart.data.datasets[3].data = suhuData;
                sensorChart.update();
            }
        });
    }
    updateChart();
    setInterval(() => { updateChart(); }, 5000);
</script>

</body>
</html>
