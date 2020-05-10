
<!DOCTYPE html>
<html lang="en">
<head>
  <title>TIFF Database Season 2018</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>
<h2>Event Search database</h2><br>
Search by event name &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;guests&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Venue&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dates
   <form action = "sqlsearch.php" method = "post">
    <input type = "text" name = "searchevent" placeholder = "Enter event">
  <select name = "int1">
        <option value = ""></option>
        <option value = "10">10</option>
        <option value = "20">20</option>
        <option value = "30">30</option>
        <option value = "40">40</option>
        <option value = "50">50</option>
        <option value = "70">70</option>
        <option value = "80">80</option>
        <option value = "90">90</option>
        <option value = "100">100</option>
        <option value = "110">110</option>
        <option value = "120">120</option>
        <option value = "130">130</option>
        <option value = "140">140</option>
        <option value = "150">150</option>
        <option value = "160">160</option>
        <option value = "170">170</option>
        <option value = "180">180</option>
        <option value = "190">190</option>
        <option value = "200">200</option>
        <option value = "210">210</option>
        <option value = "220">220</option>
        <option value = "230">230</option>
       </select> 
       <select name = "int2">
        <option value = ""></option>
        <option value = "10">10</option>
        <option value = "20">20</option>
        <option value = "30">30</option>
        <option value = "40">40</option>
        <option value = "50">50</option>
        <option value = "60">60</option>
        <option value = "70">70</option>
        <option value = "80">80</option>
        <option value = "90">90</option>
        <option value = "100">100</option>
        <option value = "110">110</option>
        <option value = "120">120</option>
        <option value = "130">130</option>
        <option value = "140">140</option>
        <option value = "150">150</option>
        <option value = "160">160</option>
        <option value = "170">170</option>
        <option value = "180">180</option>
        <option value = "190">190</option>
        <option value = "200">200</option>
        <option value = "210">210</option>
        <option value = "220">220</option>
        <option value = "230">230</option>
       </select>
         <select name="venue">
             <option value="">------Select Venue-----</option>
             <option value="1">Learning Studios - TIFF</option>
             <option value="2">Cinema 2</option>
             <option value="3">Cinema 3</option>
             <option value="4">Cinema 4</option>
             <option value="5">Cinema 5</option>
             <option value="6">Cinema 6</option>
             <option value="7">Film Reference Library</option>
             <option value="8">Green Room</option>
             <option value="9">Blue Room</option>
             <option value="10">Daniels West Lobby</option>
             <option value="11">U of T Media Commons</option>
             <option value="12">Glenn Gould Studio</option>
             <option value="13">Off-site</option>
             <option value="14">Facilities-TIFF</option>
             <option value="15">Niagara College</option>
         </select>
          <input type ="date" name = "dated" style = "align-left" placeholder = "YYYY-MM-DD"><br><br>
            <button type="submit" name="search">Submit</button><br><br>    
        </form> 
    </body>
</html>
