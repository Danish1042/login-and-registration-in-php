<?php include('./layouts/header.php') ?>



<div class="container">
    <div class="row d-flex justify-content-center p-4">
        <div class="col-md-6">
            <form action="register.php" method="post" class="border p-4 rounded shadow">
                <?php
                if (isset($_POST['submit'])) {
                    $name = $_POST['name'];
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    $c_password = $_POST['c_password'];

                    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                    // validation in php 
                    $errors = array();
                    if (empty($name) or empty($email) or empty($password) or empty($c_password)) {
                        array_push($errors, 'All Fields are Required');
                    }
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        array_push($errors, 'Email is not valid!');
                    }
                    if (strlen($password) < 5) {
                        array_push($errors, 'Password must be at least 5 characters');
                    }
                    if ($password !== $c_password) {
                        array_push($errors, 'Password does not matched!');
                    }
                    include('./db.php');
                    $sql = "SELECT * from `users` WHERE `email` = '$email'";
                    $result = mysqli_query($connection, $sql);
                    $rowcount = mysqli_num_rows($result);
                    if ($rowcount > 0) {
                        array_push($errors, "Please Enter a unique Email");
                    }
                    if (count($errors) > 0) {
                        foreach ($errors as $error) {
                            echo "<div class='alert alert-danger'>$error</div>";
                        }
                    } else {
                        // if All set
                        $sql = "INSERT INTO `users` (name, email, password) VALUES (?, ?, ?)";
                        $stmt = mysqli_stmt_init($connection);
                        $prepare_stmt = mysqli_stmt_prepare($stmt, $sql);
                        if ($prepare_stmt) {
                            mysqli_stmt_bind_param($stmt, "sss", $name, $email, $passwordHash);
                            mysqli_stmt_execute($stmt);
                            echo "<div class='alert alert-success'>You are registered Successfully</div>";
                        } else {
                            die('Something went wrong');
                        }
                    }
                }
                ?>
                <h4>Registration Form</h4>
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" name="name">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" name="email">
                <label for="password" class="form-label">Password</label>
                <input type="text" class="form-control" name="password">
                <label for="c_password" class="form-label">Confirm Password</label>
                <input type="text" class="form-control" name="c_password">
                <a href="<?php echo './' ?>" class="">Already have an Account?</a><br>
                <button type="submit" name="submit" class="btn btn-success mt-3">Register</button>
            </form>
        </div>
    </div>
</div>
<?php include('./layouts/footer.php') ?>