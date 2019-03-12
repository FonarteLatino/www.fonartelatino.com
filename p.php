<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php 
		$a = "https://open.spotify.com/album/0bIOfmxlbeojmT2WdcH7XH?si=6Nzwv5RrSsm3l7eiZdhmsA";

        $b = "https://open.spotify.com/embed/album/0bIOfmxlbeojmT2WdcH7XH";
        echo $a;
        echo "<br>";
        echo $b;
        echo "<br>";
        $saux = explode("?si=", $a);
        echo count($saux);
        echo "<br>";
        $saux = explode("?si=", $b);
        echo count($saux);
	 ?>
</body>
</html>