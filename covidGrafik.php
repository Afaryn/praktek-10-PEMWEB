<?php
// Koneksi ke database
$host = 'localhost';
$username = 'root';
$password = 'admin';
$database = 'covid_data';

$koneksi = mysqli_connect($host, $username, $password, $database);

// Mengambil data dari database
$query = mysqli_query($koneksi, "SELECT Country, TotalCases, TotalDeaths, TotalRecovered, ActiveCases, TotalTests FROM covid_stats ORDER BY TotalCases DESC LIMIT 10");

$labels = array();
$dataCases = array();
$dataDeaths = array();
$dataRecovered = array();
$dataActiveCases = array();
$dataTests = array();

while ($row = mysqli_fetch_assoc($query)) {
    $labels[] = $row['Country'];
    $dataCases[] = $row['TotalCases'];
    $dataDeaths[] = $row['TotalDeaths'];
    $dataRecovered[] = $row['TotalRecovered'];
    $dataActiveCases[] = $row['ActiveCases'];
    $dataTests[] = $row['TotalTests'];
}

// Mengonversi data menjadi format JSON
$labels_json = json_encode($labels);
$dataCases_json = json_encode($dataCases);
$dataDeaths_json = json_encode($dataDeaths);
$dataRecovered_json = json_encode($dataRecovered);
$dataActiveCases_json = json_encode($dataActiveCases);
$dataTests_json = json_encode($dataTests);

mysqli_close($koneksi);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Membuat Grafik Menggunakan Chart.js</title>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div style="width: 800px; height: 800px;">
        <!-- Line Chart -->
        <canvas id="lineChart"></canvas>
    </div>

    <div style="width: 800px; height: 800px;">
        <!-- Bar Chart -->
        <canvas id="barChart"></canvas>
    </div>

    <div style="width: 800px; height: 800px;">
        <!-- Pie Chart -->
        <canvas id="pieChart"></canvas>
    </div>

    <div style="width: 800px; height: 800px;">
        <!-- Doughnut Chart -->
        <canvas id="doughnutChart"></canvas>
    </div>

    <script>
        // Line Chart
        var ctxLine = document.getElementById("lineChart").getContext('2d');
        var lineChart = new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: <?php echo $labels_json; ?>,
                datasets: [
                    {
                        label: 'Total Cases',
                        data: <?php echo $dataCases_json; ?>,
                        fill: false,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Total Deaths',
                        data: <?php echo $dataDeaths_json; ?>,
                        fill: false,
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Total Recovered',
                        data: <?php echo $dataRecovered_json; ?>,
                        fill: false,
                        borderColor: 'rgba(255, 206, 86, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Active Cases',
                        data: <?php echo $dataActiveCases_json; ?>,
                        fill: false,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Total Tests',
                        data: <?php echo $dataTests_json; ?>,
                        fill: false,
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Bar Chart
        var ctxBar = document.getElementById("barChart").getContext('2d');
        var barChart = new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: <?php echo $labels_json; ?>,
                datasets: [
                    {
                        label: 'Total Cases',
                        data: <?php echo $dataCases_json; ?>,
                        backgroundColor: 'rgba(255, 99, 132, 0.5)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Total Deaths',
                        data: <?php echo $dataDeaths_json; ?>,
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Total Recovered',
                        data: <?php echo $dataRecovered_json; ?>,
                        backgroundColor: 'rgba(255, 206, 86, 0.5)',
                        borderColor: 'rgba(255, 206, 86, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Active Cases',
                        data: <?php echo $dataActiveCases_json; ?>,
                        backgroundColor: 'rgba(75, 192, 192, 0.5)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Total Tests',
                        data: <?php echo $dataTests_json; ?>,
                        backgroundColor: 'rgba(153, 102, 255, 0.5)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Pie Chart
        var ctxPie = document.getElementById("pieChart").getContext('2d');
        var pieChart = new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: <?php echo $labels_json; ?>,
                datasets: [{
                    label: 'Total Cases',
                    data: <?php echo $dataCases_json; ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(153, 102, 255, 0.5)',
                        'rgba(255, 159, 64, 0.5)',
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(75, 192, 192, 0.5)'
                    ],
                    borderWidth: 1
                }]
            }
        });

        // Doughnut Chart
        var ctxDoughnut = document.getElementById("doughnutChart").getContext('2d');
        var doughnutChart = new Chart(ctxDoughnut, {
            type: 'doughnut',
            data: {
                labels: <?php echo $labels_json; ?>,
                datasets: [{
                    label: 'Total Cases',
                    data: <?php echo $dataCases_json; ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(153, 102, 255, 0.5)',
                        'rgba(255, 159, 64, 0.5)',
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(75, 192, 192, 0.5)'
                    ],
                    borderWidth: 1
                }]
            }
        });
    </script>
</body>
</html>
