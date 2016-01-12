<?php
	//lehe nimi
	$page_title="Avaleht";
	
	//faili nimi
	$page_file_name="home.php";
?>

<?php require_once ("./header.php"); ?>


	<h1> Avaleht </h1>

<?php 
	require_once("functions.php");
	
	
	//kasutaja muudab andmeid
	if(isset($_GET["update"])){
		
		//
		updateVideoData($_GET["video_id"]);
	}
	
	
	
	//kõik objektide kujul massiivis
	$video_array=getAllVideos();
	
	$keyword="";
	if(isset($_GET["keyword"])){
		$keyword=$_GET["keyword"];
		
		//otsime
		$video_array=getAllVideos($keyword);
		
	}else{
		//näitame kõiki tulemusi
		//kõik objektide kujul massiivis
		$video_array=getAllVideos();
	}
	
?>


<h2>Videote tabel</h2>
<form action="home.php" method="get">
	<input name="keyword" type="search" value="<?=$keyword?>" >
	<input type="submit" value="otsi"> 
</form>

<br>
<table border=1>
<tr>

	<th>Video URL</th>
	<th>Pealkiri</th>
	<th>Märksõnad</th>
	
	<?php 
	if(isset($_SESSION['logged_in_user_id'])){
		echo "<th>Muuda</th>";
	}?>

</tr>

<?php 
	
	//ükshaaval läbi käia
	for($i=0; $i<count($video_array); $i++){
		
		//kasutaja tahab rida muuta
		if(isset($_GET["edit"]) && $_GET["edit"]==$video_array[$i]->id){
			echo "<tr>";
			echo "<form action='data.php' method='get'>";
			
			//input mida välja ei näidata 
			echo "<input type='hidden' name='video_id' value='".$video_array[$i]->id."'>";
			
			echo "<td><input name='url' type='text' value='".$video_array[$i]->url."'></td>";
			
			echo "<td><input name='title' value=".$video_array[$i]->title."></td>";
			
			echo "<td><input name='keywords' value=".$video_array[$i]->keywords."></td>";
			
			echo "<td><input name='update' type='submit'></td>";
			echo "<td><a href='data.php'>Katkesta</a></td>";
			echo "</form>";
			echo "</tr>";
			
		}else{
		
			//lihtne vaade
			echo "<tr>";
			echo "<td>".$video_array[$i]->url."</td>";
			echo "<td>".$video_array[$i]->title."</td>";
			echo "<td>".$video_array[$i]->keywords."</td>"; 
			if(isset($_SESSION['logged_in_user_id'])){
				echo "<td><a href='?edit=".$video_array[$i]->id."'>Edit</a></td>";
			}
			echo "</tr>";
		}
	}

?>

</table>

<?php require_once ("./footer.php"); ?>