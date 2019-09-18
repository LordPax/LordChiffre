<?php
	/*===============================================================*\
	
	fonction de chiffrement vigenere : 
	createur : Teddy GAUTHIER
	
	maj 2.1 :
	ajout
		+ boucle de chiffrement
	modification
		~ msg chiffrer affiché en héxadécimal
	supression
		- trait d'union
	maj 2.0 (grosse optimisation) :
	ajout
		+ caractère ascii
		+ retour un méssage chiffré sous forme numérique
	supression
		- tableau "carac, carac2, carac3, nb, nb2, nb3"
	
	maj 1.2 :
	modification
		~ correction de bug
	
	maj 1.1 :
	modification
		~ correction de bug
	
	maj 1.0 :
	ajout
		+ cette fonction
	
	\*===============================================================*/
	function chiffrement($msgClair, $cle1, $tours = 10){
		//$cle = hash('sha256', $cle1); //hshage de la clé en sha256
		$cle = $cle1;
		$msgTaille = strlen($msgClair); //taille du msg
		$cleTaille = strlen($cle); //taille de la cle
		$msgDecomp[0] = null; //msg décomposé
		$cleDecomp[0] = null; //cle décomposé
		$testMsg = null; //juste pour débugger
		$testCle = null; //juste pour débugger
		$code[0] = null;
		$msgCrypt = null;
		
		while($cleTaille < $msgTaille){ //ajustement de la taille de la cle par rapport a celle du msg
			$cle .= $cle;
			$cleTaille = strlen($cle);
		}
		
		for($i = 0; $i < $msgTaille; $i++){ //décomposotion de chaque caractère du msg
			$msgDecomp[$i] = ord($msgClair[$i]); //donne l'équivalent ascii en décimale de chaque caractère
			//$testMsg .= $msgDecomp[$i].'-';
		}
			
		for($i = 0; $i < $cleTaille; $i++){ //décomposotion de chaque caractère de la clé
			$cleDecomp[$i] = ord($cle[$i]); //donne l'équivalent ascii en décimale de chaque caractère
			//$testCle .= $cleDecomp[$i].'-';
		}
		for($i = 0; $i < $msgTaille; $i++) //chiffrement de chaque caractère
			$code[$i] = ($msgDecomp[$i] + $cleDecomp[$i]) % 256;
		for ($j = 0; $j < $tours; $j++) //on rechiffre en boucle
			for($i = 0; $i < $msgTaille; $i++) //chiffrement de chaque caractère
				$code[$i] = ($code[$i] + $cleDecomp[$i]) % 256;
		foreach($code as $k=>$v){ //assemblement du message chiffré
			$z = '0';
			$hex = dechex($v);
			$hexTaille = strlen($hex);
			if($hexTaille == 1)
				$z .= $hex;
			else
				$z = $hex;
			$msgCrypt .= $z;
		}
		
		/*echo'message clair : '.$msgClair.'<br/>';
		echo'message modifier : '.$testMsg.'<br/>';
		echo'cle : '.$cle.'<br/>';
		echo'cle modifier : '.$testCle.'<br/>';
		echo'message taille : '.$msgTaille.'<br/>';
		echo'nombre de tour : '.$j.'<br/>';*/
		
		return $msgCrypt; //msg chiffré
	}
	
	function deChiffrement($msgCrypt, $cle1, $tours = 10){
		//$cle = hash('sha256', $cle1); //hshage de la clé en sha256
		$cle = $cle1;
		$cleDecomp[0] = 0; //clé décomposé
		//$msgDecomp = explode('-', $msgCrypt); //msg décomposé
		$msgDecomp = null;
		
		$cleTaille = strlen($cle); //taille du msg
		$testMsg = null; //juste pour débugger
		$testCle = null; //juste pour débugger
		$msgClair = 'a';
		$code[0] = null;
		$testMsgClair = null;
		$taille = strlen($msgCrypt);
		$nb2 = 1;
		$l = 0;
		$msg2 = null;
		$nb = 2;
		for ($i = 0; $i < $taille; $i++) {
			$msg2 .= $msgCrypt[$i];
			if ($nb2 == $nb) {
				$msgDecomp[$l] = hexdec($msg2);
				$nb2 = 1;
				$msg2 = null;
				$l++;
			}
			else
				$nb2++;
		}
		$msgTaille = count($msgDecomp); //taille du msg
		
		while($cleTaille < $msgTaille){ //ajustement de la taille de la cle par rapport a celle du msg
			$cle .= $cle;
			$cleTaille = strlen($cle);
		}
		
		for($i = 0; $i < $cleTaille; $i++){ //décomposotion de chaque caractère de la clé
			$cleDecomp[$i] = ord($cle[$i]);
			//$testCle .= $cleDecomp[$i].'-';
		}
		for($i = 0; $i < $msgTaille; $i++) //déchiffrement de chaque caractère
			$code[$i] = (256 - $cleDecomp[$i]) + $msgDecomp[$i];
		for ($j = 0; $j < $tours; $j++) //on redéchiffre en boucle
			for($i = 0; $i < $msgTaille; $i++) //déchiffrement de chaque caractère
				$code[$i] = (256 - $cleDecomp[$i]) + $code[$i];
		foreach($code as $k=>$v) {//assemblement du message claire
			$msgClair[$k] = chr($v);
			//$testMsg .= $v.'-';
		}
		
		/*echo'message crypter : '.$msgCrypt.'<br/>';
		echo'cle : '.$cle.'<br/>';
		echo'cle modifier : '.$testCle.'<br/>';
		echo'message taille : '.$msgTaille.'<br/>';
		echo'message clair modifier  : '.$testMsg.'<br/>';
		echo'nombre de tour : '.$j.'<br/>';*/
		
		return $msgClair; //msg déchiffré
	}
	/*function coupe($nb, $msg){
		$taille = strlen($msg);
		$fin[0] = null;
		$nb2 = 1;
		$l = 0;
		$msg2 = null;
		for ($i = 0; $i < $taille; $i++) {
			$msg2 .= $msg[$i];
			if ($nb2 == $nb) {
				$fin[$l] = $msg2;
				$nb2 = 1;
				$msg2 = null;
				$l++;
			}
			else
				$nb2++;
		}
		return $fin;
	}*/
	
	/*$clef = "e65h45h4dr5g4d6r5g4r5hd65h4d65h4d6r5h4ft";
	$msg = "Lorem ipsum dolor sit amet, consectetur adipisicing elit";
	echo'<br/>-----------Teste de ma fonction de chiffrement LordChiffre-----------------<br/><br/>';
	echo 'message crypter : '.chiffrement($msg, $clef, 11).'<br/>';
	echo'<br/>====================================================<br/><br/>';
	echo 'message clair : '.deChiffrement('08f7ee45dd9c49e023cde9f4d41ff4c7eef4e3c1f00011f5e1549cd0ebeb4ee315ebcce154e53a901dece550d9ef49d319c6e3f4d51cf1cc', $clef, 11);
	echo'<br/><br/>';*/
	
	
	// echo hash('sha256', 'teat', 0);
?>
