<?php
	//lehe nimi
	$page_title="Lisa video";
	
	//faili nimi
	$page_file_name="data.php";
?>

<?php require_once ("./header.php"); ?>

<?php
    // kõik mis seotud andmetabeliga, lisamine ja tabeli kujul esitamine
    require_once("functions.php");
    
    //kui kasutaja ei ole sisse logitud, suuna teisele lehele
    //kontrollin kas sessiooni muutuja olemas
    if(!isset($_SESSION['logged_in_user_id'])){
        header("Location: login.php");
    }
    
    // aadressireale tekkis ?logout=1
    if(isset($_GET["logout"])){
        //kustutame sessiooni muutujad
        session_destroy();
        header("Location: login.php");
    }
	
	
	// muutujad väärtustega
	$m = "";
	$url = "";
	$url_error = "";
	$title = "";
	$title_error = "";
	$keywords = "";
	$keywords_error = "";

	//echo $_SESSION ['logged_in_user_id'];
	
	//echo "kodus: ----".$kodus;
	
	// valideeri
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		
		if(isset($_POST["add_video"])){
			
			if (empty($_POST["url"]))  {
				$url_error = "Video lingi lisamine on kohustuslik";
			}else{
				$url = cleanInput($_POST["url"]);
			}		
			
			if (empty($_POST["title"]))  {
				$title_error = "Video pealkirja määramine on kohustuslik";
			}else{
				$title = cleanInput($_POST["title"]);
			}
			
			if (empty($_POST["keywords"]))  {
				$keywords_error = "Videole märksõnade lisamine on kohustuslik";
			}else{
				$keywords = cleanInput($_POST["keywords"]);
			}			
			
			if($url_error == "" && $title_error == "" && $keywords_error == ""){
				echo "siin";
				$m=createVideo($url, $title, $keywords);
				
				
			}
		}
	}
		
	function cleanInput($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	
	getAllSongs();
	
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
		$song_array=getAllVideos($keyword);
		
	}else{
		//näitame kõiki tulemusi
		//kõik objektide kujul massiivis
		$video_array=getAllVideos();
	}
	
?>

Tere, <?=$_SESSION['logged_in_user_email'];?> <a href="?logout=1">Logi välja</a>

<h2> Lisa uus video</h2>

  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >

	<label for="url"> url </label>
  	<input id="url" name="url" type="text" value="<?=$url; ?>"> <?=$url_error; ?><br><br>
	
	<label for="title"> title </label>
  	<input id="title" name="title" type="text" value="<?=$title; ?>"> <?=$title_error; ?><br><br>
	
	<label for="keywords"> keywords </label>
  	<input id="keywords" name="keywords" type="text" value="<?=$keywords; ?>"> <?=$keywords_error; ?><br><br>
	
	
  	<input type="submit" name="add_video" value="Lisa">
	<p style="color:green;"><?=$m;?></p>
	
  </form> 
  
<?php require_once ("./footer.php"); ?>