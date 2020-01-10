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
  'money'           => '',
);

if(isset($_GET['submit0']) || isset($_GET['submit1']) )
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

  if(empty($_GET['money']))
    $error['money'] = "<span style='color:red'>Money Required</span>";
  else
    $money = secure($_GET['money']);
}

?>

 <!DOCTYPE html>
 <html>
 <head>
   <title></title>
   <link rel="stylesheet" href="style.css">
 </head>
 <body class="checkout">
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
      <td>Money</td>
      <td><input type="number" name="money" placeholder="3000 , 5000 ..." step="0.1"> </td>
      <td> <?php echo $error['money']; ?> </td>
    </tr>
    <tr>
      <td> <input type="submit" name="submit0" value="Add Money"> </td>
      <td> <input type="submit" name="submit1" value="Withdraws Money"> </td>
    </tr>
  </table>
</form>
 </body>
 </html>

 <?php
if(!empty($password) && !empty($account_number) && !empty($money))
{
  $sql = "SELECT COUNT(*),password,password_try,amount_of_money FROM client WHERE account_number = ?";
  $stmt = $conn -> prepare($sql);
  $stmt -> execute(array($account_number)) or die("[-] Error");
  $row = $stmt -> fetch();

  $count = (int)$row[0];
  $pass = $row[1];
  $pass_try = (int)$row[2];
  $amount_of_money = (double)$row[3];

  if($count > 0 && $pass_try <= 3)
  {
    if($pass == $password)
    {
        if(isset($_GET['submit0']))
          {
              $sql2 = "UPDATE client SET amount_of_money = amount_of_money + ? WHERE account_number = ?";
              $stmt2 = $conn -> prepare($sql2);
              $stmt2 -> execute(array($money,$account_number));
              echo "<script>alert(`[+] Money Add Successfully`)</script>";

              // Insert The Transactions
              $sql4 = "SELECT COUNT(*) FROM transaction WHERE client_account_number = ?";
              $stmt4 = $conn -> prepare($sql4);
              $stmt4 -> execute(array($account_number));
              $rows = $stmt4 -> fetch();
              $counts = $rows[0];

              $transaction_stmt = +($money);
              $sql3 = "INSERT INTO transaction VALUES(?,?,?)";
              $stmt3 = $conn -> prepare($sql3);
              $stmt3 -> execute(array($transaction_stmt,$counts,$account_number));
          }
        else if(isset($_GET['submit1']))
          {
              if($money > $amount_of_money )
                  echo "<script>alert(`Sorry You Can't Withdraws $money , Your Avaliable Money is $amount_of_money`)</script>";
              else
                {
                  $sql2 = "UPDATE client SET amount_of_money = amount_of_money - ? WHERE account_number = ?";
                  $stmt2 = $conn -> prepare($sql2);
                  $stmt2 -> execute(array($money,$account_number));
                  echo "<script>alert(`[+] Money Withdraws Successfully`)</script>";

                  // Insert The Transactions
                  $sql4 = "SELECT COUNT(*) FROM transaction WHERE client_account_number = ?";
                  $stmt4 = $conn -> prepare($sql4);
                  $stmt4 -> execute(array($account_number));
                  $rows = $stmt4 -> fetch();
                  $counts = $rows[0];

                  $transaction_stmt = $money * -1;
                  $sql3 = "INSERT INTO transaction VALUES(?,?,?)";
                  $stmt3 = $conn -> prepare($sql3);
                  $stmt3 -> execute(array($transaction_stmt,$counts,$account_number));
                }
        }

      }
      else
      {
        $sql2 = "UPDATE client SET password_try = password_try + 1 WHERE account_number = ?";
        $stmt2 = $conn -> prepare($sql2);
        $stmt2 -> execute(array($account_number));
        echo "<script>alert(`[-] Wrong Password`)</script>";
      }


  }
  else
  {
    echo "<script>alert(`[-] Wrong Account Number or You Have Tried Password More Than 3 , Please if you see something wrong contact our service`)</script>";
  }
}

 ?>
