<?php 
session_start();
include_once "config.php";

// Check if email and password are provided
if(isset($_POST['email']) && isset($_POST['password'])){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password']; // Password should not be escaped, as it is hashed later

    if(!empty($email) && !empty($password)){
        // Select user with provided email
        $sql = mysqli_prepare($conn, "SELECT unique_id, password FROM users WHERE email = ?");
        mysqli_stmt_bind_param($sql, "s", $email);
        mysqli_stmt_execute($sql);
        $result = mysqli_stmt_get_result($sql);

        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_assoc($result);
            $stored_password = $row['password'];

            // Verify password
            if(password_verify($password, $stored_password)){
                // Set status to "Active now" for current user
                $status = "Active now";
                $sql_update = mysqli_prepare($conn, "UPDATE users SET status = ? WHERE unique_id = ?");
                mysqli_stmt_bind_param($sql_update, "si", $status, $row['unique_id']);
                $update_result = mysqli_stmt_execute($sql_update);

                if($update_result){
                    $_SESSION['unique_id'] = $row['unique_id'];
                    echo "success";
                }else{
                    echo "Something went wrong. Please try again!";
                }
            }else{
                echo "Email or Password is Incorrect!";
            }
        }else{
            echo "$email - This email does not exist!";
        }
    }else{
        echo "All input fields are required!";
    }
}else{
    echo "All input fields are required!";
}
?>
