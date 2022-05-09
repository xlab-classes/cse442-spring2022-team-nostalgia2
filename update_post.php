<?php require('includes/public_functions.php') ?>

<?php 
	if (isset($_GET['post-slug'])) {
		$post = getPost($_GET['post-slug']);
	}
?>

<?php include('includes/head_section.php') ?>
    <title>Nostalgia — Update Post</title>
</head>

<?php
    session_start();
    if(!isset($_SESSION["username"])){
        header('Location: login.php'); exit;
    }
?>

<body>
    <!-- container = navbar + main + footer -->
    <div class="container">
        <!-- navbar -->
        <?php include('includes/navbar_section.php') ?>
        <!-- /navbar -->

        <!-- content -->
        <div class="content">
            <div class="row profile page-index">
                <div class="col left w-40">
                    <?php include('includes/update_post_section.php') ?>    
                </div> <!-- /col left w-40 -->
                <div class="col right">
                </div>
            </div>
        </div>
        <!-- /content -->

        <!-- footer -->
        <?php include('includes/footer_section.php') ?>