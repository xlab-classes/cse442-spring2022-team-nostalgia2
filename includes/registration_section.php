                    <div class="register-box">
                        <div class="heading">
                            <h1>Create an account for Nostalgia!!</h1>
                        </div>
                        <div class="inner">
                            <form id="register" action="" method="POST">
                                <input type="text" name="reguser" id="reguser" autocomplete="off" placeholder="Enter desired username...">
                                <p>Your password must contain:</p>
                                <ul>
                                    <li class="password-conditions">at least 8 characters
                                    <li class="password-conditions">at least 1 lower case letter
                                    <li class="password-conditions">at least 1 upper case letter
                                    <li class="password-conditions">at least 1 number
                                </ul>
                                <br>
                                <input type="password" name="regpass" id="regpass" autocomplete="off" placeholder="Enter desired password..."><br>
                                <input type="password" name="passcheck" id="passcheck" autocomplete="off" placeholder="Re-enter password..."><br>
                                <input type="submit">
                            </form>

                            <?php
                                if (!empty($_POST)){
                                    $conn = new mysqli("oceanus.cse.buffalo.edu", "elijahhu", "50284336", "cse442_2022_spring_team_d_db");
                                    if ($conn->connect_error) {
                                        die("Connect could not be made due to: " . $conn->connect_error);
                                    }

                                    $username = $_POST["reguser"];
                                    $pass = $_POST["regpass"];
                                    $check = $_POST["passcheck"];

                                    if(!str_contains($username, " ")){
                                        if(isset($username) && !empty($username)){
                                            if(isset($pass) && !empty($pass)){
                                                if(isset($check) && !empty($check)){

                                                    $query = $conn->prepare("SELECT * FROM users where username=?");
                                                    $query->bind_param("s", $username);
                                                    if ($query->execute() === TRUE) {
                                                        $count = $query->get_result();

                                                        if($count->num_rows > 0){
                                                            $msg = "This username has already been taken. Please choose another one.";
                                                            echo '<div class="msg">'.$msg.'</div>';
                                                        } else if (strlen($pass) < 8){
                                                            $msg = "Your password is too short. It must be at least 8 characters.";
                                                            echo '<div class="msg">'.$msg.'</div>';
                                                        } else if (!preg_match("#[a-z]+#", $pass)){
                                                            $msg = "Your password must contain at least 1 lowercase letter.";
                                                            echo '<div class="msg">'.$msg.'</div>';
                                                        } else if (!preg_match("#[A-Z]+#", $pass)){
                                                            $msg = "Your password must contain at least 1 uppercase letter.";
                                                            echo '<div class="msg">'.$msg.'</div>';
                                                        } else if (!preg_match("#[0-9]+#", $pass)){
                                                            $msg = "Your password must contain at least 1 number.";
                                                            echo '<div class="msg">'.$msg.'</div>';
                                                        } else if ($pass != $check){
                                                            $msg = "Your passwords do not match!";
                                                            echo '<div class="msg">'.$msg.'</div>';
                                                        } else {
                                                            $hashed = password_hash($pass, PASSWORD_DEFAULT);
                                                            $insquery = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
                                                            $followquery = $conn->prepare("INSERT INTO followers (username, followers) VALUES (?, ?)");
                                                            $insquery->bind_param("ss", $username, $hashed);
                                                            $followers = [
                                                                "followers" => array(),
                                                                "following" => array()
                                                            ];
                                                            $notifQuery = $conn->prepare("INSERT INTO notifications (username, notifications) VALUES (?, ?)");
                                                            $notifications = array();
                                                            $notifArr = json_encode($notifications);
                                                            $jsonArr = json_encode($followers);
                                                            $notifQuery->bind_param("ss", $username, $notifArr);
                                                            $followquery->bind_param("ss", $username, $jsonArr);
                                                            $bioQuery = $conn->prepare("INSERT INTO bios (username, bio) VALUES (?,?)");
                                                            $default_bio = "Hello! Welcome to my page";
                                                            $bioQuery->bind_param("ss",$username, $default_bio);
                                                            if($insquery->execute() === TRUE){
                                                                if($followquery->execute() === TRUE){
                                                                    if($notifQuery->execute() === TRUE){
                                                                        if($bioQuery->execute()===TRUE){
                                                                            $msg = "You've successfully created an account!";
                                                                            echo '<div class="msg">'.$msg.'</div>';
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                            else {
                                                                echo "Query failed due to: " . $conn->error;
                                                            }
                                                        }
                                                    } else {
                                                        echo "Query failed due to " . $conn->error;
                                                    }
                                                } else {
                                                    $msg = "Please re-enter your password.";
                                                    echo '<div class="msg">'.$msg.'</div>';
                                                }
                                            } else {
                                                $msg = "Please fill in the password field.";
                                                echo '<div class="msg">'.$msg.'</div>';
                                            }
                                        } else {
                                            $msg = "Please fill in the username field.";
                                            echo '<div class="msg">'.$msg.'</div>';
                                        }
                                    } else {
                                        $msg = "Your username cannot contain any spaces.";
                                         echo '<div class="msg">'.$msg.'</div>';
                                    }

                                }
                            ?>
                            <br>
                            <p>Already have an account? <a class="in-text" href="login.php">Login!</a></p>
                        </div>
                    </div>