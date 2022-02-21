<html>
<head>
</head>

<?php

if( isset($_POST['Usuario'])) {
	Notifica($_POST['Tipo'], $_POST['Usuario'], $_POST[Apontamento] );
}

function Notifca( $Tipo, $Usuario, $Apontamento ) {   

 $cnNotif = new mysqli( "localhost", "lucianor_t01", "treino-0102030405", "lucianor_t01-notif");   
   
 $cmNotif = "SELECT Id FROM Notificacoes WHERE Usuario = '" . $Usuario . "' AND Apontamento = " . $Apontamento . " AND Tipo ='" . $Tipo . "';";   
 $res = $cnNotif->query( $cmNotif );   
    
 // Existe notificação   
 if( $res->num_rows > 0 ){   
  	// Atualiza notificação existente   
  	$cmNotif = "UPDATE Notificacoes SET Lido = 0, DataHora = NOW() WHERE Usuario = '" . $Usuario . "' AND Apontamento = " . $Apontamento . " AND Tipo = '" . $Tipo . "';";   
  	$cnNotif->query( $cmNotif );   
 }   
 else{  
  	// Insere nova notificação  
  	$cmNotif = "INSERT INTO `notification`( `type`, `forUser`, `entityID` ) VALUES( '" . $type . "','" . $forUser . "'," . $entityID . " );";   
  	$cnNotif->query( $cmNotif );   
 }  
 $cnNotif->close();  
} 

?>

</head>
<body>
<form action="<?php echo str_replace('%7E','~',$_SERVER['REQUEST_URI']); ?>" method="post" name="Notifica">
<table>
	<tr>
		<td>Tipo</td><td><input type='text' name='Tipo' /></td>
	</tr>
	<tr>
		<td>Usuário</td><td><input type'text' name='Usuario' /></td>
	</tr>
	<tr>
		<td>Apontamento</td><td><input type='text' name='Apontamento'/></td>
	</tr>
	<tr>
		<td>&nbsp;</td><td><input type='submit' name='Envia' value='Envia Notificação' /></td>
	</tr>
</table>
</form>
</body>
</html>
