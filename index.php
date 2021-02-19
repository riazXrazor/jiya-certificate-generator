<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>JIYA Certificate Generator</title>
  </head>
  <body>
    <center>
      <br><br><br>
      <h3>JIYA Certificate Generator</h3>
      <br><br><br><br>
      <div class="container">
      <form method="post" action="">
      <div class="row">
      <div class="form-group col-sm-12 col-md-12">
        <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name Here...">
      </div>
      <div class="form-group col-sm-12 col-md-4">
      <select class="form-control" name="gender">
        <option value="he">Male</option>
        <option value="she">Female</option>
      </select>
      </div>
      <div class="form-group col-sm-12 col-md-4">
      <select class="form-control" name="template">
        <option value="SuperJiyan">SuperJiyan</option>
        <option value="IncredibleJiyan">Incredible JIyan</option>
      </select>
      </div>
      <div class="form-group col-sm-12 col-md-4">
       <input class="form-control" type="date" name="cdate" />
      </div>
      </div>
      <button type="submit" name="generate" class="btn btn-primary">Generate</button>
    </form>
    </div>
    <br>
    <?php 
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
      if (isset($_POST['generate'])) {
        $name = strtoupper($_POST['name']);
        $name_len = strlen($_POST['name']);
        // $occupation = strtoupper($_POST['occupation']);
        // if ($occupation) {
        //   $font_size_occupation = 10;
        // }

        if ($name == "") {
          echo 
          "
          <div class='alert alert-danger col-sm-6' role='alert'>
              Ensure you fill all the fields!
          </div>
          ";
        }else{
          echo 
          "
          <div class='alert alert-success col-sm-6' role='alert'>
              Certificate generated for $name.
          </div>
          ";

          //print_r($_POST);
          $current_date = date('jS F');
          $current_year = date('Y');
          if($_POST['cdate']){
            $cdate = strtotime($_POST['cdate']);
            $current_date = date('jS F',$cdate);
            $current_year = date('Y',$cdate);
          }
          //designed certificate picture
          $gender = $_POST['gender'];
          $image = $_POST['template'].'_'.$gender.'.png';
          
          list($mwidth,$mheight) = getimagesize($image);


          $createimage = imagecreatefrompng($image);

          //this is going to be created once the generate button is clicked
          $output = "certificate.png";

          //then we make use of the imagecolorallocate inbuilt php function which i used to set color to the text we are displaying on the image in RGB format
          $white = imagecolorallocate($createimage, 205, 245, 255);
          $black = imagecolorallocate($createimage, 0, 0, 0);

          //Then we make use of the angle since we will also make use of it when calling the imagettftext function below
          $rotation = 0;

          //we then set the x and y axis to fix the position of our text name
          $origin_x = 500;
          $origin_y=600;

          //we then set the x and y axis to fix the position of our text occupation
          $origin1_x = 800;
          $origin1_y= $mheight - 130;

          $origin2_x = 814;
          $origin2_y= $mheight - 607;

          //we then set the differnet size range based on the lenght of the text which we have declared when we called values from the form
          
            $font_size = 55;
            $dfont_size = 30;
            $origin_x = $mwidth/2 - 300;
          
   


          $certificate_text = $name;

          //font directory for name
          $drFont = dirname(__FILE__)."/fonts/Courgette-Regular.ttf";

                 
          $bbox = imagettfbbox($font_size, 0, $drFont, $certificate_text);


          //$origin_x = $bbox[0] + (imagesx($createimage) / 2) - ($bbox[4] / 2) + (-220);
          //$y = $bbox[1] + (imagesy($createimage) / 2) - ($bbox[5] / 2) - 5;


    

          // font directory for date name
           $drFont1 = dirname(__FILE__)."/fonts/GlacialIndifference-Bold.otf";
           $drFont11 = dirname(__FILE__)."/fonts/GlacialIndifference-Regular.otf";
           $color1 = imagecolorallocate($createimage, 240,78,63);
           if($_POST['template'] === 'IncredibleJiyan'){
            $color1 = imagecolorallocate($createimage, 0,114,198);
           }
           $dfont_size1 = 35;

           // font directory for gender name
           $drFont2 = dirname(__FILE__)."/fonts/CooperHewitt-Book.otf";
           $dfont_size2 = 40;
           $color2 = imagecolorallocate($createimage, 51,51,51);

          //function to display name on certificate picture
          $text1 = imagettftext($createimage, $font_size, $rotation, $origin_x, $origin_y, $color1,$drFont, $certificate_text);

          //function to display date on certificate picture
          $text2 = imagettftext($createimage, $dfont_size1, $rotation, $origin1_x, $origin1_y, $color1, $drFont1, $current_date);
          //function to display date on certificate picture
          $text22 = imagettftext($createimage, $dfont_size1 - 1, $rotation, $origin1_x + 100, $origin1_y + 75, $color2, $drFont11, $current_year);

          // //function to display gender on certificate picture
          // $text3 = imagettftext($createimage, $dfont_size2, $rotation, $origin2_x, $origin2_y, $color2, $drFont2, $gender);

          imagepng($createimage,$output,3);

 ?>
        <!-- this displays the image below -->
        <div style="width: 50%;">
          <img style="width:100%" src="<?php echo $output; ?>">
        </div>
        <br> 
        <br>

        <!-- this provides a download button -->
        <a href="<?php echo $output; ?>" class="btn btn-success">Download Certificate</a>
        <br><br>
<?php 
        }
      }

     ?>

    </center>



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>