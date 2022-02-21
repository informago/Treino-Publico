<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title></title>
</head>
<body>

<?php

$con = new mysqli( "localhost", "root", "password", "testDB");

$reset = (int) $_GET[ "reset" ]; // either 1 or 0 ( true and false )
$username = "user1"; // the user who's notifications we will be loading

if( $reset === 1 ) { 
    $sql = "SELECT * FROM `notification` WHERE `forUser`='" . $username . "' ORDER BY `time` DESC LIMIT 10;";
    setcookie( "loadedNotifications", "10", time() + 86400, "/" ); // store the cookie holding the amount of loaded notifications
}
else {
    $loadedNots=(int) $_COOKIE[ "loadedNotifications" ]; // get the amount of previously loaded notifications
    $sql = "SELECT * FROM `notification` WHERE `forUser`='" . $username . "' ORDER BY `time` DESC LIMIT " . $loadedNots . " 10;";
    $loadedNots = (string)( $loadedNots + 10 ); // calculate how many notifications have been loaded after query
    setcookie( "loadedNotifications", $loadedNots, time() + 86400, "/" ); // update cookie with new value
}

$result = $con->query( $sql );
$notifications = array(); // declare an array to store the fetched notifications

if( $result->num_rows > 0 ){
    while( $row = $result->fetch_assoc() ){
        $notifications[] = array( "id" => $row[ "notificationID" ], "type" => $row[ "type" ], "entityID" => $row[ "entityID" ], "read" => $row[ "read" ], "text" => "" );
    }
}
else {
    // no more notifications
}

/*
* now we need to find the activity that relates to the notification
* and create a text message that will be displayed to the user
* containing the users who are responsible for that particular activity
*/

for( $i = 0; $i < count( $notifications ); $i++ ){
    $sql = ""; // reset query string each time loop runs

    // use different code for each type of notification ( ie. comments or ratings )
    switch( $notifications[ $i ][ "type" ] ){
    case "comment":
        $sql = "SELECT `author` FROM `comment` WHERE `postID`=" . $notifications[ $i ][ "entityID" ] . ";";
        $result = $con->query( $sql );
        /*
        * For this example we want a maximum of two names in the notification text
        * if there are more than 2, then we'll include those as a number
        */
        
        if( $result->num_rows === 1 ){
            $row = $result->fetch_assoc();
            $name = $row[ "author" ];
            $notifications[ $i ][ "text" ] = $name . " commented on your post";
        }
        elseif( $result->num_rows === 2 ){
            $row = $result->fetch_assoc();
            $name1 = $row[ "author" ]; // fetch first name
            $row = $result->fetch_assoc();
            $name2 = $row[ "author" ]; // fetch second name
            $notifications[ $i ][ "text" ] = $name1 . " and " . $name2 . " commented on your post";
        }
        elseif( $result->num_rows > 2 ){
            $total = $result->num_rows - 2 //fetch the number of users who commented minus the two names we will use
            $row = $result->fetch_assoc();
            $name1 = $row[ "author" ]; // fetch first name
            $row = $result->fetch_assoc();
            $name2 = $row[ "author" ]; // fetch second name
            $notifications[ $i ][ "text" ] = $name1 . ", " . $name2 . " and " . $total . " others commented on your post";
        }
        break;
    // other cases to suit your needs
    }
}

echo( json_encode( $notifications ) ); // convert array to JSON text  
?>

</body>
</html>