<?php
    /**
     * Page qui permet de cree un nouvel utilisateur
     * @author Mercier Jordan, Vogel Maximilian
     */

    require_once('./utils.php');
    session_start();

    if(!isset($_SESSION['username']) && $_SESSION['role'] != 2){
		header('Location: ./index.php');
		exit();	
    }
    
    $userValide = isset($_POST['tbxUsername']) && !empty($_POST['tbxUsername']);
    $mdpValide = isset($_POST['tbxPassword']) && !empty($_POST['tbxPassword']);
    //Executer si le bouton "submit" a ete presse
	if(isset($_POST['btnSubmit']) && $userValide && $mdpValide) {
        $dbname = connect();
        $sql = 'INSERT INTO account(username, password, validity, deleted, role) VALUES (:username, :password, :validity, 0, :role)';

        $sth = $dbname->prepare($sql);
        $sth->bindParam(':username', $_POST['tbxUsername'], PDO::PARAM_STR);
        $sth->bindParam(':password', hash('sha256', $_POST['tbxPassword']), PDO::PARAM_STR);
        $sth->bindValue(':validity', isset($_POST['tbxValide']), PDO::PARAM_BOOL);
        $sth->bindParam(':role', $_POST['role'], PDO::PARAM_INT);

		if($sth->execute()){
			$compteCree = true;	
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
                                <h1>Ajouter un utilisateur</h1>
                                <form method="POST" action="./newuser.php">
                                    <div class="form-group">
                                        <label>Nom d'utilisateur</label>
		                                <input type="textbox" class="form-control" name="tbxUsername" required/>
                                    </div>
                                    <div class="form-group">
                                        <label>Mot de passe</label>
		                                <input type="password" class="form-control" name="tbxPassword" required/>
                                    </div>
                                    <div class="form-group">
                                        <label>Valide</label>
		                                <input type="checkbox" checked="true" name="tbxValide" value="true"/>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Role</label>
                                        <select name="role" class="form-control">
		                                <?php
                                            $db = connect();
                                            $sql = 'SELECT * FROM role';
                                            $datas = $db->query($sql);

                                            foreach($datas as $row) {
                                                echo "<option value='" . $row['id'] . "'>" . $row['name'] . '</option>'; 
                                            }
                                        ?>
                                        </select>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-danger" name="btnSubmit">Ajouter</button>
                                    <a class="btn btn-danger" href="./listuser.php">Retour</a>
                                </form>
                                <?php if($compteCree) { echo 'le compte a bien été crée';} ?>
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