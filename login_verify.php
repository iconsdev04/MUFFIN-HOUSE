<?php session_start(); ?>
<?php     

include './MAIN/Dbconfig.php';

$user = 0;
$pass = 0;
    if(isset($_POST['userName'])){

        $username = $_POST['userName'];
        $password = $_POST['password'];
       
        if (!empty($_POST['userName']) && !empty($_POST['password'])) {

            $search_user = mysqli_query($con, "SELECT userPhone FROM user_table WHERE userPhone = '$username'");

            foreach($search_user as $user_rows){
                if($username === $user_rows['userPhone']){
                    $user = 1;
                }
                else{
                    $user = 0;
                }
            }
            if($user === 1){

                $search_pass = mysqli_query($con, "SELECT userPassword FROM user_table WHERE userPhone = '$username'");

                foreach($search_pass as $pass_rows){

                    if($password === $pass_rows['userPassword']){
                        $pass = 1;
                    }
                    else{
                    // $pass = 0;
                    }
                        
                }
                if(($user === 1) & ($pass === 1)){

                    $id_query = mysqli_query($con, "SELECT users_id,userRole,userName from user_table WHERE userPhone = '$username' AND userPassword = '$password'");
                    foreach($id_query as $id_row){
                        $user_id = $id_row['users_id'];
                        $user_type = $id_row['userRole'];
                        $name = $id_row['userName'];
                        $_SESSION['custid'] = $user_id;
                        $_SESSION['custname'] = $name;
                        $_SESSION['custtype'] = $user_type;
                        // setcookie('custnamecookie',$name,time()+(86400*2), "/");
                        // setcookie('custidcookie',$user_id,time()+(86400*2), "/");
                        // setcookie('custtypecookie',$user_type,time()+(86400*2), "/");
                    }

                    if($user_type == 'SUPERADMIN'){
                        echo json_encode(array('success' => 1));
                    }
                    elseif($user_type == 'Admin'){
                        echo json_encode(array('success' => 2));
                    }
                    else if($user_type == 'EMPLOYEE'){
                        echo json_encode(array('success' => 3));
                    }

                }
                else{

                   // echo json_encode(array('success' => 0));
                    echo "Password In correct";
                }
            }
            else{
                echo "User not found";
            }

        }
        else{
            echo "The feilds are empty";
        }
        

        


        

        

    
    }
















?>