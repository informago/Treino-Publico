
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title></title>
</head>
<body>

<?php

$cnNotif = new mysqli( "localhost", "lucianor_t01", "treino-0102030405", "lucianor_t01-notif");

$reset = (int) $_GET[ "reset" ]; // 1 ou 0 para true ou false
$username = "informago";

if( $reset === 1 ) { 
    $sql = "SELECT * FROM Notificacoes WHERE Usuario = '" . $username . "' ORDER BY DataHora DESC LIMIT 10;";
    setcookie( "qtNotifCarregadas", "10", time() + 86400, "/" );
}
else {
    $qtNotif = (int) $_COOKIE[ "qtNotifCarregadas" ];
    $sql = "SELECT * FROM Notificacoes WHERE Usuario = '" . $username . "' ORDER BY DataHora DESC LIMIT " . $qtNotif . ", 10;";
    $qtNotif = (string)( $qtNotif + 10 );
    setcookie( "qtNotifCarregadas", $qtNotif, time() + 86400, "/" );
}

$result = $cnNotif->query( $sql );
$aNotifs = array();
// Monta array de resposta

if( $result->num_rows > 0 ){
    while( $row = $result->fetch_assoc() ){
        $aNotifs[] = array( "id" => $row[ "Id" ], "tipo" => $row[ "Tipo" ], "apontamento" => $row[ "Apontamento" ], "lido" => $row[ "Lido" ], "texto" => "" );
    }
}
else {
    // Sem mais notificações
}

for( $i = 0; $i < count( $aNotifs ); $i++ ){
    $sql = "";

    switch( $aNotifs[ $i ][ "tipo" ] ){
    case "A":
        $sql = "SELECT Autor FROM Comentarios WHERE Post =" . $aNotifs[ $i ][ "apontamento" ] . ";";
        $result = $cnNotif->query( $sql );
        
        // Se houver mais de duas linhas na resposta, ela será substituída pelo número
        if( $result->num_rows === 1 ){
            $row = $result->fetch_assoc();
            $Nome = $row[ "Autor" ];
            $aNotifs[ $i ][ "texto" ] = $Nome . " comentou no seu post.";
        }
        elseif( $result->num_rows === 2 ){
            $row = $result->fetch_assoc();
            $Nome1 = $row[ "Autor" ];
            $row = $result->fetch_assoc();
            $Nome2 = $row[ "Autor" ];
            $aNotifs[ $i ][ "texto" ] = $Nome1 . " e " . $Nome2 . " comentaram na sua postagem.";
        }
        elseif( $result->num_rows > 2 ){
            $total = $result->num_rows - 2;
            $row = $result->fetch_assoc();
            $Nome1 = $row[ "Autor" ];
            $row = $result->fetch_assoc();
            $Nome2 = $row[ "Autor" ];
            $aNotifs[ $i ][ "texto" ] = $Nome1 . ", " . $Nome2 . " e outras " . $total . " comentaram no seu post.";
        }
        break;
    case "B":
        break;
    case "C":
        break;
    }
}

echo( json_encode( $aNotifs ) );
?>

</body>
</html>