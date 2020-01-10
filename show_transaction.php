<?php
include 'connection.php';

function secure($value)
{
  $value = htmlentities($value, ENT_QUOTES);
  return $value;
}

$error = array(
  'account_number'  => '',
  'password'        => '',
);

if(isset($_GET['submit']))
{
  // Handel Error
  if(empty($_GET['account_number']))
    $error['account_number'] = "<span style='color:red'>Account Number Required</span>";
  else
    $account_number = secure($_GET['account_number']);

  if(empty($_GET['password']))
    $error['password'] = "<span style='color:red'>Password Required</span>";
  else
    $password = secure($_GET['password']);

}

?>

 <!DOCTYPE html>
 <html>
 <head>
   <title></title>
   <link rel="stylesheet" href="style.css">
 </head>
 <body class="show_transaction">
 <form>
  <table>
    <tr>
      <td>Account Number</td>
      <td><input type="number" name="account_number" placeholder="23948712938 ..."> </td>
      <td> <?php echo $error['account_number']; ?> </td>
    </tr>

    <tr>
      <td>Password</td>
      <td><input type="password" name="password" placeholder="Enter Password"> </td>
      <td> <?php echo $error['password']; ?> </td>
    </tr>

    <tr>
      <td> <input type="submit" name="submit" value="Show Transactions"> </td>
    </tr>
  </table>
</form>
 </body>
 </html>

 <?php

 if(!empty($password) && !empty($account_number))
 {
   $counting = 0;
   $sql0 = "SELECT COUNT(*),password_try FROM client WHERE account_number = ?";
   $stmt0 = $conn -> prepare($sql0);
   $stmt0 -> execute(array($account_number));
   $row0 = $stmt0 -> fetch();
   $count0 = (int)$row0[0];
   $pass_try = (int)$row0[1];
   if($count0 > 0)
   {
       $sql1 = "SELECT COUNT(*) FROM client WHERE account_number = ? AND password = ?";
       $stmt1 = $conn -> prepare($sql1);
       $stmt1 -> execute(array($account_number,$password));
       $row1 = $stmt1 -> fetch();
       $count1 = (int)$row1[0];
       if($count1 > 0)
       {
         if($pass_try <= 3)
         {

           $sql2 = "SELECT Transactions FROM client c ,transaction t WHERE c.account_number = t.client_account_number AND c.account_number = ? ORDER BY Number_transactions DESC";
           $stmt2 = $conn -> prepare($sql2);
           $stmt2 -> execute(array($account_number)) or die("[-] Error");
           echo "<table class='show_transaction_tb1'>
           <tr><td>
           <caption>Transactions</caption></td></tr>
           <tr>";
           while($row = $stmt2 -> fetch())
           {
             if($counting < 5)
             {
               $counting++;
               if($row[0] > 0)
                 echo "<tr><td>You Add  $row[0]</td></tr>";
               else
                 echo "<tr><td>You Withdraws  ".($row[0]*-1)."</td></tr>";
             }
           }
           echo "</table>";
         }
         else {
           echo "<span style='color:red;text-align:center'>[-] Please Contact Our Service</span> ";
         }
       }

       elseif ($pass_try > 3)
       {
         echo "<span style='color:red;text-align:center'>[-] Please Contact Our Service</span> ";
       }

     else
     {
       echo "<span style='color:red;text-align:center'>[-] Password Error</span> ";
       $sql2 = "UPDATE client SET password_try = password_try + 1 WHERE account_number = ?";
       $stmt2 = $conn -> prepare($sql2);
       $stmt2 -> execute(array($account_number));
     }

   }


   else
   {
     echo "<span style='color:red;text-align:center'>[-] Card Number is Wrong</span>";
   }


 }

 ?>
