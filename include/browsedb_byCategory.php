<?php


class insertObj{

    public $id;
    public $title;
    public function __construct($id, $title) {
        $this->id = $id;
	$this->title = $title;
    }

}

function sortObj($obj1, $obj2){
	if( $obj1->title < $obj2->title)
		return -1;
	else
		return +1;

}


error_reporting(E_ALL);
ini_set("display_errors", 1);

include_once('database_connection.php');


$startrow = 0;
$limit = 20;

$query = "select * from approved;";
$numresults = mysql_query ($query) or die(mysql_error());

$broaderSubjectHash = array();


while( $row = mysql_fetch_array($numresults))
{

   	if($row['id_rep']=='')
                continue;


        if(!isset($broaderSubjectHash[$row["classification"]]))
        {
                $broaderSubjectHash[$row["classification"]] = array();
        }
	
	$thelist = &$broaderSubjectHash[$row["classification"]];
	
	$found = false;

	foreach ($thelist as $obj)
	{

		if($obj->id == $row['id_rep'])
		{
			$found = true;
		}
	}

	if($found != true)
	{
		array_push($thelist, new insertObj($row['id_rep'], $row['rep_title']));
	}
}

ksort($broaderSubjectHash);
foreach ($broaderSubjectHash as $broadersubs => $subjects)
{

	echo "<b>".$broadersubs."</b><br>";
	usort($subjects, "sortObj");
	foreach ($subjects as $subject)
	{
		echo "&nbsp&nbsp&nbsp <a href='./viewapprovedbyrecordid.php?record=$subject->id' style='color:#993300; font-size:14px'>".$subject->title."</a><br>";
	}

	echo "<br><br>";

}




/*
while( $row = mysql_fetch_array($numresults))
{
	if($row['id_subject']=='')
		continue;

	
	

	echo "<a href='./include/getrecordsbysubject.php?subjectid=" . $row['id_subject'] ."' style='color:#993300; font-size:14px'>" .$row['sub_title'];
	echo '</a> <br><br>';
	
} */

?>

