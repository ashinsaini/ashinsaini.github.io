<?php

if(isset($_POST['search'])){

    require 'db.inc.php';
    
        $searchevent = "'%{$_POST['searchevent']}%'";
        $query = "select s.event_id, s.event_name, s.dates, s.guests, v.venue_name from season_2018 s join venue v on s.venue_id = v.venue_id where s.event_name like ? order by s.event_id";
    
        $int1 = $_POST['int1'];
        $int2 = $_POST['int2'];
        $guestquery = "select s.event_id, s.event_name, s.dates, s.guests, v.venue_name from season_2018 s join venue v on s.venue_id = v.venue_id where s.guests between ? and ? order by s.event_id";
    
        $dated = $_POST['dated'];
        $datequery = "select s.event_id, s.event_name, s.dates, s.guests, v.venue_name from season_2018 s join venue v on s.venue_id = v.venue_id where s.dates = ? order by s.event_id";
    
        $venue = $_POST['venue'];
        $venuequery = "select s.event_id, s.event_name, s.dates, s.guests, v.venue_name from season_2018 s join venue v on s.venue_id = v.venue_id where s.venue_id =? order by s.event_id";
    

        $stmt = mysqli_stmt_init($connect);
    
    if(!mysqli_stmt_prepare($stmt,$query)){
        
        header("Location: ../sqlsearch.inc.php?error=sqlerror1");
        exit();

    }else{
        
        mysqli_stmt_bind_param($stmt, "s", $searchevent);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        }
   
   
       if(!mysqli_stmt_prepare($stmt, $guestquery)){
        
            header ("Location: ../sqlsearch.inc.php?error=sqlerror2");
            exit();
    
    }else{
        
        mysqli_stmt_bind_param($stmt,"ii", $int1,$int2);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
            }
    
    
    if(!mysqli_stmt_prepare($stmt,$datequery)){
       header("Location: ../sqlsearch.inc.php?error=sqlerror3");
        exit();
        
    }else{
        mysqli_stmt_bind_param($stmt,"s", $dated);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
    }
    
    if(!mysqli_stmt_prepare($stmt,$venuequery)){
        header("Location:.. /sqlsearch.inc.php?error=sqlerror4");
        exit();
    
    }else{
        mysqli_stmt_bind_param($stmt,"i",$venue);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
    }
    

}
else{
    echo "no result found";
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TIFF Database</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>
    <h1>Events Database</h1>
        <a href="index.php">back to search page</a>
         <form style = "position: absolute; right: 0;" action="includes/logout.inc.php" method="post">
             <button type="submit" name="logout-submit">Logout</button>
         </form><br><br>
          <div class= "container">
    <table class="table-dark able table-striped table table-hover">
    <thead>
      <tr>
        <th>Event ID</th>
        <th>Event Name</th>
        <th>Dates</th>
        <th>Guests</th>
        <th>Venue</th>
      </tr>
    </thead>
       <tbody>
        <?php
            while ($row = mysqli_fetch_array($result)){
           ?>           
        <tr>
        <td><?php echo " ".$row['event_id'];?></td>
        <td><?php echo " ".$row['event_name'];?></td>
        <td><?php echo " ".$row['dates'];?></td>
        <td><?php echo " ".$row['guests'];?></td>
        <td><?php echo " ".$row['venue_name']?></td>   
        </tr>
    <?php } ?>   
        </tbody>
        </table>
        </div>  
</body>
</html>
