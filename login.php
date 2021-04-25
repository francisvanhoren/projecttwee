<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
?>

<?php
$msg = "";
if(isset($_POST['submitBtnLogin'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    if($username != "" && $password != "") {
        try {
            $query = "select * from `user_login` where `username`=:username and `password`=:password";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam('username', $username, PDO::PARAM_STR);
            $stmt->bindValue('password', $password, PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->rowCount();
            $row   = $stmt->fetch(PDO::FETCH_ASSOC);
            if($count == 1 && !empty($row)) {
                /******************** Your code ***********************/
                $_SESSION['sess_user_id']   = $row['uid'];
                $_SESSION['sess_user_name'] = $row['username'];
                $_SESSION['sess_name'] = $row['name'];

            } else {
                $msg = "Invalid username and password!";
            }
        } catch (PDOException $e) {
            echo "Error : ".$e->getMessage();
        }
    } else {
        $msg = "Both fields are required!";
    }
}
?>
<?=template_header('Login')?>
<div class="login">
    <h1>Aanmelden</h1>
    <form action="read.php" method="post">
        <label for="username">
            <i class="fas fa-user"></i>
        </label>
        <input type="text" name="username" placeholder="naam" id="username" required>
        <label for="password">
            <i class="fas fa-lock"></i>
        </label>
        <input type="password" name="password" placeholder="wachtwoord" id="password" required>
        <input type="submit" value="aanmelden">
    </form>
</div>
