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



 <table>
  <thead>
    <tr>
      <th>Competition</th>
      <th>Username</th>
      <th>Email</th>
      <th>Mark</th>
    </tr>
  </thead>
  

  <?php
   

  ?>

    <?php while ($row = mysqli_fetch_array($result)) { ?>
    <tr>
      <td><?php echo $row['competition_id']; ?></td>
      <td><?php echo $row['username']; ?></td>
      <td><?php echo $row['email']; ?></td>
      <td><?php echo $row['mark']; ?></td>
    </tr>
  <?php } ?>
</table>