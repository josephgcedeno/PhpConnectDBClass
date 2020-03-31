# Php class to interact with MySql Database.

To use:
* download connectdb.php
* Require / Include / Use file eg. require_once('connectdb.php');  
* Instantiate the class pass the default parameters eg. 
	$<anyname> = new 	connectdb('localhost','root', '', '<database>');
* Call method / function eg. $<anyname>->InsertData('<dbtable>', array( "user" => "john" ));
* See the index.php to have a guide how to use it.
* Thats it.
