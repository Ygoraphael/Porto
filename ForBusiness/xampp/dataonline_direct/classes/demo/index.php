<?php
include '../userauth.class.php';
$auth = new UserAuthentication();

if ($auth->isLoggedIn()) {
    
$login = $auth->getLogin();
echo <<<HTML
    <h1>Hello, $login</h1>
    <p><a href="logout.php">Click here to log out</a></p>
HTML;
// ^ If you haven't seen it before - it's called Heredoc - really useful thing

}
else {
    
if(isset($_GET['login']) && $_GET['login'] == 'error') {
    echo '<p style="color:red">Incorrect login or password</p>';
}
echo <<<HTML
    <form method="post" action="login.php">
        <p>Login: <input type="text" name="login"/></p>
        <p>Password: <input type="password" name="pass"/></p>
        <p><input type="submit" value="Log in"/></p>
    </form>
HTML;

}
?>
