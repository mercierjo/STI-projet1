<?php
    /**
     * Page qui permet d'ecrire un nouveau message
     * @author Mercier Jordan, Vogel Maximilian
     */

    require_once('./utils.php');
    session_start();

    if(!isset($_SESSION['username'])){
		header('Location: ./index.php');
		exit();	
    }

    if(isset($_GET['id'])) {
        $dbh = connect();
        $sql = 'SELECT sender, subject FROM message WHERE id = :id';
        $request = $dbh->prepare($sql);
        $request->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
        $request->execute();

        $result = $request->fetch();

        $_POST['tbxDestinataire'] = $result['sender'];
        $_POST['tbxSujet'] = $result['subject'];
    }

    //Les variables de type bool suivants sont utilise pour l'affichage d'erreur lors d'une mauvaise saisie et permet aussi de reduire la longueur d'affichage des tests
    $destinataireValide = false;
    $sujetValide = true;
    $messageValide = true;

    $dataValide = false; // Toutes les donnees sont valides

    //Executer si le bouton "submit" a ete presse
	if(isset($_POST['btnSubmit'])) {
        if(isset($_POST['tbxDestinataire'])) {
            $db = connect();
            $request = $db->prepare('SELECT username FROM account WHERE username = :username');
            $request->bindParam(':username', $_POST['tbxDestinataire'], PDO::PARAM_STR);
            $request->execute();
            $result = $request->fetch();

            $destinataireValide = !empty($result);
        }
        
        $sujetValide = isset($_POST['tbxSujet']) && !empty($_POST['tbxSujet']);
        $messageValide = isset($_POST['tbxMessage']) && !empty($_POST['tbxMessage']);

        $dataValide = $destinataireValide && $sujetValide && $messageValide;
    }

    //Tentative d'ajout du message dans la base de donnee
	if($dataValide){
		$sth = $db->prepare('INSERT INTO message(id, recieveDate, sender, reciever, subject, message) VALUES (NULL, :recieveDate, :sender, :reciever, :subject, :message)');
		$sth->bindValue(':recieveDate', date('Y-m-d', time()), PDO::PARAM_STR);
        $sth->bindValue(':sender', $_SESSION['username'], PDO::PARAM_STR);
        $sth->bindValue(':reciever', $_POST['tbxDestinataire'], PDO::PARAM_STR);
        $sth->bindValue(':subject', $_POST['tbxSujet'], PDO::PARAM_STR);
        $sth->bindValue(':message', $_POST['tbxMessage'], PDO::PARAM_STR);

		if($sth->execute()){
			$messageEnvoye = true;	
		}
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
                                <h1>Nouveau message</h1>
                                <form method="POST" action="<?php if(isset($_GET['id'])) echo './newmessage.php?id=' . $_GET['id']; else  echo './newmessage.php'; ?>">
                                    <div class="form-group">
                                        <label>Destinataire</label>
		                                <input type="textbox" class="form-control" name="tbxDestinataire" required="required" value="<?php if(isset($_POST['tbxDestinataire'])) { echo $_POST['tbxDestinataire']; }?>"/>
                                    </div>
                                    <div class="form-group">
                                        <label>Sujet</label>
		                                <input type="textbox" class="form-control" name="tbxSujet" required="required" value="<?php if(isset($_POST['tbxSujet'])) { echo 'RE: ' . $_POST['tbxSujet']; }?>"/>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Message</label>
		                                <input type="textarea" class="form-control" name="tbxMessage" required="required"/>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-danger" name="btnSubmit">Envoyer</button>
                                    <a class="btn btn-danger" href="./listmessage.php">Retour</a>
                                </form>
                                <?php if($messageEnvoye) { echo 'le message a été envoyé';} ?>
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