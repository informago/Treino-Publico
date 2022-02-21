<html>
<head>
</head>
<body>

<?php

if( isset($_POST['Usuario'])) {

	$Usuario = $_POST['Usuario'];
	$Apontamento = 0;
	$Tipo = "A";
	$Mensagem = $_POST['Mensagem'];

	$cnNotif = new mysqli( "localhost", "lucianor_t01", "treino-0102030405", "lucianor_t01-notif");
	$cmNotif = "SELECT Id FROM Notificacoes WHERE Usuario = '" . $Usuario . "' AND Apontamento = " . $Apontamento . " AND Tipo ='" . $Tipo . "';";
	$res = $cnNotif->query( $cmNotif );

	echo "Número de Linhas: " . strval($res->num_rows) . "<br />";
	
	if( $res->num_rows > 0 ){
		// Atualiza notificação existente
		$cmNotif = "UPDATE Notificacoes SET Lido = 0, DataHora = NOW() WHERE Usuario = '" . $Usuario . "' AND Apontamento = " . $Apontamento . " AND Tipo = '" . $Tipo . "';";
		$cnNotif->query( $cmNotif );
		echo "Atualizou <br />";
	}
	else {
		// Insere nova notificação
		$cmNotif = "INSERT INTO Notificacoes( Tipo, Usuario, Apontamento, Mensagem, Lido, DataHora ) VALUES( '" . $Tipo . "','" . $Usuario . "'," . $Apontamento . ", $Mensagem ,0,NOW() );";
		$cnNotif->query( $cmNotif );
		echo "Incluiu <br />";
	}
	$cnNotif->close();
}

?>

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
		<td>Mensagem</td><td><input type='text' name='Mensagem'/></td>
	</tr>
	<tr>
		<td>&nbsp;</td><td><input type='submit' name='Envia' value='Envia Notificação' /></td>
	</tr>
</table>
</form>
</body>
</html>
