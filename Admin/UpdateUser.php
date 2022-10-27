<?php  session_start(); ?>
<?php

include '../MAIN/Dbconfig.php';

$page_title = 'TableMaster';



if(isset($_SESSION['custname']) && isset($_SESSION['custtype'])){

    if($_SESSION['custtype'] == 'SuperAdmin' || $_SESSION['custtype'] == 'Admin'){

    }
    else{
        header("location:../login.php");
    }
    
}
else{

header("location:../login.php");

}


$UserID = $_GET['UId'];



?>


<?php include '../MAIN/Header.php'; ?>



<!-- Confirm Modal -->
<div class="modal fade ResponseModal" id="confirmModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-3 py-5">
                <div class="text-center mb-4" id="ResponseImage">

                </div>
                <h4 id="ResponseText" class="text-center mb-3"></h4>
                <div class="text-center">
                    <button type="button" id="btnConfirm" style="display: none;" class="btn btn_save mt-4 px-5 py-2" data-bs-dismiss="modal">Proceed</button>
                    <button type="button" id="btnClose" class="btn btn_save mt-4 px-5 py-2" data-bs-dismiss="modal">Okay</button>
                </div>
            </div>
        </div>
    </div>
</div>







<!-- sidebar -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="SidebarMenu" aria-labelledby="offcanvasExampleLabel">

    <div class="offcanvas-body p-0">
        <div class="py-3">
            <h5 class="menu_heading">THE MUFFIN HOUSE</h5>
        </div>

        <div>
            <?php include '../MAIN/Sidebar.php'; ?>
        </div>
    </div>

</div>




<main class="">

    <aside id="aside">
        <div class="innerAside">
            <div class="InnerContent">
                <div class="py-3">
                    <h5 class=" menu_heading">THE MUFFIN HOUSE</h5>
                </div>
                <?php include '../MAIN/Sidebar.php'; ?>
            </div>
        </div>
    </aside>


    <section id="newmain">

        <!--NAVBAR-->
        <?php include '../MAIN/Navbar.php'; ?>

        <main id="adminmain">

            <div class="mainContents">
                <div class="container-lg">

                    <?php if (isset($_GET['UId'])) {

                        $findUserDetails = mysqli_query($con , "SELECT * FROM employee_master e INNER JOIN user_table u ON e.empId = u.users_id WHERE e.empId = '$UserID'");
                        foreach($findUserDetails as $findUserDetailResults){

                        }
                    ?>

                        <form action="" id="UpdateUser" novalidate>

                            <div class="Adminheading">
                                <h3>User Master</h3>
                            </div>
                            <div class="admintoolbar">
                                <div class="card card-body">
                                    <div class="row justify-content-between">
                                        <div class="col-lg-4 col-6">
                                            <button type="button" class="btn btn_reset shadow-none px-lg-5"> <i class="material-icons">delete</i> <span>Reset</span> </button>
                                        </div>
                                        <div class="col-lg-4 text-end col-4">
                                            <button class="btn add_master px-lg-5" type="submit"> <span> <i class="material-icons">add</i> </span> <span>Update User</span></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3 MasterForm mb-5">
                                <div class="col-5">

                                    <div class="card card-body">
                                        <h5 class="subheadings">Login Credentails</h5>
                                        <div class="mb-3 mt-3">
                                            <input type="text" name="UpdateEmployeeId" value="<?= $UserID ?>" hidden>
                                            <label for="update_user_name" class="form-label">Phone Number</label>
                                            <input type="number" class="form-control" name="UpdateUserName" id="update_user_name" value="<?= $findUserDetailResults['userPhone'] ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="update_user_password" class="form-label">Password</label>
                                            <input type="text" class="form-control" name="UpdateUserPassword" id="update_user_password" value="<?= $findUserDetailResults['userPassword'] ?>" required>
                                        </div>
                                    </div>

                                    <div class="card card-body mt-4">
                                        <h5 class="subheadings">Set Role</h5>
                                        <div class="mb-3 mt-3">
                                            <label for="update_user_name" class="form-label">User Role</label>
                                            <select name="UpdateUserRole" id="update_user_role" class="form-select" required>
                                                <option hidden value="<?= $findUserDetailResults['empRole'] ?>"><?= $findUserDetailResults['empRole'] ?></option>
                                                <option value="Admin">Admin</option>
                                            </select>

                                        </div>

                                    </div>

                                    <div class="card card-body mt-4">
                                        <h5 class="subheadings">Branch</h5>
                                        <div class="mb-3 mt-3">
                                            <?php
                                            $findbranch = mysqli_query($con, "SELECT brId,branchName FROM branch_master");
                                            foreach ($findbranch as $branchResults) {
                                            ?>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="UpdateUserBranch" value="<?php echo $branchResults['brId']; ?>" id="<?php echo $branchResults['branchName']; ?>"  <?php echo ($branchResults['brId'] == $findUserDetailResults['empBranch']) ? "checked" : "" ?> required>
                                                    <label class="form-check-label" for="<?php echo $branchResults['branchName']; ?>"> <?php echo $branchResults['branchName']; ?> </label>
                                                </div>

                                            <?php
                                            }

                                            ?>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-7">
                                    <div class="card card-body">
                                        <h5 class="subheadings">Basic Information</h5>
                                        <div class="mb-3 mt-3">
                                            <label for="update_full_name" class="form-label">Full Name</label>
                                            <input type="text" class="form-control" name="UpdateFullName" id="update_full_name" value="<?= $findUserDetailResults['empName'] ?>" required>
                                        </div>
                                        <div class="mb-2">
                                            <label for="update_user_phone" class="form-label">Phone Number</label>
                                            <input type="number" class="form-control" name="UpdateUserPhone"  id="update_user_phone" value="<?= $findUserDetailResults['empPhone'] ?>">
                                        </div>
                                        <div class="mb-2">
                                            <label for="update_user_email" class="form-label">Email</label>
                                            <input type="email" class="form-control" name="UpdateUserEmail" id="update_user_email" value="<?= $findUserDetailResults['empEmail'] ?>">
                                        </div>
                                        <div class="mb-2">
                                            <label for="update_user_address" class="form-label">Address</label>
                                            <textarea name="UpdateUserAddress" class="form-control" id="update_user_address" cols="30" rows="5" ><?= $findUserDetailResults['empAddress'] ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>




                    <?php
                    }
                    ?>




                </div>
            </div>

        </main>

    </section>

