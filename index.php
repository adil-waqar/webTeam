<?php
$errors = [];
$success = [];
require 'connect_DB.php';
if (isset($_POST['submit'])) {
    $name = htmlspecialchars($_POST['name']);
    $contact = htmlspecialchars($_POST['contact']);
    $email = htmlspecialchars($_POST['email']);
    $review = htmlspecialchars(mysqli_real_escape_string($sqlconnect, $_POST['review']), ENT_COMPAT, 'UTF-8');
    $name1 = $_FILES['file']['name'];
    $size = $_FILES['file']['size'];
    $sizeInMbs = $size*0.000001;
    $type = $_FILES['file']['type'];
    $templocation = $_FILES['file']['tmp_name'];

    if (!empty($name && $contact && $email)) {
        // Name validation
        if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
            $nameErr = "Only letters and white space allowed in name.";
            $errors['name'] = $nameErr;
        }
        if (!preg_match('/^[0-9]{11}+$/', $contact)) {
            $errors['contact'] = "11 digit contact number allowed without hyphens.";
        }

        // pdf validation
        $extension = strtolower(substr($name1, strpos($name1, '.') + 1));
        $location = 'Uploads/';
        if (isset($name1)) {
            if (!empty($name1)) {
                if ($extension == "pdf" && $type == "application/pdf" && $sizeInMbs < 2) {
                    move_uploaded_file($templocation, $location.time().$name1);
                } else {
                    $errors['fileUpload'] = 'Please only upload pdf files and less than 2MB. ';
                }
            }
        }

        if (count($errors) == 0) {
            $contact = htmlspecialchars($_POST['contact']);
            $query = "INSERT INTO review (name, contact, email, review ) VALUES ('$name', '$contact',' $email', '$review')";
            if ($query_run = mysqli_query($sqlconnect, $query)) {
                $success['success'] = "Form submitted successfully!";
                $name = '';
                $contact = '';
                $email = '';
                $review = '';
            } else {
                echo "ERROR: Could not able to execute. " . mysqli_error($sqlconnect);
            }

        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Registration App</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/custom.css" rel="stylesheet">
  </head>

  <body>

    <div class="container">

      <div class="errors">
        <?php
          foreach ($errors as $error) :?>
          <div class="alert alert-danger" role="alert">
             <?php echo $error ?>
          </div>
        <?php endforeach ; ?>
      </div>
      <div class="success">
        <?php
          foreach ($success as $succes) :?>
          <div class="alert alert-success" role="alert">
             <?php echo $succes ?>
          </div>
        <?php endforeach ; ?>
      </div>
      <div class="jumbotron">
        <h1 class="display-4">Registration form</h1>
        <br>
      <form action="" method="POST" enctype = "multipart/form-data">
        <div class="form-group">
          <label for="">Name</label>
          <input type="text" class="form-control" name="name" value="<?php if (isset($name)) {
              echo $name;
          }?>" required>
        </div>
        <div class="form-group">
          <label for="">Contact No</label>
          <input type="text" class="form-control" name="contact" value="<?php if (isset($contact)) {
              echo $contact;
          }?>" required>
        </div>
        <div class="form-group">
          <label for="">Email</label>
          <input type="email" class="form-control" name="email" value="<?php if (isset($email)) {
              echo $email;
          }?>" required>
        </div>
        <div class="form-group">
          <label for="">Why Join us? (Optional)</label>
          <textarea name="review" class="form-control" rows="8" cols="80" ><?php if (isset($review)) {
              echo $review;
          }?></textarea>
        </div>
        <div class="form-group">
          <label  >Please upload your CV. Only PDF and below 2MB.</label>
          <input type="file" name="file"  required >
        </div>
        <button type="submit" name="submit" class="btn btn-outline-primary">Submit</button>
      </form>
      </div>
      <footer class="footer text-center">
        <p>&copy; Webteam 2017</p>
      </footer>

    </div>


    <script link="js/bootstrap.min.js">
    </script>
  </body>
</html>
