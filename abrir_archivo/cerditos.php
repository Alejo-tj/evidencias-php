<?php include "footer.php";?>
<h1>los tres cerditos</h1>
<?php
echo readfile("CUENTO3.txt");
?>
<br> <br>
<?php
echo "<p>Copyright &copy; 2024-" . date("Y/m/d") . " Alejandro Tintinago Jimenez</p>";
?>