<?php include 'head.php';?>

<center>
<link rel="stylesheet" type="text/css" href="style.css">

<h1>Admin page</h1>
<h3>
<?php
session_start();

  if(!isset($_SESSION['admin_login'])) //check unauthorize user not direct access in "admin_home.php" page
  {
   header("location: ../index.php");  
  }


  if(isset($_SESSION['user_login'])) //check user login user not access in "admin_home.php" page
  {
   header("location: ../user_home.php");
  }
  
  if(isset($_SESSION['admin_login']))
  {
  ?>
   Welcome,
  <?php
   echo $_SESSION['admin_login'];
  }
?>

</h3>
<a href="logout.php">Logout</a>







<?php
session_start();
  $db = mysqli_connect('localhost', 'root', 'root', 'dance_project');

  // initialize variables
  $username = "";
  $email = "";
  $password = "";
  $id = 0;
  $update = false;

  if (isset($_POST['save'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    mysqli_query($db, "INSERT INTO superuser (username, email, password, role) VALUES ('$username', '$email', '$password', 'user')"); 
    $_SESSION['message'] = "User saved"; 
    header('location: users.php');
  }
?>


<?php 
  if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $update = true;
    $record = mysqli_query($db, "SELECT * FROM superuser WHERE id=$id");

    if (count($record) == 1 ) {
      $n = mysqli_fetch_array($record);
      $username = $n['username'];
      $email = $n['email'];
      $password = $n['password'];
      
    }
    else{
      echo "couldn't find";
    }
  }
?>


<?php
  if (isset($_POST['update'])) {
  $id = $_POST['id'];
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  mysqli_query($db, "UPDATE superuser SET username='$username', email='$email', password='$password' WHERE id=$id");
  $_SESSION['message'] = "User updated!"; 
  header('location: users.php');
}
?>


<?php
  if (isset($_GET['del'])) {
  $id = $_GET['del'];
  mysqli_query($db, "DELETE FROM superuser WHERE id=$id");
  $_SESSION['message'] = "User deleted!"; 
  header('location: users.php');
}
?>



<?php
  
function binarySearch(Array $arr, $x)
{
    if (count($arr) === 0) return false;
    $low = 0;
    $high = count($arr) - 1;
      
    while ($low <= $high) {
        $mid = floor(($low + $high) / 2);
           if($arr[$mid] == $x) {
            return true;
        }
  
        if ($x < $arr[$mid]) {
            $high = $mid -1;
        }
        else {
            $low = $mid + 1;
        }
    }
    return false;
}

 $record = mysqli_query($db, "SELECT * FROM superuser");

    if (count($record) == 1 ) {
      $n = mysqli_fetch_array($record);
      $username = $n['username'];
      $email = $n['email'];
      $password = $n['password'];
      
    }
    else{
      echo "couldn't find";
    }
// $value = "admin";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // collect value of input field
    $value = $_POST['fname'];
    if (empty($value)) {
        echo "Name is empty";
    } else {
        // echo $value;
    }
}

if(binarySearch($n, $value) == true) {
    echo $value." Exists";
}
else {
    echo $value." Doesnt Exist";
}
?>



<body>

<?php if (isset($_SESSION['message'])): ?>
  <div class="msg">
    <?php 
      echo $_SESSION['message']; 
      unset($_SESSION['message']);
    ?>
  </div>
<?php endif ?>


<form method="post" action="">
  Name: <input type="text" name="fname">
  <input type="submit">
</form>



  <form method="post" action="" >
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <div class="input-group">
      <label>Username</label>
      <input type="text" name="username" value="<?php echo $username; ?>">
    </div>
    <div class="input-group">
      <label>Email</label>
      <input type="email" name="email" value="<?php echo $email; ?>">
    </div>
    <div class="input-group">
      <label>Password</label>
      <input type="password" name="password" value="<?php echo $password; ?>">
    </div>
    <div class="input-group">
      <?php if ($update == true): ?>
        <button class="btn" type="submit" name="update" style="background: #556B2F;" >update</button>
      <?php else: ?>
        <button class="btn" type="submit" name="save" >Save</button>
      <?php endif ?>
    </div>
  </form>




<?php $results = mysqli_query($db, "SELECT * FROM superuser"); ?>

<table>
  <thead>
    <tr>
      <th>Username</th>
      <th>Email</th>
      <th>Password</th>
      <th colspan="">Action</th>
      <th colspan="">Action</th>
    </tr>
  </thead>
  
  <?php while ($row = mysqli_fetch_array($results)) { ?>
    <tr>
      <td><?php echo $row['username']; ?></td>
      <td><?php echo $row['email']; ?></td>
      <td><?php echo $row['password']; ?></td>
      <td>
        <a href="users.php?edit=<?php echo $row['id']; ?>" class="edit_btn" >Edit</a>
      </td>
      <td>
        <a href="users.php?del=<?php echo $row['id']; ?>" class="del_btn">Delete</a>
      </td>
    </tr>
  <?php } ?>
</table>


</body>



  </center>