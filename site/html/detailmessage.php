<?php
    /**
     * Page qui affiche le detail d'un message
     * @author Mercier Jordan, Vogel Maximilian
     */

    require_once('./utils.php');
    session_start();

    if(!isset($_SESSION['username'])){
		header('Location: ./index.php');
		exit();	
    }

    if(!isset($_GET['id'])) {
        header('Location: ./listmessage.php');
        exit();
    }

    $dbh = connect();
    $sql = 'SELECT id, recieveDate, reciever, sender, subject, message FROM message WHERE id = :id';
    $request = $dbh->prepare($sql);
    $request->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $request->execute();

    $result = $request->fetch();

    if(!empty($result)) {
        if($_SESSION['username'] != $result['reciever']) {
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
                <div class="col-2">
                    <?php displayNavigation(); ?>
                </div>
                <div class="col-10">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col">
                            <?php
                                if(empty($result)){
                                    echo '<p>Désolé, message introuvable</p>';
                                    echo '</html>';
                                    exit();
                                }
                                
                                echo '<h4>Date de réception:    ' . $result['recieveDate'] . '</h4>';
                                echo '<h4>Expéditeur:   ' . $result['sender'] . '</h4>';
                                echo '<h4>Sujet:    ' . $result['subject'] . '</h4><br>';
                                echo '<h4>Message:</h4>';
                                echo '<p>' . $result['message'] . '</p>';
                                echo "<a class='text-danger' href='./listmessage.php'>Retour</a><br>";
                                echo "<a class='text-danger' href='./deletemessage.php?id=" , $result['id'] , "'>Supprimer</a><br>";
                                echo "<a class='text-danger' href='./newmessage.php?id=" . $result['id'] . "'>Répondre</a></td></tr>";
                            ?>
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