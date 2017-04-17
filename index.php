<!DOCTYPE html>
<html lang="en">
<?php
    include_once 'config.php';
    $result = query("SELECT * FROM Details");
    $row = $result->fetch_assoc();
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo $row['name']; ?></title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.0/css/font-awesome.min.css">
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="css/mdb.min.css" rel="stylesheet">
    <!-- custom styles -->
    <link href="css/style.css" rel="stylesheet">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
</head>

<body>
    <nav class="navbar fixed-top navbar-toggleable-md bg-primary">
        <div class="container">
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand text-white" href="#">
                <h3><?php echo $row['name']; ?></h3>
            </a>
            <ul class="nav navbar-nav nav-flex-icons ml-auto">
                <li class="nav-item ">
                    <a class="nav-link" href="#" data-toggle="modal" data-target="#info_modal">
                        <h4 class="fa fa-info-circle white-text"></h4>
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="admin.php">
                        <h4 class="fa fa-cog white-text"></h4>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    <br>
    <br>
    <div class="jumbotron col-md-6 offset-md-3" style="margin-top: 30px;">
        <div class="row">
            <div class="col-md-12">
                    <?php 
                        $max = $row["max_response"];
                        $accepting = $row["is_accepting"];
                        $result = query("SELECT count(*) FROM Responses");
                        $registrations = $result->fetch_assoc()["count(*)"];
                        
                        //If max results not reached and is accepting responses, accept. Else print a message.
                        
                        if ($registrations == $max || !$accepting){
                            //Error Message
                            $content = '<div class="col-md-12 text-center"><img src="img/error.png"></img><h4>Sorry, we are not accepting any responses.</h4></center></div>';
                        }else{
                            //Selecting actiev fields
                            $result = query("SELECT * FROM Fields WHERE NOT (name = '')");
                            $i = 1;
                            $content = '<h2>Registration Form</h2><h6 class="float-right"> Seats remaining : '.($max-$registrations).'</h6><br><hr><div class="row">';
                            while($row = $result->fetch_assoc()) {
                                $content .='<div class="col-md-6"><div class="md-form"><input type="text" id="col'.$i.'" class="form-control"><label for="col'.$i.'">'.$row['name'].'</label></div></div>';
                                $i += 1;
                            }
                            if($i != 0)
                                $content .= '</div></div><div class="col-md-12 text-center"><h5 id="success" class="green-text"></h5></center></div><div class="col-md-12 text-center"><h6 id="error" class="red-text"></h6></center></div><div class="col-md-12"><button class="btn btn-primary float-right" onclick="submit()">Submit</button></div>';
                            else
                                $content = '<div class="col-md-12 text-center"><img src="img/error.png"></img><h4>Sorry, we are not accepting any responses.</h4></center></div>';
                        }
                        echo $content;
                    ?>    
            </div>
        </div>
    </div>
    <div class="modal fade" id="info_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <!--Content-->
            <div class="modal-content">
                <!--Header-->
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Information</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!--Body-->
                <div class="modal-body text-center">
                    <h5><b>FOSS LAB PROJECT 2017</b></h5>
                    <br>
                    <h6>Adarsh P V</h6>
                    <h6>Jithu K S</h6>
                    <h6>Kishor V</h6>
                    <h6>Rahul J Reynold</h6>
                    <h6>Vipin A</h6>
                </div>
            </div>
            <!--/.Content-->
        </div>
    </div>
    
    <!-- SCRIPTS -->
    <!-- JQuery -->
    <script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="js/tether.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="js/mdb.min.js"></script>
    <script>
        //Custom Javascript
        
        //Save response
        function submit(){
            url = "backend.php?task=5";
            valid = true;
            $("input[type=text]").each(function() {
                //Checks if any input is blank
                if(this.value != "") {
                    url += "&"+this.id+"="+encodeURI(this.value);
                    $(this).css("border-bottom-color","");
                }else{
                    $(this).css("border-bottom-color","red");
                    valid = false;
                }
            });
            if(!valid){
                //One of the input was blank
                $("#error").html("All fields are mandatory.");
                return;
            }
            else{
                $("#error").html(""); 
            }
            
            //Upload the data
            $.get( url , function( data ) {
                if(data.status == "OK"){
                    $("#success").html("Response Submitted.");
                    window.setTimeout(function(){
                        document.location.reload();
                    },2000);  
                }
            }, "json" );
        }
        
    </script>
</body>
</html>
