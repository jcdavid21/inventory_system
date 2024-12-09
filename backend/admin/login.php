<?php 
    session_start();
    require_once("../config/config.php");

    if(isset($_POST["username"]) && isset($_POST["password"]))
    {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $query = "SELECT ta.account_id, ta.acc_password, ta.acc_username, ta.status_id,
        CONCAT(td.first_name, ' ', td.middle_name, ' ', td.last_name) AS full_name, 
        td.contact, td.gender, td.address 
        FROM tbl_account ta 
        INNER JOIN tbl_account_details td ON 
        ta.account_id = td.account_id WHERE ta.acc_username = ?";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0){
            $data = $result->fetch_assoc();
            $hashedPassword = $data["acc_password"];

            if(password_verify($password, $hashedPassword))
            {
                $status = $data["status_id"];
                if($status == 2){
                    echo "deactivated";
                    exit();
                }
                $date = date("Y-m-d");
                $activity = "Login";
                $query2 = "INSERT INTO tbl_logs(user_id, user_name, activity_date, activity) VALUES(?, ?, ?, ?)";
                $stmt2 = $conn->prepare($query2);
                $stmt2->bind_param("isss", $data["account_id"], $data["acc_username"], $date, $activity);
                $stmt2->execute();

                $sessionData = array(
                    "account_id" => $data["account_id"],
                    "role_id" => $data["role_id"],
                    "username" =>  $data["acc_username"],
                    "full_name" => $data["full_name"],
                    "contact" => $data["contact"],
                    "gender" => $data["gender"],
                    "address" => $data["address"],
                ); //array_associative
                $_SESSION["admin_id"] = $data["account_id"];
                echo json_encode($sessionData);
            }else{
                echo "Invalid Password";
            }

        }else{
            echo "Invalid Password";
        }
    }


?>