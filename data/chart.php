<?php
require "../connection.php";
require "../select.php";
require "../header.php";

session_start();

$codlog = selectFrom("select codf from utilizatori where username = '".$_SESSION['user']."'", 1);
$_SESSION['previous'] = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

$allowed = array(4, 7);
if (!isset($_SESSION['user']) || !in_array($codlog, $allowed)){
    header("location:../index.php");
}
if (!isset($_GET['tab'])){
    header("location:../data/ang.php");
}

if (isset($_POST['gen'])) {
    $tab = $_GET['tab'];
    $data = $_POST['data'];
    $chart = $_POST['chart'];
    $title = $chart . " " . $data . " " . $tab;
    $column = match ($tab) {
        "angajat" => match ($data) {
            "Localitati" => "localitate",
            "Judete" => "judet",
            "Tari" => "tara",
            "Functii" => "codf"
        },
        "autoturism" => match ($data) {
            "Modele" => "model",
            "Versiuni" => "versiune",
            "Culori" => "culoare",
            "Jante" => "jante",
            "Interior" => "interior",
            "Autopilot" => "autopilot",
            "Nr. Usi" => "nr_usi",
            "Tractiune" => "tractiune",
            "Baterii" => "baterie"
        },
        "client" => match ($data){
            "Localitati" => "localitate",
            "Judete" => "judet",
            "Tari" => "tara"
        },
        "logs" => match ($data){
            "Utilizatori" => "username",
            "Actiuni" => "actiune",
            "Functii" => "codf"
        },
        "service" => match ($data){
            "Modele" => "model",
            "Produse" => "denp",
            "Angajati" => "angajat",
            "Stari" => "stare",
            "Garantie" => "garantie"
        },
        "utilizatori" => match ($data){
          "Functii" => "codf"
        },
        "vanzare" => match ($data){
            "Tip produse" => "tipprod",
            "Produse" => "prod",
            "Angajati" => "angajat"
        }
    };
    $result = selectFrom("SELECT " . $column . " as data, count(*) as number FROM " . $tab . " GROUP BY " . $column . ";", 2);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $title;?></title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart(listener)
        {
            let data = google.visualization.arrayToDataTable([
                ['', ''],
                <?php
                foreach ($result as $row)
                {
                    if ($column == "codf")
                        echo "['".selectFrom("select denf from functie where codf = " . $row["data"], 1)."', ".$row["number"]."],";
                    elseif ($column == "autopilot" || $column == "garantie"){
                        if ($row["data"] == 1)
                            echo "['Da', ".$row["number"]."],";
                        else
                            echo "['Nu', ".$row["number"]."],";
                    }
                    else
                        echo "[\"".$row["data"]."\", ".$row["number"]."],";
                }
                ?>
            ]);
            let options = {
                title: '<?php echo $title;?>',
                is3D: true,
                pieHole: 0.4
            };

            let chart = new google.visualization.PieChart(document.getElementById('chart'));
            switch ('<?php echo $chart; ?>') {
                case "BarChart":
                    chart = new google.visualization.BarChart(document.getElementById('chart'));
                    break;
                case "PieChart":
                    chart = new google.visualization.PieChart(document.getElementById('chart'));
                    break;
                case "ColumnChart":
                    chart = new google.visualization.ColumnChart(document.getElementById('chart'));
                    break;
                case "SteppedAreaChart":
                    chart = new google.visualization.SteppedAreaChart(document.getElementById('chart'));
                    break;
            }

            google.visualization.events.addListener(chart, 'ready', function () {
                document.getElementById("download").setAttribute("href", chart.getImageURI());
            });
            chart.draw(data, options);
        }
    </script>
</head>
<body>
<br/><br/>

    <div id="chart" style="width: 900px; height: 500px; display: block; margin: 0 auto;"></div>

<br/>
    <a id="download" href="/" download style="text-decoration: none;">
        <input name="adauga" type="button" id="down" value="Descarca PNG">
    </a>


</body>
</html>