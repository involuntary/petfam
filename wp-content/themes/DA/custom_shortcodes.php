<?php

function daystuntilflorida() {

	$now = time(); // or your date as well
	$your_date = strtotime("2017-02-01");
	$datediff = $your_date - $now;
	$daysuntil =  floor($datediff / (60 * 60 * 24));

	echo "<h2> Don't worry, only <strong>". $daysuntil . "</strong> days until holidays!</h2>";









}

add_shortcode('daystuntilflorida', 'daystuntilflorida');



 ?>
