<?php
    /**
     * Script qui supprime un message
     * @author Mercier Jordan, Vogel Maximilian
     */

    require_once('./utils.php');
    session_start();

    if(!isset($_SESSION['username'])){
      header('Location: ./index.php');
      exit();	
    }

    if(isset($_GET['id'])) {
        $file_db = connect();
        $sql = "DELETE FROM message WHERE id = :id";
        $request = $file_db->prepare($sql);
        $request->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
        $request->execute();
    }

    header('Location: ./listmessage.php');
?>