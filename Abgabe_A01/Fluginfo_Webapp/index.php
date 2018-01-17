<?php
include 'connect.php';
session_start();    

$array = array();

/**
Funktion von:
http://php.net/manual/de/function.array-unique.php
Kommentar: Ghanshyam Katriya
**/
function unique_multidim_array($array, $key) { 
    $temp_array = array(); 
    $i = 0; 
    $key_array = array(); 
    
    foreach($array as $val) { 
        if (!in_array($val[$key], $key_array)) { 
            $key_array[$i] = $val[$key]; 
            $temp_array[$i] = $val; 
        } 
        $i++; 
    } 
    return $temp_array; 
} 

if(isset($_POST['search']))
{
	$_SESSION['fnr'] = $_POST['fnr'];  
	
    $query = "SELECT * FROM passengers
				NATURAL JOIN flights 
				WHERE flightnr=".$_SESSION['fnr'] ." 
				ORDER BY flights.airline,passengers.rownr,passengers.seatposition";
    
    $result = mysqli_query($db, $query);	
	
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) 
			{
	  		    $array[] = $row;		
			}
		$details = unique_multidim_array($array,'airline');		
		} else {
			echo "0 results";
		}        
}

if(isset($_POST['delete']))
{    

    $query = "DELETE FROM passengers WHERE id =" .$_POST['delete'];
    
    mysqli_query($db, $query);
	
	if (mysqli_query($db, $query)) {
		echo "Record deleted successfully";
	} else {
		echo "Error deleting record: " . mysqli_error($db);
	}
	
    $query2 = "SELECT * FROM passengers
				NATURAL JOIN flights 
				WHERE flightnr=".$_SESSION['fnr'] ."
				ORDER BY flights.airline,passengers.rownr,passengers.seatposition";
    
    $result = mysqli_query($db, $query2);	
	
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) 
			{
	  		    $array[] = $row;		
			}
		$details = unique_multidim_array($array,'airline');
		} else {
			echo "0 results";
		} 		
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title> Flugticket Grieshofer </title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
.right {
  text-align: right;
}
			table {
				width: 700px;
				border-collapse:collapse;
			}table th,td{
				width: 360px;
			    white-space: nowrap;
			}table tbody, thead{
				display: block;
			}table tbody{
				overflow: auto;	
				max-height: 500px;
			}th{
				background-color: #810b2f;
				color: white;
				margin-bottom: 10px;
			}td {
			}tr:hover td {
			  background: #808080;
			  color:#FFFFFF;
			}
		</style>
    </head>
    <body>
    	<form action="internet.php" method="post">
	        Flugnummer:<input type="text" name="fnr">
            <input type="submit" name="search" value="Find">
        </form>
            <?php if($array){?>
            <table>
                <tr>
                    <th>Flugnummer</th>
                    <th>Airline</th>
                    <th>Abflugszeit</th>
                    <th>Abflughafen</th>
                    <th>Ankunftszeit</th>
                    <th>Zielflughafen</th>
                    <th>Flugzeugtyp</th>
                </tr>               
					<?php foreach($details as $j => $item){ ?>
                    <tr>
                        <td><?php echo $array[$j]['flightnr']; ?></td>
                        <td><?php echo $array[$j]['airline']; ?></td>
                        <td><?php echo $array[$j]['departure_time']; ?></td>
                        <td><?php echo $array[$j]['departure_airport']; ?></td>
                        <td><?php echo $array[$j]['destination_time']; ?></td>
                        <td class = "right"><?php echo $array[$j]['destination_airport']; ?></td>
                        <td class = "right"><?php echo $array[$j]['planetype']; ?></td>
                    </tr>
                    <?php }?>
            </table>
            <table>
                <tr>
                <th>Airline</th>
                <th>Vorname</th>
                <th>Nachname</th>
                <th>Reihennummer</th>
                <th>Sitzplatz</th>
                <th>Löschen</th>
                </tr>
                </table>
                <table>
                    <form action="internet.php" method ="post">
                    <?php for($i=0;$i<count($array);$i++){ ?>
                        <tr>
                            <td><?php echo $array[$i]['airline']; ?></td>
                            <td><?php echo $array[$i]['firstname']; ?></td>
                            <td><?php echo $array[$i]['lastname']; ?></td>
                            <td class = "right"><?php echo $array[$i]['rownr']; ?></td>
                            <td class = "right"><?php echo $array[$i]['seatposition']; ?></td>
                            <td class = "right"><button name="delete" value="<?php echo $array[$i]['id'];?>">X</button></td>
                        </tr>
                    <?php }?>
                    </form>
            </table>
            <?php }?> 
    </body>
</html>