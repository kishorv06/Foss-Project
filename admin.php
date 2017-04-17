<!DOCTYPE html>
<html lang="en">
<?php
    include_once 'config.php';
    session_start();
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Admin Panel</title>
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
                <h3>Admin Panel</h3>
            </a>
            <?php
                if (isset($_SESSION['loggedin'])){
                    echo '<ul class="nav navbar-nav nav-flex-icons ml-auto"><li class="nav-item "><a class="nav-link" href="" data-toggle="modal" data-target="#settings_modal" ><h4 class="fa fa-cog white-text"></h4></a></li><li class="nav-item "><a class="nav-link" href="backend.php?task=1"><h4 class="fa fa-sign-out white-text"></h4></a></li></ul>';
                }            
            ?>
        </div>
    </nav>
    <br>
    <br>
             <?php
                //Check if user is logged in. If yes, the responses and settings are shown. If no, login page is shown
                if (!isset($_SESSION['loggedin'])){
                    $content  = '<div class="jumbotron col-md-4 offset-md-4" style="margin-top: 30px;"><div class="row"><div class="col-md-12">';
                    $content .= '<h2>Login</h2><hr><br><div class="row">';
                    $content .= '<div class="col-md-12"><div class="md-form"><input type="text" id="form1" class="form-control"><label for="form1">Username</label></div></div>';
                    $content .= '<div class="col-md-12"><div class="md-form"><input type="password" id="form2" class="form-control" onkeydown="if(event.keyCode == 13) { login(); }"><label for="form2">Password</label></div></div>';
                    $content .= '<div class="col-md-12"><h5 class="red-text" id="error"></h5></div>';                            
                    $content .= '</div></div><div class="col-md-12"><button class="btn btn-primary float-right" onclick="login()">Login</button></div>';
                }else{
                    //Get the list of active fields
                    $result = query("SELECT * FROM Fields WHERE NOT (name = '')");
                    $content  = '<div class="jumbotron col-md-10 offset-md-1" style="margin-top: 30px;"><div class="row"><div class="col-md-12">';
                    $content .= '<h2 class="pull-left">Responses</h2><button class="btn btn-primary float-right" onclick="window.open(\'backend.php?task=4\')" ><i class="fa fa-download"></i></button><button class="btn btn-danger float-right" data-toggle="modal" data-target="#delete_modal" ><i class="fa fa-refresh"></i></button></div>';
                    if(mysqli_num_rows($result) > 0){
                        $sql = "SELECT id,";
                        $content .= '<table class="table table-striped"><thead><tr><th>ID</th>';
                        while($row = $result->fetch_assoc()){
                            $sql .= "col".$row['id'].",";
                            $content .= "<th>".$row['name']."</th>";
                        }
                        $content .= '<th>Timestamp</th><th>Actions</th></tr></thead><tbody>';
                        $sql .= " time FROM Responses";
                        //Get responses
                        $result = query($sql);
                        while($row = $result->fetch_assoc()){
                            $content .= "<tr>";
                            foreach($row as $key => $value) {
                                $content .= '<td>'.$value.'</td>';   
                            }
                            $content .= "<td><a onclick='deleteRow(".$row['id'].",false)'><i class='fa fa-trash'></i></a></td></tr>";
                        }
                        $content .= "</tbody></table>";
                        
                        //When No responses are available.
                        if(mysqli_num_rows($result)==0)
                            $content .= "<div class='col-md-12 text-center'><h6>No Responses available</h6></div>";
                            
                    }else{
                        //When no fields are enabled.
                        $content .= '<div class="col-md-12 text-center"><h4>No fields are enabled. Please enable any field.</h4></center></div>';
                    } 
                }
                //print the html
                echo $content;
            ?>             
            </div>
        </div>
    </div>
    <div class="modal fade" id="settings_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <!--Content-->
            <div class="modal-content">
                <!--Header-->
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Settings</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!--Body-->
                <div class="modal-body">
                    <br>
                    <div class="row">
                        <?php
                            //Printing Settings
                            $result = query("SELECT * FROM Details");
                            $row = $result->fetch_assoc();
                        ?>
                        <div class="col-md-6">
                            <div class="md-form">
                                <input type="text" id="f1" class="form-control" value="<?php echo $row['name']; ?>"><label for="f1">Name</label>
                            </div>
                        </div> 
                        <div class="col-md-6">
                            <div class="md-form">
                                <input type="text" id="f2" class="form-control" value="<?php echo $row['max_response']; ?>">
                                <label for="f2">Max Responses</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="md-form">
                                <input type="password" id="f3" class="form-control" value="<?php echo $row['password']; ?>">
                                <label for="f3">Admin Password</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <p style="margin-bottom:5px;">Accept Responses </p>
                            <label class="switch">
                                <input id="f4" type="checkbox" <?php if($row['is_accepting'] == 1) echo ' checked="checked" '?> >
                                <div class="slider round"></div>
                            </label>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <h4>Input Fields</h4>
                            <hr>
                            <p><i class="fa fa-info-circle"></i> Keep field name blank to disable it.</p>
                            <br>
                        </div>
                        <?php
                            //Printing the inputs for storing field names.
                            $result = query("SELECT * FROM Fields");
                            $i = 1;
                            while($row = $result->fetch_assoc()){
                                echo '<div class="col-md-6"><div class="md-form"><input type="text" id="col'.$i.'" class="form-control" value="'.$row['name'].'"><label for="col'.$i.'">Field '.$i.'</label></div></div>';  
                                $i += 1;                            
                            }
                        ?>
                    </div>
                    <div class="col-md-12"><h6 class="red-text" id="error"></h6></div>
                </div>
                <!--Footer-->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="save()">Save changes</button>
                </div>
            </div>
            <!--/.Content-->
        </div>
    </div>
    <div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <!--Content-->
            <div class="modal-content">
                <!--Header-->
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Warning</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!--Body-->
                <div class="modal-body">
                    <h6>Reset event ? This will permanently delete all responses. </h6>
                </div>
                <!--Footer-->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger" onclick="delRes()">Yes</button>
                </div>
            </div>
            <!--/.Content-->
        </div>
    </div>
    <div class="modal fade" id="deleteRow" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <!--Content-->
            <div class="modal-content">
                <!--Header-->
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Warning</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!--Body-->
                <div class="modal-body">
                    <h6>Delete responses ? You cannot undo this action.</h6>
                </div>
                <!--Footer-->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger"data-dismiss="modal" id="deleteRowConfirm" onClick="">Yes</button>
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
        //Custom Javascript Functions
        
        //Login the user
        function login(){
            $.get( "backend.php?task=0&uname="+$("#form1").val()+"&password="+encodeURI($("#form2").val()) , function( data ) {
                if(data.status == "OK")
                    document.location.reload();
                else
                    $("#error").html("Incorrect Username or Password");
            }, "json" );
        }
        
        //Delete the responses
        function delRes(){
            $.get( "backend.php?task=2" , function( data ) {
                if(data.status == "OK")
                    document.location.reload();
            }, "json" );
        }
        
        //Save settings
        function save(){
            url = "backend.php?task=3&name="+encodeURI($("#f1").val())+"&max="+encodeURI($("#f2").val())+"&accept=";
            url += ($("#f4").is(':checked'))? "1" : "0";
            if($("#f3").val()==""){
                $("#error").html("Password Cannot be blank");
                return;
            }else{
                url += "&password="+encodeURI($("#f3").val());
            }
            for(i=1;i<=10;i++)
                url += "&col"+i+"="+encodeURI($("#col"+i).val());
            $.get( url , function( data ) {
                if(data.status == "OK")
                    document.location.reload();
            }, "json" );
        }
        
        //Delete a single response
        function deleteRow(id,confirmed){
            if(confirmed){
                $.get( "backend.php?task=6&id="+id , function( data ) {
                    if(data.status == "OK")
                        document.location.reload();
                }, "json" );
            }else{
                rowID = id;
                $("#deleteRowConfirm").attr("onClick","deleteRow("+id+",true)");
                $('#deleteRow').modal('show');   
            }   
        }
        
    </script>
</body>
</html>
