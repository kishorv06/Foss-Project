<?php

    include_once 'config.php';
    session_start();
    $task = $_REQUEST['task'];
    if($task != 4)
        header("Content-Type: application/json; charset=UTF-8");
    
    //Check if user is logged in
    function isLogged(){
        if(isset($_SESSION['loggedin']))
            return True;
        else
            return False;
    }

    if($task == 0){
        //Admin login
        $result = query("SELECT uname, password FROM Details");
        $row = $result->fetch_assoc();
        if($row['uname'] == $_REQUEST['uname'] && $row['password'] == $_REQUEST['password']){
            $_SESSION['loggedin'] = True;
            echo '{"status": "OK"}';
        }else{
            echo '{"status": "ERROR"}';  
        }
    }
    else if($task == 1){
        //Admin Logout
        unset($_SESSION['loggedin']);
        session_destroy();
        header("Location: admin.php");
    }
    else if($task == 2){
        //Clear responses
        if(isLogged()){
            $result = query("Truncate table Responses");
            echo '{"status":"OK"}';
        }else{
            echo '{"status":"Error"}';
        }
    }
    else if($task == 3){
        //Update Settings
        if(isLogged()){
            query("UPDATE Details SET name = '".$_REQUEST['name']."', password = '".$_REQUEST['password']."',max_response = ".$_REQUEST['max'].", is_accepting = ".$_REQUEST['accept']);
            for($i = 1; $i<= 10; $i++)
                query("UPDATE Fields SET name = '".$_REQUEST['col'.$i]."' WHERE id = ".$i);
            echo '{"status":"OK"}';
        }    
    }
    else if($task == 4){
        //Export responses
        if(isLogged()){
            $data = "";
            header("Content-Disposition: attachment; filename=\"Exported.xls\"");
            header("Content-Type: application/vnd.ms-excel");
            $result = query("SELECT * FROM Fields WHERE NOT (name = '')");
            $head = array();
            $sql = "SELECT ";
            while ($row = $result->fetch_assoc()){
                array_push($head,$row['name']);
                $sql .= "col".$row['id'].",";
            }
            $sql .= "time FROM Responses";
            echo implode("\t", $head)."\t Timestamp" . "\r\n";
            $result = query($sql);
            while($row = $result->fetch_assoc()){
                echo implode("\t",array_values($row))."\r\n";
            }
            echo "\0";            
        }
    }
    else if($task == 5){
        //Save a new response
        $col = array();
        $val = array();
        for($i = 1; $i <= 10; $i++)
            if(isset($_REQUEST['col'.$i])){
                array_push($col,"col".$i);
                array_push($val,"'".$_REQUEST['col'.$i]."'");
            }
        $sql = "INSERT INTO Responses(".join(",",$col).") VALUES (".join(",",$val).")";
        query($sql);
        echo '{"status":"OK"}';
    }

?>
