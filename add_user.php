<?php
  include 'connection.php';

  function secure($value)
  {
    $value = htmlentities($value, ENT_QUOTES);
    return $value;
  }


  $error = array(
    'username'        => '',
    'account_number'  => '',
    'password'        => '',
    'money' => 0,
  );

  if(isset($_GET['submit']))
  {
    // Handel Error
    if(empty($_GET['username']))
      $error['username'] = "<span style='color:red'>Username Required</span>";
    else
      $username = secure($_GET['username']);

    if(empty($_GET['account_number']))
      $error['account_number'] = "<span style='color:red'>Account Number Required</span>";
    else
      $account_number = secure($_GET['account_number']);

    if(empty($_GET['password']))
      $error['password'] = "<span style='color:red'>Password Required</span>";
    else
      $password = secure($_GET['password']);

    if(empty($_GET['money']))
      $money  = $error['money'];
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
<body class="add_user">

<form>
  <table>
    <tr>
      <td>Name</td>
      <td><input type="text" name="username" placeholder="Mohamed , Ahmed , Omar ..."> </td>
      <td> <?php echo $error['username']; ?> </td>
    </tr>

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
      <td> <?php echo "<span style='color:blue'>The Default Money is ".$error['money']."</span>"; ?> </td>
    </tr>
    <tr>
      <td></td>
      <td> <input type="submit" name="submit" value="Regestire"> </td>
      <td></td>
    </tr>
  </table>
</form>

</body>
</html>

<?php

  if(!empty($username) && !empty($password) && !empty($account_number) && !empty($money))
  {
    $sql = "INSERT INTO client VALUES(?,?,?,?,0)";
    $stmt = $conn -> prepare($sql);
    $stmt -> execute(array($account_number,$username,$password,$money)) or die("<span style='color:red'>[-] Account Number is Exist</span>");
    echo "<script>alert`User Successfully Inserted`</script>";
  }

?>