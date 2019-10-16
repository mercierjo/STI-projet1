<?php
    /**
     * Page qui permet de changer son mot de passe
     * @author Mercier Jordan, Vogel Maximilian
     */
    
    require_once('./utils.php');
    session_start();

    if(!isset($_SESSION['username'])){
		header('Location: ./index.php');
		exit();	
    }


    //Executer si le bouton "submit" a ete presse
	if(isset($_POST['btnSubmit'])) {
        $sujetValide = isset($_POST['tbxSujet']) && !empty($_POST['tbxSujet']);
        $messageValide = isset($_POST['tbxMessage']) && !empty($_POST['tbxMessage']);

        $dataValide = $destinataireValide && $sujetValide && $messageValide;
	}

    //Tentative de changement de mot de passe du compte si le password est valide
	if(isset($_POST['btnSubmit']) && $_POST['tbxPassword'] && !empty($_POST['tbxPassword'])){
        $dbname = connect();
		$sth = $dbname->prepare('UPDATE account SET password = :password WHERE username = :username');
		$sth->bindParam(':password', hash('sha256', $_POST['tbxPassword']), PDO::PARAM_STR);
        $sth->bindParam(':username', $_SESSION['username'], PDO::PARAM_STR);

        if($sth->execute()) 
        	$passwordChange = true;
	}
?>
<!DOCTYPE html>
<html lang="fr">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

    <title>Messenger</title>
  </head>
  <body>
    <header>
        <nav class="navbar">
            <a class="navbar-brand" href="#">
                <img src="#" alt="Messenger" width="130" height="37">
            </a>
        </nav>
    </header>
    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-2">
                    <?php displayNavigation(); ?>
                </div>
                <div class="col-10">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <h1>Changement mot de passe</h1>
                                <form method="POST" action="./changepassword.php">
                                    <div class="form-group">
                                        <label>Nouveau mot de passe</label>
		                                <input type="password" class="form-control" name="tbxPassword" required="required"/>
                                    </div>
                                    <button type="submit" class="btn btn-danger" name="btnSubmit">Changer</button>
                                    <a class="btn btn-danger" href="./listmessage.php">Retour</a>
                                </form>
                                <?php if($passwordChange) { echo '<p>Le mot de passe a été changé</p>'; } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer>

    </footer>
  </body>
</html>