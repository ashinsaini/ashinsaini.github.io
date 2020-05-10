<?php

if(isset($_POST['search'])){
  
   require 'db.inc.php';
    
        $venue = $_POST['venue'];
        $int1 = $_POST['int1'];
        $int2 = $_POST['int2'];
        $searchevent = "%{$_POST['searchevent']}%";
       
        $query = "select s.event_id, s.event_name, s.dates, s.guests, v.venue_name from season_2018 s join venue v on s.venue_id = v.venue_id where s.event_name like ? and  s.guests between ? and ? order by s.event_id";
        
        $query2 = "select s.event_id, s.event_name, s.dates, s.guests, v.venue_name from season_2018 s join venue v on s.venue_id = v.venue_id where s.event_name like ?";
        
        $guestquery = "select s.event_id, s.event_name, s.dates, s.guests, v.venue_name from season_2018 s join venue v on s.venue_id = v.venue_id where s.guests between ? and ? order by s.event_id";
    
        $dated = $_POST['dated'];
        $datequery = "select s.event_id, s.event_name, s.dates, s.guests, v.venue_name from season_2018 s join venue v on s.venue_id = v.venue_id where s.dates = ? order by s.event_id";
    
       
        $venuequery = "select s.event_id, s.event_name, s.dates, s.guests, v.venue_name from season_2018 s join venue v on s.venue_id = v.venue_id where v.venue_id = ?";
    
        $stmt = mysqli_stmt_init($connect);
    
    if(!mysqli_stmt_prepare($stmt,$query)){
        
        header("Location: ../sqlsearch.php?error=sqlerror1");
        exit();
    }else{
        
        mysqli_stmt_bind_param($stmt, "sii", $searchevent,$int1,$int2);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        }
            if(empty($int1||$int2)){
        
                mysqli_stmt_prepare($stmt,$query2);
        
                mysqli_stmt_bind_param($stmt, "s", $searchevent);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
      
            if(!empty($venue)){
            
                mysqli_stmt_prepare($stmt,$venuequery);
        
                mysqli_stmt_bind_param($stmt, "i", $venue);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
            }
                if(!empty($dated)){
                    
                      mysqli_stmt_prepare($stmt,$datequery);
        
                      mysqli_stmt_bind_param($stmt, "s", $dated);
                      mysqli_stmt_execute($stmt);
                      $result = mysqli_stmt_get_result($stmt);
                }
              
      }
     }

    else{
 echo 'no results <div><a href="index.php">back to search page</a></div>';
        
 } ?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TIFF Database</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>
    <h1>Events Database</h1>
        <a href="index.php">back to search page</a>
         <form style = "position: absolute; right: 0;" action="includes/logout.inc.php" method="post">
             <button type="submit" name="logout-submit">Logout</button>
         </form><br><br>
          <div class= "container">
    <table id= "myTable" class="table-dark able table-striped table table-hover">
    <thead>
      <tr>
        <th onclick = "sortTable(0)">Event ID</th>
        <th>Event Name</th>
        <th>Dates</th>
        <th onclick = "sortGuest(0)">Guests</th>
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
    <?php } echo "$searchevent";?>
    
        </tbody>
        </table>
        <script>
            var sortGuest = function (n) {
                var i, x, y, rows, table, shouldSwitch, switching, dir, switchcount = 0;
                table = document.getElementById("myTable");
                switching = true;
                dir = "asc";
                    while (switching) {
                        switching =  false;
                        rows = table.rows;
                        
                        for (i = 1; i < rows.length - 1; i++) {
                            
                            x = rows[i].getElementByTagName("TD")[n];
                            y = rows[i + 1].getElementByTagName("TD")[n];
                            
                             if(dir == "asc") {
                      
                                if(Number(x.innerHTML) > Number(y.innerHTML)) {
                                    shouldSwitch = true;
                                    break;
                        }
                     }          else if (dir == "desc") {
                                    if(Number(x.innerHTML) < Number(y.innerHTML)) {
                                    shouldSwitch = true;
                                    break;
                     }
                  }
                }
            
                    if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                    switching ++;
                    } else {
                        if(switchcount == 0 && dir == "asc"){
                            dir = "desc";
                            switching = true;
                        }
                    }
                  }
            }
            
            var sortTable = function (n) {
                var i, v, w, rows, table, shouldSwitch, switching, dir, switchcount = 0;
                 table = document.getElementById("myTable");
                  switching = true;
                  dir = "asc";    
                    while(switching) {
                        switching = false;
                        rows = table.rows;
                        
                        for (i = 1; i < rows.length -1; i++) {
                        v = rows[i].getElementsByTagName("TD")[n];
                        w = rows[i + 1].getElementsByTagName("TD")[n];
                     
                            if(dir == "asc") {
                      
                                if(Number(v.innerHTML) > Number(w.innerHTML)) {
                                    shouldSwitch = true;
                                    break;
                        }
                     }          else if (dir == "desc") {
                                    if(Number(v.innerHTML) < Number(w.innerHTML)) {
                                    shouldSwitch = true;
                                    break;
                     }
                  }
                }
                    if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                    switching ++;
                    } else {
                        if(switchcount == 0 && dir == "asc"){
                            dir = "desc";
                            switching = true;
                        }
                    }
                }
              }
          </script>
        </div>
    </body>
  </html>