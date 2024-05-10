<?php
$_SERVERNAME="localhost:3307";
$_USER="root";
$_PASSWORD="";
$_DB="sample";

$connection = new mysqli($_SERVERNAME, $_USER, $_PASSWORD, $_DB);

$id="";
$firstname="";
$middleInitial="";
$lastname="";
$emailAddress="";
$phone="";

$errorMessage="";
$successMessage="";

if($_SERVER['REQUEST_METHOD'] == 'GET')
{
    if(!isset($_GET['id']))
    {
       header("location:/sample/index.php");
       exit;
    }

    $id=$_GET["id"];

    $sql = "SELECT * from users where id =$id";
    $result = $connection->query($sql);
    $row=$result->fetch_assoc();

    if(!$row)
    {
        header("location:/sample/index.php");
        exit;
    }

    $firstname=$row["firstname"];
    $middleInitial=$row["middleInitial"];
    $lastname=$row["lastname"];
    $emailAddress=$row["email"];
    $phone=$row["phone"];

}
else
{
    $id=$_POST["id"];
    $firstname=$_POST["firstname"];
    $middleInitial=$_POST["MiddleInitial"];
    $lastname=$_POST["Lastname"];
    $emailAddress=$_POST["email"];
    $phone=$_POST["phone"];

    do
    {
        if(empty($firstname) || empty($middleInitial) || empty($lastname) || empty($emailAddress) || empty($phone))
        {
            $errorMessage="All fields are required";
            break;
        }

        try
        {
           $sql = "UPDATE users ".
               "SET firstname = '$firstname', middleInitial = '$middleInitial', lastname = '$lastname', email = '$emailAddress', phone = '$phone'".
               " WHERE id = $id";

        }
       catch(mysqli_sql_exception $ex)
       {
        var_dump($ex);
        exit;
       }

       
       $result = $connection->query($sql);

        if(!$result)
        {
            $errorMessage="Invalid query". $connection->error;
            break;
        }

        $successMessage = "Updated Successfully";

        header("location: /sample/index.php");
    }
    while(false);

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sample - Create Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container my-5">
        <h1>New User</h1>
        <?php
           if(!empty($errorMessage))
           {
            echo "
             <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>$errorMessage</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
             </div>
            ";
           }
        ?>
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo $id;?>">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Firstname</label>
                <div class="col-sm-6">
                    <input class="form-control" type="text" name="firstname" placeholder="Firstname" value="<?php echo $firstname;?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Middle Initial</label>
                <div class="col-sm-6">
                    <input class="form-control" type="text" placeholder="Middle Initial" name="MiddleInitial" value="<?php echo $middleInitial?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Lastname</label>
                <div class="col-sm-6">
                     <input type="text" class="form-control" placeholder="Lastname" name="Lastname" value="<?php echo $lastname?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Email Address</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" placeholder="Email Address" name="email" value="<?php echo $emailAddress?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3">Phone</label>
                <div class="col-sm-6">
                    <input class="form-control" type="text" name="phone" placeholder="Phone" value="<?php echo $phone?>">
                </div>
            </div>

            <?php
               if(!empty($successMessage))
               {
                echo "
                <div class='row mb-3'>
                  <div class='offset-sm-3 col-sm-6'>
                    <div class='alert alert-success alert-dismissible fade show' role='alert'>
                       <strong>$successMessage</strong>
                       <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>
                  </div>
                </div>
                ";
               }
            ?>
            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button class="btn btn-primary" type="Submit">Submit</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" role="button" href="/Sample/index.php">Cancel</a>
                </div>
            </div>
        </form>
    </div>
    
</body>
</html>