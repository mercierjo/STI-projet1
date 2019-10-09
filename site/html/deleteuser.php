<?php
    /**
     * Script qui supprime un utilisateur
     * @author Mercier Jordan, Vogel Maximilian
     */

    require_once('./utils.php');
    session_start();

    if(!isset($_SESSION['username']) && $_SESSION['role'] != 2){
      header('Location: ./index.php');
      exit();	
    }

    if(isset($_GET['username'])) {
        $file_db = connect();
        $sql = "UPDATE account SET deleted = 1 WHERE username = :username";
        $request = $file_db->prepare($sql);
        $request->bindParam(':username', $_GET['username'], PDO::PARAM_STR);
        $request->execute();
    }

    header('Location: ./listuser.php');
?>