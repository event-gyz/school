<?php
/*
if (!defined('PDO::ATTR_DRIVER_NAME')) {
echo 'PDO unavailable';
}
else echo 'hello';
*/
//phpinfo(); // This would be used to display all of the PHP information available for the installation. 
/*
try{
    $dbh = new pdo( 'mysql:host=127.0.0.1:3306;dbname=sunny_school',
                    'kidsdna_sunny',
                    'kidsdna',
                    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    die(json_encode(array('outcome' => true)));
}
catch(PDOException $ex){
    die(json_encode(array('outcome' => false, 'message' => 'Unable to connect')));
}
*/

try {
    $dbh = new PDO('mysql:host=localhost;dbname=sunny_school', 'root', 'admin');
    foreach($dbh->query('SELECT * from member') as $row) {
        print_r($row);
    }
    $dbh = null;
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>
