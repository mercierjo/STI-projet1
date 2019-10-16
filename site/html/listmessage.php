<?php
    /**
     * Page qui liste les messages reçus d'un utilisateur
     * @author Mercier Jordan, Vogel Maximilian
     */

    require_once('./utils.php');
    session_start();

    if(!isset($_SESSION['username'])){
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
                                <h1>Mes messages</h1>
                                <?php
                                    //Affichage des messages pour l'utilisateur authentifie
                                    if(isset($_SESSION['username'])) {
                                        $dbh = connect();
                                        $sql = 'SELECT id, recieveDate, sender, subject FROM message WHERE reciever = :username ORDER BY recieveDate DESC';
                                        $request = $dbh->prepare($sql);
                                        $request->bindParam(':username', $_SESSION['username'], PDO::PARAM_STR);
                                        $request->execute();
                                        
                                        $datas = $request->fetchAll();

                                        echo "<table class='table table-striped'>
                                                <thead class='thead-dark'>
                                                    <tr>
                                                        <th scope='col'>Date</th>
                                                        <th scope='col'>Expéditeur</th>
                                                        <th scope='col'>Sujet</th>
                                                        <th colspan=3 scope='col'>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>";

                                        foreach($datas as $row) {
                                            echo '<tr><td>' . $row['recieveDate'] . '</td><td>' . $row['sender'] . '</td><td>' . $row['subject'] . '</td><td>';
                                            echo "<a class='text-danger' href='./detailmessage.php?id=" . $row['id'] . "'>Lire</a></td><td>";
                                            echo "<a class='text-danger' href='./deletemessage.php?id=" . $row['id'] . "'>Supprimer</a></td><td>";
                                            echo "<a class='text-danger' href='./newmessage.php?id=" . $row['id'] . "'>Répondre</a></td></tr>";
                                        }
                                        echo  '</tbody></table>';
                                    }
                                ?>
                                <a class="btn btn-danger" href="./newmessage.php">Nouveau Message</a>
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