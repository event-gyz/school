<?php
//=========================
// define area
//=========================
$dbhost = "192.168.100.21";
$dbuser = "huitang";
$dbpw   = "Evt_huitang2015";
$mysql_database = "sunny_school";

//$mysql_database = "school";
//$dbhost = "127.0.0.1";
//$dbuser = "root";
//$dbpw   = "root";

date_default_timezone_set('Asia/Taipei');
error_reporting(E_ALL ^ E_DEPRECATED);

//preset by jtyeh:20310508
//$conn=mysqli_connect($dbhost, $dbuser, $dbpw);
//$out_db = mysql_select_db($mysql_database, $conn) or die ("Could not select database: " . mysql_error());
//$charset= mysql_query("SET NAMES utf8;");

$conn=mysqli_connect($dbhost, $dbuser, $dbpw,$mysql_database);
$charset = mysqli_query($conn,"set names utf8");


function query($sql)
{
    global $conn;
    $result=null;
    if(func_num_args()==1 && $conn!=null)
    {
        //check if SQL command is valid
        if(substr_count($sql,";")>0) return null;
        if(substr_count($sql,"'")%2>0) return null;
        if(substr_count($sql,"drop")>0) return null;
//		$result = mysql_query($sql, $conn) or die("Server Error:".mysql_error());
        $result = mysqli_query($conn,$sql ) or die("Server Error:".mysql_error());
        return $result;
    }
    return null;
}

function result_to_table($result)
{

    $fields_num = mysqli_num_fields($result);

    echo "<table><tr>";

    // printing table headers
    for($i=0; $i<$fields_num; $i++)
    {
        $field = mysqli_fetch_field($result);
        echo "<td>{$field->name}</td>";
    }
    echo "</tr>\n";

    // printing table rows
    while($row = mysqli_fetch_row($result))
    {
        echo "<tr>";

        // $row is array... foreach( .. ) puts every element
        // of $row to $cell variable
        foreach($row as $cell)
            echo "<td>$cell</td>";

        echo "</tr>\n";
    }
    echo "</table>";

}

function sql_to_csv($sql)
{

    echo "<form method='post' action='downloadCSV.php'>
                <input type='hidden' name='sql' value=\"".$sql."\">
                <input type='submit' value='Output CSV File'></form>";

}


function query_result($sql)
{
    global $conn;
    $result=null;
    if(func_num_args()==1 && $conn!=null)
    {
        $result = mysqli_query($conn,$sql) or die("Server Error:".mysql_error());
        $tmp = mysqli_fetch_array($result,MYSQL_ASSOC);
        mysqli_free_result($result);
        return $tmp;
    }
    return null;
}

function query_result_list($sql)
{
    global $conn;
    $result=null;
    $tmp = array();
    if(func_num_args()==1 && $conn!=null)
    {
        $result = mysqli_query($conn,$sql) or die("Server Error:".mysqli_error());
        while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
            $tmp[] = $row;
        }
        mysqli_free_result($result);
    }
    return $tmp;
}

function query_delete($sql){
    global $conn;
    $result=null;
    $result = mysqli_query( $conn,$sql) or die("Server Error:".mysqli_error());
    return $result;
}

?>
