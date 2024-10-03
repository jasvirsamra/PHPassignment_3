<?php
require('../model/database.php');
$queryProducts = 'SELECT * FROM technicians';
$statement = $db-> prepare($queryProducts);
$statement-> execute();
$technicians = $statement->fetchAll();
$statement-> closeCursor();

?>

<!DOCTYPE html>
<html>

<head>
    <title>SportsPro Technical Support</title>
    <link rel="stylesheet" type="text/css"
          href="../main.css">
</head>

<body>
<header>
    <h1>SportsPro Technical Support</h1>
    <p>Sports management software for the sports enthusiast</p>
    <nav>
        <ul>
            <li><a href="../index.php">Home</a></li>
        </ul>
    </nav>
</header>
    <main>
    <table>
      <tr>
        <th>First name</th>
        <th>Last name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Password</th>
        <th>&nbsp</th> 
      </tr>
        <?php foreach($technicians as $technician):?> 
         <tr>
          <td><?php echo $technician['firstName'];?></td>
          <td><?php echo $technician['lastName'];?></td>
          <td><?php echo $technician['email'];?></td>
          <td><?php echo $technician['phone'];?></td>
          <td><?php echo $technician['password'];?></td>
          <td>
            <form action = "delete_tech.php" method = "post">
            <input type="hidden" name = "techID" value = "<?php echo $technician['techID'];?>"/>  
            <input type="submit" value = "Delete"/>
            </form>
          </td> 
         </tr>
        <?php endforeach; ?> 
    </table>
    <p class = "option"><a href="add_technician_form.php">Add a technician</a></p>
</main>
    
<?php include '../view/footer.php'; ?>