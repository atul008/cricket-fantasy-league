This website is a simulation following weblink under "Manage team" section.

"http://games.espncricinfo.com/Fantasy/ManageTeam"

This website assumes that a user is logged in and tables are created in the database.

It can be run by on localhost by typing following url in the browser (after changes to the constants.php file).

	"http://localhost/Fantasy/index.php?email=myemail@gmail.com"

where  "myemail@gmail.com" is the email of user logged in.




This folder contains following files and folders :-

Folders:
	 includes: It contains classes folder and files (connection.php,constants.php)
	 		   Folders :
	 		   		 classes: It contains following files:
	 		   			a) player.php- It is a class for Player object.
	 		   			b) team_owner.php- It is  a class for TeamOwner object(or user).
	 		   			c) team_composition.php- It is class for TeamCompostion object.
	 		   	files:
	 		   		a) connection.php - Thhis is a php script for connection to a database.
	 		   		b) constants.php - This contains useful required constants for connection to a database.

	 javascript: This contains the javascript scripts.
	 styles: This contains css style sheets.

Files:
	index.php - This is the main page of website.
	It contain other helper files.

