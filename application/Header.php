<?php
	session_start();
	class Header {

		public function __construct() {
			echo "<header id=\"main-header\">";
			echo "<a href=\"index.php\"><img src=\"assets/images/logo.png\" style =\"width:90%; height:60%;\" /></a>";
			echo "<h1>Security Alerter</h1>";
			echo "</header>";
		}

	}

	new Header();

?>
