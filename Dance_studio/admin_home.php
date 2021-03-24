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
  $name = "";
  $description = "";
  $status = "";
  $id = 0;
  $update = false;

  if (isset($_POST['save'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $status = $_POST['status'];
    mysqli_query($db, "INSERT INTO competitions (name, description, status) VALUES ('$name', '$description', '$status')"); 
    $_SESSION['message'] = "Competition saved"; 
    header('location: admin_home.php');
  }
?>


<?php 
  if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $update = true;
    $record = mysqli_query($db, "SELECT * FROM competitions WHERE id=$id");

    if (count($record) == 1 ) {
      $n = mysqli_fetch_array($record);
      $name = $n['name'];
      $description = $n['description'];
      $status = $n['status'];
      
    }
    else{
      echo "couldn't find";
    }
  }
?>


<?php
  if (isset($_POST['update'])) {
  $id = $_POST['id'];
  $name = $_POST['name'];
  $description = $_POST['description'];
  $status = $_POST['status'];

  mysqli_query($db, "UPDATE competitions SET name='$name', description='$description', status='$status' WHERE id=$id");
  $_SESSION['message'] = "Competition updated!"; 
  header('location: admin_home.php');
}
?>


<?php
  if (isset($_GET['del'])) {
  $id = $_GET['del'];
  mysqli_query($db, "DELETE FROM competitions WHERE id=$id");
  $_SESSION['message'] = "Address deleted!"; 
  header('location: admin_home.php');
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





  <form method="post" action="" >
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <div class="input-group">
      <label>Name</label>
      <input type="text" name="name" value="<?php echo $name; ?>">
    </div>
    <div class="input-group">
      <label>Description</label>
      <input type="text" name="description" value="<?php echo $description; ?>">
    </div>
    <div class="input-group">
      <label>Status</label>
      <input type="text" name="status" value="<?php echo $status; ?>">
    </div>
    <div class="input-group">
      <?php if ($update == true): ?>
        <button class="btn" type="submit" name="update" style="background: #556B2F;" >update</button>
      <?php else: ?>
        <button class="btn" type="submit" name="save" >Save</button>
      <?php endif ?>
    </div>
  </form>







<?php $results = mysqli_query($db, "SELECT * FROM competitions"); ?>






<table>
  <thead>
    <tr>
      <th>Name</th>
      <th>Description</th>
      <th>Status</th>
      <th colspan="">Action</th>
      <th colspan="">Action</th>
    </tr>
  </thead>
  
  <?php while ($row = mysqli_fetch_array($results)) { ?>
    <tr>
      <td><?php echo $row['name']; ?></td>
      <td><?php echo $row['description']; ?></td>
      <td><?php echo $row['status']; ?></td>
      <td>
        <a href="admin_home.php?edit=<?php echo $row['id']; ?>" class="edit_btn" >Edit</a>
      </td>
      <td>
        <a href="admin_home.php?del=<?php echo $row['id']; ?>" class="del_btn">Delete</a>
      </td>
    </tr>
  <?php } ?>
</table>


</body>



  </center>