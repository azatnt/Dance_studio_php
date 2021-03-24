<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="user_home.php">Home</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-link active" aria-current="page" href="user_course.php">My courses</a>
      </div>
    </div>
  </div>
</nav>

<link rel="stylesheet" type="text/css" href="style.css">


<?php
session_start();
  $db = mysqli_connect('localhost', 'root', 'root', 'dance_project');

  // initialize variables
  $name = "";
  $description = "";
  $status = "";
  $id = 0;
  $update = false;


?>


<center>
<h1>User page</h1>
<h3>
<?php
session_start();

  if(!isset($_SESSION['user_login'])) //check unauthorize user not direct access in "admin_home.php" page
  {
   header("location: ../index.php");  
  }


  if(isset($_SESSION['admin_login'])) //check user login user not access in "admin_home.php" page
  {
   header("location: ../admin_home.php");
  }
  
  if(isset($_SESSION['user_login']))
  {
  ?>
   Welcome,
  <?php
   echo $_SESSION['user_login'];
  }
?>
</h3>
<a href="../logout.php">Logout</a>


<?php 

session_start();
  $db = mysqli_connect('localhost', 'root', 'root', 'dance_project');

  $username = "";
  $email = "";
  $mark = 0;
  $id = 0;
  $update = false;

  if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $email = $_SESSION['user_login'];
    $username = $_SESSION['username'];
    $update = false;
    mysqli_query($db, "INSERT INTO participants (competition_id, username, email, mark) VALUES ('$id', '$username', '$email', '0')");

    $_SESSION['message'] = "Competition saved"; 
    header('location: user_home.php');
  }
?>



<?php $results = mysqli_query($db, "SELECT * FROM competitions"); ?>

<table>
  <thead>
    <tr>
      <th>Name</th>
      <th>Description</th>
      <th>Status</th>
      <th colspan="">Participate</th>
    </tr>
  </thead>
  
  <?php while ($row = mysqli_fetch_array($results)) { ?>
    <tr>
      <td><?php echo $row['name']; ?></td>
      <td><?php echo $row['description']; ?></td>
      <td><?php echo $row['status']; ?></td>
      <td>
        <a href="user_home.php?edit=<?php echo $row['id']; ?>" class="edit_btn" >+</a>
      </td>
    </tr>
  <?php } ?>
</table>



<?php
$db = new mysqli("localhost","root","root","dance_project");
$username = $_SESSION['username'];
$sql = "SELECT *  FROM participants";
$result = mysqli_query($db, $sql);
 // if(mysqli_num_rows($result) > 0){
 //      echo "bar";
 //    }
 //    else{
 //      echo "zhok";
 //    }
 ?>





  </center>