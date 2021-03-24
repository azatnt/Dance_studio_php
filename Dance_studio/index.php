<?php
require_once 'connection.php';

session_start();

if(isset($_SESSION["admin_login"])) //check condition admin login not direct back to index.php page
{
 header("location: admin_home.php"); 
}

if(isset($_SESSION["user_login"])) //check condition user login not direct back to index.php page
{
 header("location: user_home.php");
}

if(isset($_REQUEST['btn_login'])) //login button name is "btn_login" and set this
{
 $email  =$_REQUEST["txt_email"]; //textbox name "txt_email"
 $username  =$_REQUEST["txt_username"];
 $password =$_REQUEST["txt_password"]; //textbox name "txt_password"
 $role  =$_REQUEST["txt_role"];  //select option name "txt_role"
  
 if(empty($email)){      
  $errorMsg[]="please enter email"; //check email textbox not empty or null
 }
 else if(empty($username)){
  $errorMsg[]="please enter username"; //check passowrd textbox not empty or null
 }
 else if(empty($password)){
  $errorMsg[]="please enter password"; //check passowrd textbox not empty or null
 }
 else if(empty($role)){
  $errorMsg[]="please select role"; //check select option not empty or null
 }
 else if($email AND $password AND $role)
 {
  try
  {
   $select_stmt=$db->prepare("SELECT email,password,role FROM superuser
          WHERE
          email=:uemail AND password=:upassword AND role=:urole"); //sql select query
   $select_stmt->bindParam(":uemail",$email);
   $select_stmt->bindParam(":upassword",$password); //bind all parameter
   $select_stmt->bindParam(":urole",$role);
   $select_stmt->execute(); //execute query
     
   while($row=$select_stmt->fetch(PDO::FETCH_ASSOC)) //fetch record from MySQL database
   {
    $dbemail =$row["email"];
    $dbpassword =$row["password"];  //fetchable record store new variable they are "$dbemail","$dbpassword","$dbrole"
    $dbrole  =$row["role"];
   }
   if($email!=null AND $password!=null AND $role!=null) //check taken fields not null after countinue
   {
    if($select_stmt->rowCount()>0) //check row greater than "0" after continue
    {
     if($email==$dbemail AND $password==$dbpassword AND $role==$dbrole) //check type textbox email,password,role and fetchable record new variables are true after continue
     {
      switch($dbrole)  //role base user login start
      {
       case "admin":
        $_SESSION["admin_login"]=$email;   //session name is "admin_login" and store in "$email" variable
        $loginMsg="Admin... Successfully Login..."; //admin login success message
        header("refresh:1;admin_home.php"); //refresh 3 second after redirect to "admin_home.php" page
        break;
        
        
       case "user":
        $_SESSION["user_login"]=$email;    //session name is "user_login" and store in "$email" variable
        $_SESSION["username"]=$username;
        $loginMsg="User... Successfully Login..."; //user login success message
        header("refresh:1;user_home.php");  //refresh 3 second after redirect to "user_home.php" page
        break;
        
       default:
        $errorMsg[]="wrong email or password or role";
      }
     }
     else
     {
      $errorMsg[]="wrong email or password or role";
     }
    }
    else
    {
     $errorMsg[]="wrong email or password or role";
    }
   }
   else
   {
    $errorMsg[]="wrong email or password or role";
   }
  }
  catch(PDOException $e)
  {
   $e->getMessage();
  }  
 }
 else
 {
  $errorMsg[]="wrong email or password or role";
 }
}
?>








<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">


<?php
  if(isset($errorMsg))
  {
    foreach($errorMsg as $error)
    {
      echo $error;
    }
  }
  if(isset($loginMsg))
  {
    echo $loginMsg;
  }
?>

<h1 style="text-align: center;">Login</h1>

<form style="width: 50%; padding-left: 17%; margin: 0 auto; padding-top: 20px" method="post" class="form-horizontal">
  <div class="form-group">
    <label class="col-sm-3 control-label">Username</label>
    <div class="col-sm-6">
      <input type="text" name="txt_username" class="form-control" placeholder="enter username"/>
    </div>
  </div>

	<div class="form-group">
		<label class="col-sm-3 control-label">Email</label>
		<div class="col-sm-6">
			<input type="text" name="txt_email" class="form-control" placeholder="enter email"/>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-3 control-label">Password</label>
		<div class="col-sm-6">
			<input type="password" name="txt_password" class="form-control" placeholder="enter password"/>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-3 control-label">Select type</label>
		<div class="col-sm-6">
			<select class="form-control" name="txt_role">
				<option value="" selected="selected"> - select role - </option>
				<option value="admin">Admin</option>
				<option value="user">User</option>
			</select>
		</div>
	</div>


	<div class="form-group">
		<div class="col-sm-offset-3 col-sm-9 m-t-15">
			<input style="margin-top: 20px;" type="submit" name="btn_login" class="btn btn-success">
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-offset-3 col-sm-9 m-t-15">
			You don't have an account register here? <a href="register.php"><p class="text-info">Register account</p></a>
		</div>
	</div>
</form>