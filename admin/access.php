<?php
//put sha1() encrypted password here
$password = 'edcf0a57f1fcc4b7e77971760af683abf6dd4382';

session_start();
if (!isset($_SESSION['loggedIn'])) {
    $_SESSION['loggedIn'] = false;
}

if (isset($_POST['password'])) {
    if (sha1($_POST['password']) == $password) {
        $_SESSION['loggedIn'] = true;
    } else {
        die ('Incorrect password');
    }
} 

if (!$_SESSION['loggedIn']): ?>
    <div data-role="content" style="max-width:400px">
        <form method="post">
            <h2>Please sign in</h2>
            <div data-role="fieldcontain">
                <label for="inputPassword">Password</label>
                <input type="password" id="password" name="password" placeholder="Password" required autofocus>
            </div>
            <button type="submit">Sign in</button>
        </form>
    </div>
<?php
exit();
endif;
?>