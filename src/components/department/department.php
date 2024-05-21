<?php include_once 'controller.php' ?>

<!DOCTYPE html>
<html lang="en">

<body>
<h1>Add a new department</h1>

<form method="POST" action="controller.php">
    Department Name: <input type="text" name="name">
    <span class="error">* <?php echo $nameErr; ?></span>
    <br><br>
    <input type="submit" name="submit" value="Add department" formaction="">
</form>

</body>
</html>