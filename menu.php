<h3>Men��</h3>

<ul>
	<?php
	// �ksk�ik mis lehe puhul n�itan linki aga kui on home leht siis nime
	if($page_file_name != "home.php") { ?>
	<li><a href="home.php">Avaleht</a></li>
	<?php } else {  ?>
		<li> Avaleht </li>
	<?php } ?>
	
	<?php
	// �ksk�ik mis lehe puhul n�itan linki aga kui on home leht siis nime
	if($page_file_name != "login.php") { ?>
	<li><a href="login.php">Logi sisse</a></li>
	<?php } else {  ?>
		<li> Logi sisse </li>
	<?php } ?>
	
	<?php
	// �ksk�ik mis lehe puhul n�itan linki aga kui on home leht siis nime
	if($page_file_name != "data.php") { ?>
	<li><a href="data.php">Lisa video</a></li>
	<?php } else {  ?>
		<li> Lisa video</li>
	<?php } ?>
	
</ul>