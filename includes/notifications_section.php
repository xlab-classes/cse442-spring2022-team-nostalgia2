<div class="login-box">
    <div class = heading>
        <h1>Your notifications:</h1>
    </div>

    <div class="inner">
        <?php
            $conn = new mysqli("oceanus.cse.buffalo.edu", "elijahhu", "50284336", "cse442_2022_spring_team_d_db");
            if ($conn->connect_error) {
                die("Connect could not succeed due to: " . $conn->connect_error);
            }
            $currUser = $_SESSION["username"];
            $getNotifs = $conn->prepare("SELECT * FROM notifications where username=?");
            $getNotifs->bind_param("s", $currUser);
            if($getNotifs->execute() === TRUE){
                $res = $getNotifs->get_result();
                $data = $res->fetch_assoc();
                $decodedNotifs = json_decode($data["notifications"], true);
                $notifications = $decodedNotifs;
                foreach($notifications as $notification){
                    if(!is_null($notification["type"])){
                        $event = $notification["event"];
                        $user = $notification["type"];
                        $msg = $user." made a new post!. Check it out <a href=$event>here.</a>";
                        echo '<div class="msg">'.$msg.'</div>';
                    } else {
                        $event = $notification["event"];
                        $msg = $event." has followed you!";;
                        echo '<div class="msg">'.$msg.'</div>';
                    }
                }
            }
        ?>
    </div>
</div>