</main>




<main id="loading">
    <div id="loadingDiv">
        <img class="img-fluid loaderGif" src="./loader.svg" alt="">
    </div>
</main>


<script src="https://cdn.jsdelivr.net/npm/@emretulek/jbvalidator"></script>

<script>
    $(document).ready(function() {



        //reset form function
        $('.btn_reset').click(function() {
            $('#UpdateUser')[0].reset();
        });


        //does not allow special and numbers
        $('#update_full_name').keypress(function() {
            return /[a-zA-Z ]/i.test(event.key);
        });

        //only allow numbers
        $('#update_user_name,#update_user_phone').keypress(function() {
            return /[0-9]/i.test(event.key);
        });




        /* Update master Start */
        $(function() {

            let validator = $('#UpdateUser').jbvalidator({
                //language: 'dist/lang/en.json',
                successClass: false,
                html5BrowserDefault: true
            });

            validator.validator.custom = function(el, event) {
                if ($(el).is('#update_full_name') && $(el).val().match(/[0-9!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/)) {
                    return 'Only allowed alphabets,-,&,_';
                } else if ($(el).is('#update_user_name,#update_user_password,#update_full_name') && $(el).val().trim().length == 0) {
                    return 'Cannot be empty';
                }
            }

            $(document).on('submit', '#UpdateUser', (function(e) {
                e.preventDefault();
                var UserUpdateData = new FormData(this);
                console.log(UserUpdateData);
                $.ajax({
                    type: "POST",
                    url: "MasterOperations.php",
                    data: UserUpdateData,
                    beforeSend: function() {
                        $('#loading').show();
                        $('#updatetable_form').addClass("disable");
                        $('#ResponseImage').html("");
                        $('#ResponseText').text("");;
                    },
                    success: function(data) {
                        $('#loading').hide();
                        console.log(data);
                        if (TestJson(data) == true) {
                            var response = JSON.parse(data);
                            if (response.EmployeeUpdate == "0") {
                                $('#ResponseImage').html('<img src="./warning.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                $('#ResponseText').text("This login phone number is already used by another user");
                                $('#confirmModal').modal('show');
                            } else if (response.EmployeeUpdate == "1") {
                                $('#ResponseImage').html('<img src="./success.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                $('#ResponseText').text("Successfully Updated User");
                                $('#confirmModal').modal('show');
                                $('#UpdateUser')[0].reset();
                                location.href ="UserMaster.php";
                            } else if (response.EmployeeUpdate== "2") {
                                //$('#TableModal').modal('hide');
                                $('#ResponseImage').html('<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                $('#ResponseText').text("Failed Updating User");
                                $('#confirmModal').modal('show');
                            }
                        } else {
                            $('#ResponseImage').html('<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                            $('#ResponseText').text("Some Error Occured, Please refresh the page (ERROR : 12ENJ)");
                            $('#confirmModal').modal('show');
                        }
                    },
                    error: function() {
                        $('#ResponseImage').html('<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                        $('#ResponseText').text("Please refresh the page to continue (ERROR : 12EFF)");
                        $('#confirmModal').modal('show');
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }));

        });
        /* Update master  End */





    });
</script>


<!-- footer -->

<?php

include '../MAIN/Footer.php';

?>