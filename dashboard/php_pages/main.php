<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="refresh" content="5"/>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>pYSF3 C4FM Multi Streams Reflector</title>
	<meta name="author" content="IU5JAE, IK5XMK, grupporadiofirenze.net">
	<meta name="copyright" content="open source software for hamradio">
	<meta name="keywords" content="c4fm, reflector, ysf protocol, yaesu, gruppo radio firenze">
	<style>
	a:link {
		text-decoration: none;
	}
	a:visited {
		text-decoration: none;
	}
	a:hover {
	text-decoration: none;
	}
	a:active {
		text-decoration: none;
	}
	</style>
  </head>
  
  <body>
  
<div class="pos-f-t">
  <div class="collapse" id="navbarToggleExternalContent">
    <div class="bg-light p-4">
      <h4 class="text-black">Menu</h4>
      <!-- <span class="text-muted">Toggleable via the navbar brand.</span> -->
	  <a class="nav-item nav-link text-black" href="./main.php">Main - QSO traffic</a>
      <a class="nav-item nav-link text-black" href="./linked.php">Repeaters, hotspots and bridges linked</a>
      <a class="nav-item nav-link text-black" href="./blocked.php">Callsigns blocked in time</a>
    </div>
  </div>
  <nav class="navbar navbar-light bg-white">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
		<a class="navbar-brand" href="#">
			<img src="http://xlx039.dmrbrescia.it/db/img/logo_bm2222.jpg" width="100" height="100" alt="BM2222"> <!-- set image path and description -->
		</a>
    </button>
	<span class="navbar-text">
		<a class="text-dark" href="http://www.grupporadiofirenze.net"><button type="button" class="btn btn-primary">pYSF3 C4FM Multi Streams Reflector</button></a>
	</span>	
  </nav>
</div>
  
<div>	
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Status</th>
      <th scope="col">Call</th>
      <th scope="col">Gateway</th>
      <th scope="col">Description</th>
      <th scope="col">Radio</th>
      <th scope="col">Serial</th>
      <th scope="col">Target</th>
      <th scope="col">GID</th>
      <th scope="col">Stream</th>
      <th scope="col">Data_type</th>
      <th scope="col">Call_mode</th>
      <th scope="col">Frame</th>
      <th scope="col">Deviation</th>
      <th scope="col">UTC_Time(QSO)</th>
      <th scope="col">Map</th>
    </tr>
  </thead>
  <tbody>
<?php
// set path/db name
$db = new SQLite3('/opt/pysfreflector/collector3.db');
$res = $db->query('SELECT * FROM streams ORDER BY date_time DESC LIMIT 30');
$nr = 1;
while ($row = $res->fetchArray()) {
    if ($row['status'] == "TX") {
        echo "<tr class='table-success'>";
      } elseif ($row['status'] == "TO"){
		  echo "<tr class='table-danger'>";
      } elseif ($row['status'] == "TD"){
                  echo "<tr class='table-info'>";
      } elseif ($row['status'] == "WD"){
                  echo "<tr class='table-warning'>";
      } elseif ($row['status'] == "TB"){
                  echo "<tr class='table-dark'>";
      } else {
                  echo "<tr>";
      }
	if ($row['latitude'] != "") {
		$osm = "<button type='button' class='btn btn-outline-dark'><a href='https://www.openstreetmap.org/?mlat=".$row['latitude']."&mlon=".$row['longitude']."' target='_blank'>Show position</a></button>";
	} else {
		$osm ="";
	}
    echo "<th scope='row'>{$nr}</th><td>{$row['status']}/{$row['dgid']}</td><td>{$row['call']}</td><td>{$row['gw']}</td><td>{$row['gid_desc']}</td><td>{$row['radio_code']}</td><td>{$row['radio_id']}</td><td>{$row['target']}</td><td>{$row['SQC']}</td><td>{$row['stream_id']}</td><td>{$row['DT']}</td><td>{$row['CM']}</td><td>{$row['FT']}</td><td>{$row['Dev']}</td><td>{$row['time']}</td><td>{$osm}</td>\n";
	echo "</tr>";
	++$nr;
}
?>
  </tbody>
</table>
</div>

<footer class="bg-light text-center text-lg-start">
  <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
 <?php
$res = $db->query('SELECT * FROM reflector');
$row = $res->fetchArray();
echo "<b>Reflector:</b>#{$row['REF_ID']} <b>Ver:</b> {$row['ver']} <b>Description:</b>{$row['REF_DESC']} <b>Aprs:</b>{$row['APRS_EN']} <b>Active streams:</b>{$row['dgid_list']} <b>Default stream:</b>{$row['dgid_def']} <b>Local stream:</b>{$row['dgid_loc']}";
?>	
    <br>
    <a class="text-dark" href="<?php echo "http://".$row['web']; ?>"><button type="button" class="btn btn-primary">web site</button></a>
    <a class="text-dark" href="<?php echo "mailto:".$row['contact']; ?>"><button type="button" class="btn btn-primary">@</button></a>
  </div>
</footer>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>
