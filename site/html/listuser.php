<?php
    /**
     * Page qui liste les utilisateurs
     * @author Mercier Jordan, Vogel Maximilian
     */

    require_once('./utils.php');
    session_start();

    if(!isset($_SESSION['username']) && $_SESSION['role'] != 2){
		header('Location: ./index.php');
		exit();	
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
                <div class="col-2">
                    <?php displayNavigation(); ?>
                </div>
                <div class="col-10">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col">
                                <?php
                                    if(isset($_SESSION['username'])) { //Message de demarrage de session
                                        echo '<p>Session demarrée pour : ', $_SESSION['username'] , '</p>';
                                    }
                                ?>
                                <form class="form-inline" method="POST" action="./index.php">
                                <?php
                                    if(isset($_SESSION['username'])){ //Differenciation entre le bouton de deconnection et connection dependant si la personne est deja connecte ou non
                                        echo '<button class="btn btn-danger" type="submit" value="out" name="submit">Se d&eacuteconnecter</button>';
                                    }else{
                                        echo '<button class="btn btn-danger" type="submit" value="in" name="submit">Se connecter</button>';
                                    }
                                ?>
                                </form>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <h1>Liste utilisateur</h1>
                                <?php
                                    if(isset($_SESSION['username']) && $_SESSION['role'] == 2) {
                                        $dbh = connect();
                                        $sql = 'SELECT account.username, account.validity, role.name FROM account INNER JOIN role ON account.role = role.id';
                                        
                                        $datas = $dbh->query($sql);

                                        echo "<table class='table table-striped'>
                                                <thead class='thead-dark'>
                                                    <tr>
                                                        <th scope='col'>Username</th>
                                                        <th scope='col'>Rôle</th>
                                                        <th scope='col'>Actif</th>
                                                        <th colspan=2 scope='col'>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>";

                                        foreach($datas as $row) {
                                            echo '<tr><td>' . $row['username'] . '</td><td>' . $row['name'] . '</td><td>';
                                            if($row['validity']) echo 'Oui'; else echo 'Non';
                                            echo "</td><td><a class='text-danger' href='./modifyuser.php?username=" . $row['username'] . "'>Modifier</a></td><td>";
                                            echo "<a class='text-danger' href='./deleteuser.php?username=" . $row['username'] . "'>Supprimer</a></td>";
                                        }
                                        echo  '</tbody></table>';
                                    }
                                ?>
                                <a class="btn btn-danger" href="./newuser.php">Nouvel utilisateur</a>
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