<?php
	session_start();
	require_once ('connectdb.php');
	$db=new connectdb('localhost','root','','clinic');
	
	//ADDING ACCOUNT			
	if (isset($_POST['register'])) 
	{
		$results = $db->IsExist( 'users' , 
			[
				"user_username" => $_POST['user']
			] );

		if (!isset($results)) 
		{	
			$check=$db->InsertData('users',
			[
				'user_username'=>$_POST['user'],
				'user_password'=>$_POST['pass']
			]);
			echo "successfully inserted";
		} 
		else
		{
			echo "already exists!";
		}
	}

	//CHECKING ACCOUNT IF EXIST
	else if(isset($_POST['signin']))
	{
		$result = $db->IsExist( 'users' , 
			[
				"user_username" => $_POST['username'] , 
				"user_password" => $_POST['password']
			], null , 'user_username' );
		if (isset($result)) 
		{
			echo "Hello ".$result['user_username'];
		}
		else
		{
			echo "User not found!";
		}
	}
	//DELETING THE ACCOUNT
	else if (isset($_GET['delete']) && isset($_GET['id'])) 
	{
		
		$check = $db->DeleteData('users',$_GET['id'],'user_id');
		echo "deleted";

	}
	//UPDATING ACCOUNT DETAILS THRU FORM
	else if (isset($_GET['id']) && !isset($_POST['upbtn'])) 
	{

		$id=$_GET['id'];
		$result=$db->SelectAllColumn('users',$id ,'user_id');

		echo '
		<form method="post">
		ID = '.$result['user_id'].'<br>
		USER = <input type="text" value="'.$result['user_username'].'" name="upusername"><br>
		PASSWORD = <input type="text" value="'.$result['user_password'].'" name="uppass"><br>
		<input type="hidden" value="'.$result['user_id'].'" name="upid">
		<input type="submit" name="upbtn">
		</form>';

	}
	//SENDING UPDATE ACCOUNT DETAILS TO DB
	else if (isset($_POST['upbtn'])) 
	{
		$result=$db->UpdateData('users',
		[
			'user_username'=>$_POST['upusername'],
			'user_password'=>$_POST['uppass']
		],$_POST['upid'], 'user_id');
		echo "updated";
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>class db</title>
</head>
<body>
<h1>hello world</h1>

<form method="POST">
	<h1>Register</h1>
	<input type="text" name="user" placeholder="enter username...">
	<input type="text" name="pass" placeholder="enter password...">
	<input type="submit" name="register" value="register">
	<br>
	<h1>Sign in</h1>
	<input type="text" name="username" placeholder="enter username...">
	<input type="text" name="password" placeholder="enter password...">
	<input type="submit" name="signin" value="login">
	<br>


	<table border="1px" width="100%" >
		<thead>
			<tr>
				<th>id</th>
				<th>user</th>
				<th>pass</th>
				<th>edit</th>
				<th>delete</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$result=$db->SelectAllRow("SELECT * FROM users");

				foreach ($result as $row ) 
				{
					echo '
					<tr>
						<td>'.$row['user_id'].'</td>
						<td>'.$row['user_username'].'</td>
						<td>'.$row['user_password'].'</td>
						<td><a href="?id='.$row['user_id'].'">edit</a></td>
						<td><a href="?delete=clicked&id='.$row['user_id'].'">delete</a></td>
					</tr>';
				}
						
			 ?>
			
	
		</tbody>
	</table>

</form>

</body>
</html>
<!-- 
-->