<?php
include 'connection.php';

function secure($value)
{
  $value = htmlentities($value, ENT_QUOTES);
  return $value;
}

$error = array(
  'account_number'  => '',
);

if(isset($_GET['submit']))
{
  // Handel Error
  if(empty($_GET['account_number']))
    $error['account_number'] = "<span style='color:red'>Account Number Required</span>";
  else
    $account_number = secure($_GET['account_number']);
}

?>

<!DOCTYPE html>
 <html>
 <head>
   <title></title>
   <link rel="stylesheet" href="style.css">
 </head>
 <body class="search">

 <form>
  <table>
    <tr>
      <td>Account Number</td>
      <td><input type="number" name="account_number" placeholder="23948712938 ..."> </td>
      <td> <?php echo $error['account_number']; ?> </td>
    </tr>

    <tr>
      <td></td>
      <td> <input type="submit" name="submit" value="Show Data"> </td>
      <td></td>
    </tr>
  </table>
</form>

 </body>
 </html>

<?php

if(!empty($account_number))
{
    $sql = "SELECT * FROM client WHERE account_number = ?";
    $stmt = $conn -> prepare($sql);
    $stmt -> execute(array($account_number)) or die("[-] Error");
    echo "
        <table class='search_tb1'>
        <caption>Account Information</caption>
        <tr>
        <td>Account Number</td>
        <td>Name</td>
        <td>Password</td>
        <td>Amount of Money</td>
        <td>Password Try</td>
        </tr>
    ";

    while ($row = $stmt -> fetch())
    {
    echo
    "  <tr>
        <td>$row[0]</td>
        <td>$row[1]</td>
        <td>$row[2]</td>
        <td>$row[3]</td>
        <td>$row[4]</td>
      </tr>
    ";
    }
    echo "</table><br><br>";

    $sql2 = "SELECT * FROM transaction WHERE client_account_number = ?";
    $stmt2 = $conn -> prepare($sql2);
    $stmt2 -> execute(array($account_number)) or die("[-] Error");
    echo "
        <table class='search_tb2'>
        <caption>All Transactions Information</caption>
        <tr>
        <td>Transactions</td>
        <td>Number of Transactions</td>
        </tr>
    ";

    while ($row2 = $stmt2 -> fetch())
    {
    echo
    "  <tr>
        <td>$row2[0]</td>
        <td>$row2[1]</td>
      </tr>
    ";
    }
    echo "</table>";

}

?>