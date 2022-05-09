<div class="followers-box">
    <div class="inner">
        <?php
            $conn = new mysqli("oceanus.cse.buffalo.edu", "elijahhu", "50284336", "cse442_2022_spring_team_d_db");
            if ($conn->connect_error) {
                die("Connect could not succeed due to: " . $conn->connect_error);
            }
            $currUser = $_SESSION["username"];
            echo "<div class=heading>"$currUser"</div>";
            
            echo "BIO:";
            $getbio = $conn->prepare("SELECT * FROM bios where username=?");
            $getbio->bind_param("s", $currUser);
            if($getbio->execute() === TRUE){
                $res = $getbio->get_result();
                $data = $res->fetch_assoc();
                echo .$data["bio"];
            }
        ?>

    <div class="inner">
        <form id="bio" action="" method="POST">
            <p>Edit your bio:</p>
            <input type="text" name="newbio" id="newbbio" autocomplete="off" placeholder="Type a new bio...">
            <br>
            <input type="submit" value="Update!">
        </form>
        <br>

        <?php
            if (!empty($_POST)){
                $conn = new mysqli("oceanus.cse.buffalo.edu", "elijahhu", "50284336", "cse442_2022_spring_team_d_db");
                if ($conn->connect_error) {
                    die("Connect could not succeed due to: " . $conn->connect_error);
            }

            require_once('public_functions.php');
            $newbio = $_POST["newbio"];
            $updatebio = $conn->prepare("INSERT INTO bios (username, bio) VALUES (?, ?)");
            $updatebio->bind_param("s",$newbio)

            if($updatebio->execute() === TRUE){
                echo "Updated!"
            } else {
                echo "Fail" . $conn->error;
            }
        ?>
</div>
    
