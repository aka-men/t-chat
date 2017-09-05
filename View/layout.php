<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Abdelhak Ouaddi">
    <meta name="author" content="">
    <link rel="stylesheet" href="assets/bootstrap-3.3.7/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="assets/global/css/layout.css" type="text/css">

    <title>T'Chat <?php echo $_GET['action'] ?></title>

</head>

<body>

<div class="container">
    <div class="header clearfix">
        <nav>
            <ul class="nav nav-pills pull-right">
                <li role="presentation"><a href="index.php?act=logout&ctrl=user">Déconnexion</a></li>
            </ul>
        </nav>
        <h3 class="text-muted">Bonjour <?php echo $user->getUsername(); ?></h3>
    </div>

    <div class="jumbotron">
        <h1>T'Chat</h1>
    </div>

    <div class="row marketing">
        <div class="col-lg-4">
            <h4>Ulisateurs en ligne</h4>
            <ul id="usersConnected" data-url="index.php?ctrl=user&act=connected" class="list-group" style="height: 300px;overflow-y: auto;">
                <?php include_once 'list_users_connected.php'; ?>
            </ul>
        </div>
        <div class="col-lg-8">
            <h4>Messages</h4>
            <div data-url="index.php?ctrl=message&act=refresh" id="msgs">
                <?php
                foreach ($messages as $msg){
                    echo '<p data-id="'.$msg->getId().'"><span title="'.$msg->getDate()->format('d/m/Y H:i').'" class="username label label-success">'.$msg->getUser()->getUsername().'</span><span class="msg">'.$msg->getContenu().'</span></p>';
                }
                ?>
            </div>
            <div class="form">
                <form method="POST" id="formMsg" action="index.php?act=create&ctrl=message">
                    <div class="form-group">
                        <textarea class="form-control" id="contenu" name="contenu" placeholder="Message" role="2"></textarea>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="assets/jquery-3.2.1/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="assets/bootstrap-3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/global/js/layout.js"></script>
</body>
</html>
