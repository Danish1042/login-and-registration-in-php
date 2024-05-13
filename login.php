<?php include('./layouts/header.php') ?>
<?php
session_start();
if (isset($_SESSION["user"])) {
    header("Location: ./");
}
?>



<div class="container">
    <div class="row d-flex justify-content-center p-4">
        <div class="col-md-6">
            <form action="" method="post" class="border p-4 rounded shadow">
                <h4>Login Form</h4>
                <?php
                if (isset($_POST['login'])) {
                    $email = $_POST['email'];
                    $password = $_POST['password'];

                    // validation in php 
                    $errors = array();

                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        array_push($errors, 'Email is not valid!');
                    }
                    if (strlen($password) < 5) {
                        array_push($errors, 'Password must be at least 5 characters');
                    }

                    require_once './db.php';
                    $sql = "SELECT * FROM users WHERE email = '$email'";
                    $result = mysqli_query($connection, $sql);
                    $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    if ($user) {
                        if (password_verify($password, $user["password"])) {
                            session_start();
                            $_SESSION["user"] = "yes";
                            header("Location: index.php");
                            die();
                        } else {
                            echo "<div class='alert alert-danger'>Password does not matched</div>";
                        }
                    } else {
                        echo "<div class='alert alert-danger'>Email does not matched</div>";
                    }
                }
                ?>
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" name="email">
                <label for="password" class="form-label">Password</label>
                <input type="text" class="form-control" name="password">
                <a href="<?php echo './register.php' ?>" class="">Don't have an account?</a><br>
                <button type="submit" name="login" class="btn btn-success mt-3">Login</button>
            </form>
        </div>
    </div>
</div>
<?php include('./layouts/footer.php') ?>