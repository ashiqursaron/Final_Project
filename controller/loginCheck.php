<?php
// filepath: c:\xampp\htdocs\project\controller\loginCheck.php


session_start();
require_once '../model/db_connection.php'; // Include database connection
error_log("Username: " . $username);
error_log("Password: " . $password);

error_log("Username received: " . $_POST['username']);
error_log("Password received: " . $_POST['password']);

header('Content-Type: application/json');

if (isset($_POST['submit'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $rememberMe = isset($_POST['rememberMe']); // Check if "Remember Me" is selected

    if ($username == "" || $password == "") {
        echo "null username/password!";
    } else {
        // Query to check username and retrieve user info
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            error_log("User found in database");
            $user = $result->fetch_assoc();

                        
            error_log("Hashed password from database: " . $user['password']);
            error_log("Entered password: " . $password);

            // Verify hashed password
            if (password_verify($password, $user['password'])) {
                error_log("Password verified successfully");

                // Insert login time into user_login_times table
                $loginTime = date('Y-m-d H:i:s');
                $insertLoginTimeSql = "INSERT INTO user_login_times (user_id, user_type, login_time) VALUES (?, ?, ?)";
                $stmtLoginTime = $conn->prepare($insertLoginTimeSql);
                $stmtLoginTime->bind_param("iss", $user['id'], $user['user_type'], $loginTime);
                $stmtLoginTime->execute();
                $stmtLoginTime->close();
                
                
                // Set session for logged-in user
                $_SESSION['status'] = true;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['user_type'] = $user['user_type'];

                // Set cookies if "Remember Me" is checked
                if ($rememberMe) {
                    setcookie('status', 'true', time() + (30 * 24 * 60 * 60), '/'); // 30 days
                    setcookie('user_id', $user['id'], time() + (30 * 24 * 60 * 60), '/');
                    setcookie('username', $user['username'], time() + (30 * 24 * 60 * 60), '/');
                    setcookie('user_type', $user['user_type'], time() + (30 * 24 * 60 * 60), '/');
                }

                // Redirect based on user type
                if ($user['user_type'] === 'admin') {
                    header('location: ../view/admin_dashboard.php');
                } else if ($user['user_type'] === 'user') {
                    header('location: ../view/home.php');
                } else {
                    echo "Invalid user type!";
                }
            } else {
                error_log("Password verification failed");
                echo "Invalid username/password!";
            }
        } else {
            error_log("No user found with the given username");
            echo "Invalid username/password!";
        }

        $stmt->close();
    }
} else {
    header('location: ../view/login.html');
}

$conn->close();









// if (isset($_POST['submit'])) {
//     $username = trim($_POST['username']);
//     $password = trim($_POST['password']);
//     $rememberMe = isset($_POST['rememberMe']); // Check if "Remember Me" is selected

//     if ($username == "" || $password == "") {
//         $response = ['success' => false, 'message' => 'Username and password cannot be empty.'];
//         echo json_encode($response);
//         exit();
//     }

//     // Query to check username and retrieve user info
//     $sql = "SELECT * FROM users WHERE username = ?";
//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param("s", $username);
//     $stmt->execute();
//     $result = $stmt->get_result();

//     if ($result->num_rows > 0) {
//         $user = $result->fetch_assoc();

//         // Verify hashed password
//         if (password_verify($password, $user['password'])) {
//             // Insert login time into user_login_times table
//             $loginTime = date('Y-m-d H:i:s');
//             $insertLoginTimeSql = "INSERT INTO user_login_times (user_id, user_type, login_time) VALUES (?, ?, ?)";
//             $stmtLoginTime = $conn->prepare($insertLoginTimeSql);
//             $stmtLoginTime->bind_param("iss", $user['id'], $user['user_type'], $loginTime);
//             $stmtLoginTime->execute();
//             $stmtLoginTime->close();

//             // Set session for logged-in user
//             $_SESSION['status'] = true;
//             $_SESSION['user_id'] = $user['id'];
//             $_SESSION['username'] = $user['username'];
//             $_SESSION['user_type'] = $user['user_type'];

//             // Set cookies if "Remember Me" is checked
//             if ($rememberMe) {
//                 setcookie('status', 'true', time() + (30 * 24 * 60 * 60), '/'); // 30 days
//                 setcookie('user_id', $user['id'], time() + (30 * 24 * 60 * 60), '/');
//                 setcookie('username', $user['username'], time() + (30 * 24 * 60 * 60), '/');
//                 setcookie('user_type', $user['user_type'], time() + (30 * 24 * 60 * 60), '/');
//             }

//             // Redirect based on user type
//             if ($user['user_type'] === 'admin') {
//                 $response = ['success' => true, 'redirect' => '../view/admin_dashboard.php'];
//             } else if ($user['user_type'] === 'user') {
//                 $response = ['success' => true, 'redirect' => '../view/home.php'];
//             } else {
//                 $response = ['success' => false, 'message' => 'Invalid user type.'];
//             }
//         } else {
//             $response = ['success' => false, 'message' => 'Invalid username or password.'];
//         }
//     } else {
//         $response = ['success' => false, 'message' => 'Invalid username or password.'];
//     }

//     $stmt->close();
// } else {
//     $response = ['success' => false, 'message' => 'Invalid request.'];
// }

// $conn->close();
// echo json_encode($response);





?>