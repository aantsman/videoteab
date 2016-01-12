<?php

    require_once("../config_global.php");
    $database = "if15_anniant";
    
    //paneme sessiooni serveris tööle, saaame kasutada SESSION[]
    session_start();
    
    
    function logInUser($email, $hash){
        
        // GLOBALS saab kätte kõik muutujad mis kasutusel
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
        
        $stmt = $mysqli->prepare("SELECT id, email FROM user_sample WHERE email=? AND password=?");
        $stmt->bind_param("ss", $email, $hash);
        $stmt->bind_result($id_from_db, $email_from_db);
        $stmt->execute();
        if($stmt->fetch()){
            echo "Kasutaja logis sisse id=".$id_from_db;
            
            // sessioon, salvestatakse serveris
            $_SESSION['logged_in_user_id'] = $id_from_db;
            $_SESSION['logged_in_user_email'] = $email_from_db;
            
            //suuname kasutaja teisele lehel
            header("Location: data.php");
            
        }else{
            echo "Wrong credentials!";
			var_dump ($id_from_db." / ".$email_from_db);
        }
        $stmt->close();
        
        $mysqli->close();
        
    }
    
    
    function createUser($create_email, $hash, $create_username){
        
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password, username, created) VALUES (?,?,?,NOW())");
        $stmt->bind_param("sss", $create_email, $hash, $create_username);
        $stmt->execute();
        $stmt->close();
        
        $mysqli->close();
        
    }
	
	function createVideo($url, $title, $keywords){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["username"], $GLOBALS["password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO videos (url, title, keywords) VALUES (?,?,?)");
		$stmt->bind_param("sss", $url, $title, $keywords);
		
		$message="";
		
		//kui õnnestub siis tõene kui viga siis else
		if ($stmt->execute()){
			//õnnestus
			$message="Video edukalt andmebaasi salvestatud";
		}
		
		$stmt->close();
		$mysqli->close();
		
		return $message;
	}
	
	//vaikeväärtus sulgudes, et vältida errorit, mis tekiks
    function getAllVideos($keyword=""){
		
		//OTSIMINE
		$search="";
		
        if($keyword == ""){
			//ei otsi
			$search="%%";
			
		}else{
			//otsime
			$search="%".$keyword."%";
		}
		
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		
        $stmt = $mysqli->prepare("SELECT id, url, title, keywords FROM videos WHERE (title LIKE ? OR keywords LIKE ?)");
		$stmt->bind_param("ss", $search, $search);
        $stmt->bind_result($id_from_db, $url_from_db, $title_from_db, $keywords_from_db);
        $stmt->execute();
        
		//massiiv kus hoiame
		$array=array();
		
        // iga rea kohta mis on ab'is teeme midagi
        while($stmt->fetch()){
			//suvaline muutuja kus hoiame andmeid kuni massiivi lisamiseni
			
			//tühi objekt kus hoiame väärtusi
			$video=new StdClass();
			
			$video->id=$id_from_db;
			$video->url=$url_from_db;
			$video->title=$title_from_db;
			$video->keywords=$keywords_from_db;

			
			//lisan massiivi
			array_push($array, $video);
			/*echo "<pre>";
			var_dump($array);
			echo "</pre>";*/
        }
		
		//saadan array tagasi
		return $array;

        
        $stmt->close();
        $mysqli->close();
    }
	
	function updateVideoData($video_id, $video_url, $video_title, $video_keywords){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		
		
        $stmt = $mysqli->prepare("UPDATE videos SET url=?, title= ?, keywords=?  WHERE id=?");
        $stmt->bind_param("sssi", $video_url, $video_title, $video_keywords, $video_id);
        $stmt->execute();
		
		//tühjendame aadressirea
		
		$stmt->close();
		$mysqli->close();
		
	}
    
    
 ?>