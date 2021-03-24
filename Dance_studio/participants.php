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
  $competition_id = 0;
  $email = "";
  $username = "";
  $id = 0;
  $mark = 0;
  $update = false;

  if (isset($_POST['save'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    mysqli_query($db, "INSERT INTO superuser (username, email, password, role) VALUES ('$username', '$email', '$password', 'user')"); 
    $_SESSION['message'] = "User saved"; 
    header('location: participants.php');
  }
?>


<?php 
  if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $update = true;
    $record = mysqli_query($db, "SELECT * FROM participants WHERE competition_id=$id");

    if (count($record) == 1 ) {
      $n = mysqli_fetch_array($record);
      $username = $n['username'];
      $email = $n['email'];
      $mark = $n['mark'];
      
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
  $mark = $_POST['mark'];

  mysqli_query($db, "UPDATE participants SET username='$username', email='$email', mark='$mark' WHERE competition_id=$id");
  $_SESSION['message'] = "Participant updated!"; 
  header('location: participants.php');
}
?>


<?php
  if (isset($_GET['del'])) {
  $id = $_GET['del'];
  mysqli_query($db, "DELETE FROM participants WHERE competition_id=$id");
  $_SESSION['message'] = "User deleted!"; 
  header('location: participants.php');
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
      <label>Username</label>
      <input type="text" name="username" value="<?php echo $username; ?>">
    </div>
    <div class="input-group">
      <label>Email</label>
      <input type="email" name="email" value="<?php echo $email; ?>">
    </div>
    <div class="input-group">
      <label>Mark</label>
      <input type="number" name="mark" value="<?php echo $mark; ?>">
    </div>
    <div class="input-group">
      <?php if ($update == true): ?>
        <button class="btn" type="submit" name="update" style="background: #556B2F;" >update</button>
      <?php else: ?>
        <button class="btn" type="submit" name="save" >Save</button>
      <?php endif ?>
    </div>
  </form>




<?php $results = mysqli_query($db, "SELECT A.username, A.email, A.mark, A.competition_id FROM participants A Join competitions B on B.id = A.competition_id ORDER BY mark DESC"); 
?>


<?php

session_start();
  $db = mysqli_connect('localhost', 'root', 'root', 'dance_project');

$arr = mysqli_query($db, "SELECT * FROM participants");
// echo $results;

// $arr = [33, 24, 8, 21, 2, 23, 3, 32, 16];




// $arr = array( 6,1,3,7,5,2,3,4,45,5,4,75,8,6,78,7980890,2,4,2,432,5,34,5634,34,5); 
echo "<br>".implode(',',$arr)."<br>";
$arr=mergesort($arr);
echo implode(',',$arr);
 
function mergesort($numlist)
{
    if(count($numlist) == 1 ) return $numlist;
 
    $mid = count($numlist) / 2;
    $left = array_slice($numlist, 0, $mid);
    $right = array_slice($numlist, $mid);
 
    $left = mergesort($left);
    $right = mergesort($right);
     
    return merge($left, $right);
}
 
function merge($left, $right)
{
    $result=array();
    $leftIndex=0;
    $rightIndex=0;
 
    while($leftIndex<count($left) && $rightIndex<count($right))
    {
        if($left[$leftIndex]>$right[$rightIndex])
        {
 
            $result[]=$right[$rightIndex];
            $rightIndex++;
        }
        else
        {
            $result[]=$left[$leftIndex];
            $leftIndex++;
        }
    }
    while($leftIndex<count($left))
    {
        $result[]=$left[$leftIndex];
        $leftIndex++;
    }
    while($rightIndex<count($right))
    {
        $result[]=$right[$rightIndex];
        $rightIndex++;
    }
    return $result;
}
?>





<table>
  <thead>
    <tr>
      <th>Competition</th>
      <th>Username</th>
      <th>Email</th>
      <th>Mark</th>
      <th colspan="">Action</th>
    </tr>
  </thead>
  
  <?php while ($row = mysqli_fetch_array($results)) { ?>
    <tr>
      <td><?php echo $row['competition_id']; ?></td>
      <td><?php echo $row['username']; ?></td>
      <td><?php echo $row['email']; ?></td>
      <td><?php echo $row['mark']; ?></td>
      <td>
        <a href="participants.php?edit=<?php echo $row['competition_id']; ?>" class="edit_btn" >Add mark</a>
      </td>
       <td>
        <a href="participants.php?del=<?php echo $row['competition_id']; ?>" class="del_btn">Delete</a>
      </td>
<td>
      

    </tr>
  <?php } ?>
</table>


</body>



  </center>