                    <div class="info-box">
                        <div class="heading">
                            <h1>Create a post!</h1>
                        </div>
                        <div class="inner">
                            <div class="details">
                                <p>Rules:</p>
                                <ul>
                                    <li>
                                        Keep it clean.
                                    </li>
                                    <li>
                                        Don't spam.
                                    </li>
                                    <li>
                                        TODO: Add more.
                                    </li>
                                </ul>
                            </div>
                            <div class="post-textarea">
                                <form method="post" enctype="multipart/form-data">
                                    Post Title:
                                    <br>
                                    <textarea readonly class="post-title" name="post-title" maxlength="255"><?php echo $post['title']; ?></textarea>
                                    <br>
                                    Post Body:
                                    <br>
                                    <textarea class="post-body" name="post-body" maxlength="40000"><?php echo html_entity_decode($post['body']); ?></textarea>
                                    <br>
                                    <input type="submit">
                                </form>
                                <br>
                                <?php
                                    if (!empty($_POST)){
                                        $conn = new mysqli("oceanus.cse.buffalo.edu", "elijahhu", "50284336", "cse442_2022_spring_team_d_db");
                                        if ($conn->connect_error) {
                                            die("Connect could not succeed due to: " . $conn->connect_error);
                                        }
                                        
                                        $slug = $post['slug'];
                                        $body = $_POST["post-body"];
                                        $body = str_replace("'", "''", "$body");

                                        $query = "UPDATE posts SET body='$body', updated_at=now() WHERE slug='$slug' LIMIT 1";
                                        $conn->query($query);
                                        $event = "single_post.php?post-slug='$slug'";
                                        notifyPost($_SESSION["username"], $event);
                                        echo '<div class="msg">Post updated. Check it out <a href="single_post.php?post-slug='.$slug.'">here.</a></div>';
                                    }
                                ?>
                            </div> <!-- /post-textarea -->
                        </div> <!-- /inner -->
                    </div> <!-- /info-box -->