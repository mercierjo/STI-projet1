<?php
    /**
     * Page de connexion du site
     * @author Mercier Jordan, Vogel Maximilian
     */
    
    require_once('./utils.php');
    session_start();

	if(isset($_SESSION['username'])){ 
        //Destruction de la session si une connexion est en cours et que la demande de deconnexion a ete fait
		if(isset($_POST['submit']) && $_POST['submit'] === 'out')
			session_destroy();
		
		header('Location: ./listmessage.php');
		exit();	
    }
    
    //Controle si les informations sont valides en cas de tentative de connexion
    $badLogin = false;
    if(isset($_POST['submitted'])){
        $dbname = connect();

        $sth = $dbname->prepare("SELECT username, password, validity, role FROM account WHERE username = :username AND password = :password");
        $sth->bindParam(':username', $_POST['tbxEmail'], PDO::PARAM_STR);
        $sth->bindParam(':password', hash('sha256', $_POST['tbxPassword']), PDO::PARAM_STR);
        $sth->execute();

        $result = $sth->fetch();

        $badLogin = empty($result);

        if(!$badLogin && $result['validity'] == 1){
            $_SESSION['username'] = $result['username'];
            $_SESSION['role'] = $result['role'];
            header('Location: ./listmessage.php');
            exit();
        }
    }
?>
<!doctype html>
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
                <div class="col-12">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <form method="POST" action="./index.php">
                                    <div class="form-group">
                                        <label>Email</label>
		                                <input type="textbox" class="form-control" name="tbxEmail"/>
                                    </div>
                                    <div class="form-group">
                                        <label>Mot de passe</label>
		                                <input type="password" class="form-control" name="tbxPassword"/>
                                    </div>
                                    <input type="hidden" name="submitted"/>
		                            <button type="submit" class="btn btn-danger">Login</button>
                                    <?php if($badLogin) { 
                                            echo '<p>Mauvais email ou mot de passe, veuillez réessayer !</p>
                                                 <p>Le compte est peut être désactivé !</p>';
                                        }
                                    ?>
                                </form>
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