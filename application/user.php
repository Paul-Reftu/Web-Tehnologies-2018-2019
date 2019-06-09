<!DOCTYPE html>
<html lang="en-US">

<head lang="en-US">
    <title>Security Alerter</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width-device-width, initial-scale=1.0" />
    <meta name="author" content="Reftu Paul Alexandru, Ruse Daniel Stefan, Popescu Flavius-Petru" />
    <meta name="description"
        content="The Web App Security Alerter is meant to serve as a guide to achieving better security inside and outside of the Internet, to protect user's private data across all domains and to instruct developers on how to engineer their own secure applications." />
    <!-- Icon obtained from: https://www.isw-online.de/praesident-trump-vs-privacy-shield/  -->
    <link rel="shortcut icon" href="assets/images/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="stylesheet2.css" type="text/css" />
    <link rel="stylesheet" href="stylesheet.css" type="text/css" />
</head>

<body>
    <?php
        include("Header.php");
        $conn = new mysqli("localhost","root","","proiect");
        if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['user']) and $_POST['user'] != '')
        {
            update_user();
        }
        if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['password']) and $_POST['password'] != '')
        {
            update_password();
        }
        if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['mail']) and $_POST['mail'] != '')
        {
            update_mail();
        }
        if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['age']) and $_POST['age'] != '')
        {
            update_age();
        }
        if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['sex']) and $_POST['sex'] != '')
        {
            update_sex();
        }
        if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['sub']) and $_POST['sub'] != '')
        {
            subscribe();
        }
        if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['unsub']) and $_POST['unsub'] != '')
        {
            unsubscribe();
        }
        include("Navbar.php");

    ?>
    <main>
        <form class="info" action="user.php" method="post">
            <div id=iUser>
                <label >Change Username:</label>
                <input type="text" placeholder="Enter your username" name="user" />
            </div>
            <div id=iPassword>
                <label >Change Password:</label>
                <input type="password" placeholder="Enter your password" name="password"/>
            </div>
            <div id=iMail>
                <label >Change Mail:</label>
                <input type="text" placeholder="Enter your password" name="mail"/>
            </div>
            <div id=iAge>
                <label >Change Age:</label>
                <input type="text" placeholder="Enter your password" name="age"/>
            </div>
            <div id=iSex>
                <label >Change Sex:</label>
                <input type="text" placeholder="Enter your password" name="sex"/>
            </div>
            <button type="submit" id="iinfo">Change</button>
        </form>


        <form class="info" action="user.php" method="post">
            <div id=iUser>
                <label >Subscribe to new topic:</label>
                <input type="text" placeholder="Enter topic" name="sub" />
            </div>
            <button type="submit" id="sub">Subscribe</button>
        </form>
     
<?php
    echo '<form class="info" action="user.php" method="post">';
    echo '<select name="unsub">';
    echo '<option value=""></option>';
    $result = $conn->query("select category from subs where id_client = " .$_SESSION['id'] );
    if ($result->num_rows > 0){
        while ($row = $result->fetch_assoc()){
            echo '<option value="' .$row['category']. '">' .$row['category']. '</option>';
        }
    }
    echo '</select>';
    echo '<button type="submit" id="unsub">Unsubscribe</button>';
    echo '</form>';
?>


    <form class="info" action="delete.php" method="post">
       <button type="submit" id="delete">Delete Account</button> 
    </form>

    </main>




    <?php
        include("Footer.php");
        function update_user(){
            $conn = new mysqli("localhost","root","","proiect");
            if($_POST['user'] == $_SESSION['user']){
                echo 'Please give a different username!';
                return;
            }
            $result = $conn->query('select id from user where username = \'' .$_POST['user']. "'");
            if ($result->num_rows > 0){
                echo 'Username taken!';
                return;
            }
            $conn->query('update user set username = \'' .$_POST['user']. "' where username = '" .$_SESSION['user']. "'");
            $_SESSION['user'] = $_POST['user'];
        }

        function update_password(){
            $conn = new mysqli("localhost","root","","proiect");
            $result = $conn->query('select password from user where id =' .$_SESSION['id']);
            $row = $result->fetch_assoc();
            if($row['password'] == $_POST['password']){
                echo 'Please use a different password!';
                return;
            }
            $conn->query('update user set password = \'' .$_POST['password']. "' where id = " .$_SESSION['id']);
        }

        function update_mail(){
            $conn = new mysqli("localhost","root","","proiect");
            $result = $conn->query('select email from user where id =' .$_SESSION['id']);
            $row = $result->fetch_assoc();
            if($row['email'] == $_POST['mail']){
                echo 'Please use a different Email!';
                return;
            }
            $result = $conn->query('select email from user where email =\'' .$_POST['mail']. "'");
            if($result->num_rows > 0){
                echo 'Email already used!';
                return;
            }
            $conn->query('update user set email = \'' .$_POST['mail']. "' where id = " .$_SESSION['id']);
        }

        function update_age(){
            $conn = new mysqli("localhost","root","","proiect");
            $conn->query('update user set age = ' .$_POST['age']. " where id = " .$_SESSION['id']);
        }

        function update_sex(){
            $conn = new mysqli("localhost","root","","proiect");
            $conn->query('update user set sex = \'' .$_POST['sex']. "' where id = " .$_SESSION['id']);
        }

        function subscribe(){
            $conn = new mysqli("localhost","root","","proiect");
            $result = $conn->query('select category from subs where id_client = ' .$_SESSION['id']. " and category = '" .$_POST['sub']. "'");
            if ($result->num_rows > 0){
                echo 'Already subscribed to this topic!';
                return;
            }
            $conn->query('insert into subs values (' .$_SESSION['id']. ",'" .$_POST['sub']. "')");
        }

        function unsubscribe(){
            $conn = new mysqli("localhost","root","","proiect");
            $conn->query('delete from subs where id_client = ' .$_SESSION['id']. " and category = '" .$_POST['unsub']. "'");
        }
    ?>
</body>

</html>
