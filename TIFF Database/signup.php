<?php
require "header.php";
?>


<main>
    <div class ="wrapper-main">
        <section class="section-default">
              <style>
    form.form-signup{
                 text-align:center;
                 background-color:#3c3c3c;
                 width:400px;
                 padding: 100px;
                 border:15px white;
                 margin: 40px auto;
             } 

        </style>
            <form class = "form-signup" action= "includes/signup.inc.php" method = "post">
               <style>
                     p.signuperror {
                      text-align:center;
                         color:red;   
                   }
                         p.signupsuccess {
                        text-align:center;
                             color:green;
                         }
                </style>
               <h1 style= color:white;>Signup</h1>
              <?php
                if (isset($_GET['error'])){
                    if ($_GET['error'] == "emptyfields"){
                        echo '<p class = "signuperror">Fill all fields</p>';
                    } else if($_GET['error'] == "invalidmail"){
                        echo '<p class = "signuperror">Invalid Email</p>';
                    } else if($_GET['error'] == "invaliduid"){
                        echo '<p class = "signuperror">Invalid Username</p>';
                    } else if($_GET['error'] == "passwordcheck"){
                        echo '<p class = "signuperror">Passwords do not match</p>';
                }
            }else if($_GET['signup'] == "success"){
                     echo '<p class = "signupsuccess">Successful Signup</p>';    
                }
               ?>
                <br>
               <input type="text" name="uid" placeholder="Username">
                <br><br>
                <input type="text" name="mail" placeholder="Email">
                <br><br>
                <input type="password" name="pwd" placeholder="Password">
                <br><br>
                <input type="password" name="pwd-repeat" placeholder="Repeat Password">
                <br><br>
                <button type="submit" name="signup-submit">Signup</button>
           
        </form>
        </section>
    </div> 
</main>


