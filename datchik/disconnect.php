<?php
	error_reporting( E_ERROR );
	OCICommit($connect); 
	OCILogoff($connect);
?> 