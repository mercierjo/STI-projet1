<?php
	/**
	 * Defini les fonctions necessaire pour l'affichage des menus
	 * @author Mercier Jordan, Vogel Maximilian
	 */

	 /**
	  * Connection a la base de donnee
	  */
	  function connect() {
		return new PDO("sqlite:/usr/share/nginx/databases/database.sqlite");
	  }

	/**
	 * Ajoute les actions administrateurs
	 */
	function displayConsult(){
		if(isset($_SESSION['username'])) {
			if($_SESSION['role'] == 2)
				echo "<li class='nav-time'><a class='text-danger nav-link' href='listuser.php'>Gestion Utilisateur</a></li>";
		}
	}

	/**
	 * Affiche le menu lateral
	 */
	function displayNavigation() {
		echo '<nav>
			<ul class="nav flex-column">
				<li class="nav-item">
					<a class="text-danger nav-link" href="./listmessage.php">Gestion Message</a>
				</li>';
				displayConsult();
		echo	'<li class="nav-item">
					<a class="text-danger nav-link" href="./changepassword.php">Changer mot de passe</a>
				</li>
			</ul>
		</nav>';
	}


?>
