<?php


function dbConnect(array $config) {

	$dbConn = @mysqli_connect($config['host'], $config['user'], $config['pass'], $config['name']);
	if(mysqli_connect_error()) die('Connection Error: '.mysqli_connect_error());
	mysqli_query($dbConn, "SET CHARACTER SET utf8");
	mysqli_query($dbConn, "SET NAMES utf8");
	return $dbConn;
}


function dbLastId() {

	global $dbConn;
	$lastId = mysqli_insert_id($dbConn);
	return $lastId;
}

// Database functions

function dbQuerySafener($query,$params=false) {
  if ($params) {
    foreach ($params as &$v) {
    	// since we've secured the CMS, URL's in the rich text editor are coming in as https - need to replace them with http
    	$str1s = "https://www.".$_SERVER['HTTP_HOST'];
    	$str1r = "http://www.".$_SERVER['HTTP_HOST'];
    	$str2s = "https://".$_SERVER['HTTP_HOST'];
    	$str2r = "http://".$_SERVER['HTTP_HOST'];
    	$v = str_ireplace($str1s, $str1r, $v);
    	$v = str_ireplace($str2s, $str2r, $v);
    	// now continue as normal
      $v = mysqli_real_escape_string($v); 
    }
    $sql_query = vsprintf( str_replace("?","'%s'",$query), $params );
  } else {
    $sql_query = $query;
  }
  return $sql_query;
}

// single command without returns (eg INSERT)
function dbCommand($query,$params=false) {

	global $dbConn;
	$sql = dbQuerySafener($query, $params);
	return mysqli_query($dbConn, $sql) or die(mysqli_error($dbConn)."<br>".$sql);
}

// query returning ONE ROW
function dbQuery($query, $params=false) {

	global $dbConn;
	$sql = dbQuerySafener($query, $params);
	$result = mysqli_query($dbConn, $sql) or die(mysqli_error($dbConn)."<br>".$sql);
	$row = mysqli_fetch_assoc($result);
	mysqli_free_result($result);
	return $row;
}

// query returning ARRAY (many rows)
function dbArray($query,$params=false) {

	global $dbConn;
	$resultSet = array();
	$sql = dbQuerySafener($query, $params);
	$result = mysqli_query($dbConn, $sql) or die(mysqli_error($dbConn)."<br>".$sql);
	while($row = mysqli_fetch_assoc($result)) $resultSet[] = $row;
	mysqli_free_result($result);
	return $resultSet;
}

function prettyTable($table) {
  $i=0;
  if (is_array($table) and sizeof($table)>0) {
    if (!is_array($table[0])) {
      $table = array($table);
    }
    foreach ($table as $num => $row) {
      if ($i==0) {
        echo "<table border=1><tr><td></td>";
        foreach ($row as $key => $value) {
          echo "<td>".$key."</td>";
        }
        echo "</tr>";
      }
      $i++;
      echo "<tr><td>".$i."</td>";
      foreach ($row as $key => $value) {
        echo "<td>".$value."</td>";
      }
      echo "</tr>";
      if ($i == sizeof($table)) {
        echo "</table>";
      }
    }
  } else {
    echo "<br>NULL</br>";
  }
}

function arraySearch ($data, $column, $value) {
    foreach ($data as $key=>$row) {
        if ($row[$column]==$value) {
            $id = $key;
            return $id;
            break;
        }
    }
    return false;
}

function arraySort( &$data, $column = null, $sort = 'asort') {
  // pseudo-secure--never allow user input into $sort
  if (strpos($sort, 'sort') === false) {$sort = 'asort';}
  $arrTemp = Array();
  $arrOut = Array();

  foreach ( $data as $key=>$value ) {
    $arrTemp[$key] = is_null($column) ? reset($value) : $value[$column];
  }

  $sort($arrTemp);

  foreach ( $arrTemp as $key=>$value ) {
    $arrOut[$key] = $data[$key];
  }

  $data = $arrOut;
}

?>
