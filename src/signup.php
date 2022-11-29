<?php
    include "functions.php";

    $errors = [];

    if($_POST['submit']) {
        if(!$_POST['name']) {
            $errors[] = "Name is required.";
        }
        if(!$_POST['email']) {
            $errors[] = "Email is required.";
        }
        if(!$_POST['password']) {
            $errors[] = "Password is required.";
        }

        if(empty($errors)) {
            if(!check_existing_email($_POST['email'])){
                // save user to db
            } else {
                $errors[] = "The email is already existed.";
            }
        }
    }
?>
<?php include "layouts/_header.php"; ?>
            <header>
                <?php include "layouts/_navigation.php"; ?>
            </header>
            <section>
                <div class="container">
                    <div id="register">
                        <div id="register-form">
                            <h1>Register an account.</h1>
                            <?php if(!empty($errors)) { ?>
                                <div class="alert alert-danger">
                                    <ul>
                                        <?php foreach($errors as $row) { ?>
                                            <li><?= $row ?></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            <?php } ?>
                            <form method="post">
                                <div class="input-control">
                                    <label for="name">Name: </label>
                                    <input type="text" name="name" class="input-field" value="<?= $_POST['name'] ?>"/>
                                </div>
                                <div class="input-control">
                                    <label for="email">Email: </label>
                                    <input type="email" name="email" class="input-field" value="<?= $_POST['email'] ?>"/>
                                </div>
                                <div class="input-control">
                                    <label for="name">Password: </label>
                                    <input type="password" name="password" class="input-field" value="<?= $_POST['password'] ?>" />
                                </div>
                                <div class="input-control">
                                    <input type="submit" name="submit" class="btn btn-md btn-rounded" value="Register" />
                                </div>
                            </form>
                        </div>                
                    </div>                    
                </div>
            </section>
<?php include "layouts/_footer.php" ; ?>