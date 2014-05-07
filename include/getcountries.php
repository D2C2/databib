<?php

  include_once('database_connection.php');

  //--------------------------------------------------------------------------
  // Query database for countries
  //--------------------------------------------------------------------------
  $search_term = mysql_real_escape_string(@$_REQUEST['search_term']) ;

  $query = "SELECT * FROM countries WHERE country_name LIKE '$search_term%'";
  $result = mysql_query($query);          //query

  //--------------------------------------------------------------------------
  // echo result as json
  //--------------------------------------------------------------------------
  $i=0;
  while ($row = mysql_fetch_array($result,MYSQL_ASSOC))//loop through the retrieved values
  {
              $row_set[$i]['id_country'] = $row['id_country'];//build an array
              $row_set[$i]['country_name'] = $row['country_name'];//build an array
              $i++;
  }
  echo json_encode($row_set);
?>
