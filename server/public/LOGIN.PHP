<php??>
    <section class="login-form">
        <h2>Login</h2>
        <div class="login-form-form">
            <form action="includes/login.inc.php" method = "POST">
            <input type = "text" name="email" placeholder="email@gmail.com">
            <input type = "password" name="pwd" placeholder="password">
            <button type = "submit" name = "submit">Log in</button>
            
        </form>
        </div>
        <?php
if(isset($_GET["error"])){
    if ($_GET["error"] == "emptyinput"){
        echo "<p>please fill in all fields </p>";
    } 
    else if ($_GET["error"] == "invalidLogin"){
        echo "<p>wrong login credentials </p>";
    }  
   
}

?>
        
    </section>