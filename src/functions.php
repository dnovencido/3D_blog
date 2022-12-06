<?php
    require "db.php";

    function check_existing_email($email) {
        global $connection;
        $flag = false;

        $query = "SELECT * FROM `users` WHERE `email` = '".escape_string($email)."'";
        $result = mysqli_query($connection, $query);

        if(mysqli_num_rows($result) > 0) {
            $flag = true;
        } 

        return $flag;
    }

    function escape_string($field) {
        global $connection;

        return mysqli_real_escape_string($connection, $field);
    }

    function save_registration($name, $email, $password) {
        global $connection;
        $user = [];

        $query = "INSERT INTO `users` (`name`, `email`) VALUES ('".escape_string($name)."', '".escape_string($email)."')";
        
        if(mysqli_query($connection, $query)) {
            $id = mysqli_insert_id($connection);
            $encrypted_password = md5(md5($id . $password));

            $query = "UPDATE `users` SET `users`.`password` = '".escape_string($encrypted_password)."' WHERE `users`.`id` = '".$id."'";
            if(mysqli_query($connection, $query)) {
                $query = "SELECT * FROM `users` WHERE `users`.`id` = '".$id."' AND `users`.`password` = '".escape_string($encrypted_password)."' LIMIT 1";
                $result = mysqli_query($connection, $query);
                $row = mysqli_fetch_array($result);

                $user = [
                    "id" => $row['id'],
                    "name" => $row['name'] 
                ];
            }
        }

        return $user;
    }

    function login_account($email, $password) {
        global $connection;
        $user = [];

        $query = "SELECT * FROM `users` WHERE `users`.`email` = '".escape_string($email)."'";
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_array($result);
        
        if(!empty($row)) {
            $hashed_password = md5(md5($row['id'] . $password));
            if($row['password'] == $hashed_password) {
                $user = [
                    "id" => $row['id'],
                    "name" => $row['name']
                ];
            }
        }

        return $user;
    }

    function get_categories() {
        global $connection;
        $categories = [];

        $query= "SELECT * FROM `categories`";
        $result = mysqli_query($connection, $query);

        if(mysqli_num_rows($result)) {
            $categories = $result;
        }

        return $categories;
    }

    function save_blog($title, $body, $category_id, $user_id) {
        global $connection;
        $flag = false;

        $date_created = date("Y-m-d H:i:s");
        $query = "INSERT INTO `blogs` (`user_id`, `category_id`, `title`,  `body`, `date_created`) VALUES ('".escape_string($user_id)."', '".escape_string($category_id)."', '".escape_string($title)."', '".escape_string($body)."', '".$date_created."')";

        if(mysqli_query($connection, $query)) {
            $flag = true;
        } 
        return $flag;
    }

    function get_my_blogs($user_id) {
        global $connection;
        $blogs = [];
        
        $query = "SELECT `b`.`id` as `blog_id`, `b`.`title`, `b`.`body`, `c`.`category_name`, `b`.`date_created` FROM `blogs` as `b` INNER JOIN `categories` as `c` ON `c`.`id` = `b`.`category_id` WHERE `b`.`user_id` = '".escape_string($user_id)."'";
        $result = mysqli_query($connection, $query);
        
        if(mysqli_num_rows($result) > 0) {
            $blogs = $result;
        }
        
        return $blogs;
    }

?>