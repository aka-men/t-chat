<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="author" content="Abdelhak Ouaddi">

    <title>T-Chat : Authentification</title>

    <link rel="stylesheet" href="assets/bootstrap-3.3.7/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="assets/global/css/login.css" type="text/css">
</head>

<body>

<div class="container">

    <form method="post" action="index.php?act=login&ctrl=user" class="form-signin">
        <?php if (isset($error_msg) and !empty($error_msg)){?>
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <p><?php echo $error_msg; ?></p>
        </div>
        <?php }?>
        <h2 class="form-signin-heading">Authentification</h2>
        <label for="username" class="sr-only">Nom utilisateur</label>
        <input type="text" id="username" name="username" class="form-control" placeholder="Nom utilisateur" required autofocus>
        <label for="password" class="sr-only">Mot de passe</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="Mot de passe" required>

        <button class="btn btn-lg btn-primary btn-block" type="submit">Connexion</button>
    </form>

</div>
<script type="text/javascript" src="assets/jquery-3.2.1/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="assets/bootstrap-3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
