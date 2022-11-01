<?php session_start(); ?>
<?php

include '../MAIN/Dbconfig.php';

$pageTitle = 'UserMaster';

if (isset($_SESSION['custname']) && isset($_SESSION['custtype'])) {

    if ($_SESSION['custtype'] == 'SuperAdmin' || $_SESSION['custtype'] == 'Admin') {
    } else {
        header("location:../login.php");
    }
} else {

    header("location:../login.php");
}

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




<!-- Delete  Modal -->
<div class="modal deleteModal fade" id="delModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body py-5 px-4">
                <div class="text-center deleteImg mb-5">
                    <img src="./error.jpg" class="img-fluid" alt="">
                </div>
                <h5 class="text-center">Delete User</h5>
                <p class="text-center mt-3 px-3">Are you sure you want to delete this User?</p>
                <div class="text-center mt-5">
                    <button type="button" id="confirmYes" class="btn btn_save w-100">Yes , Delete User</button>
                    <button type="button" id="confirmNo" class="btn btn_deleteCancel w-100 mt-3" data-bs-dismiss="modal">No , Cancel Deleting</button>
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
                    <div class="Adminheading">
                        <h3>Users</h3>
                    </div>
                    <div class="admintoolbar">
                        <div class="card card-body">
                            <div class="row justify-content-between">
                                <div class="col-lg-4 col-4">
                                    <input type="text" class="form-control" id="SearchBar" placeholder="Search by Name,Phone,Role">
                                </div>
                                <div class="col-lg-4 text-end col-4">
                                    <a href="./AddUser.php" class="btn add_master px-5"> <span> <i class="material-icons">add</i> </span> <span>Add User</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card card-body mastertable mt-3 p-0">
                        <table class="table" id="MasterTable" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th class="ps-3">SL NO.</th>
                                    <th class="">NAME</th>
                                    <th class="">PHONE</th>
                                    <th class="">BRANCH</th>
                                    <th class="">ROLE</th>
                                    <th class="">ADDRESS</th>
                                    <th class="text-end pe-3">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>

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


<script>
    $(document).ready(function() {



        //data Table
        var MasterTable = $('#MasterTable').DataTable({
            "processing": true,
            //"responsive": true,
            "ajax": "UserData.php",
            "scrollY": "600px",
            "scrollX": true,
            "scrollCollapse": true,
            "fixedHeader": true,
            "dom": 'rt<"bottom"ip>',
            "pageLength": 10,
            "pagingType": 'simple_numbers',
            "language": {
                "paginate": {
                    "previous": "<i class='bi bi-caret-left-fill'></i>",
                    "next": "<i class='bi bi-caret-right-fill'></i>"
                }
            },
            "columns": [{
                    data: null,
                    searchable: false,
                    render: function(data, type, row, meta) {
                        data = '<div class="ps-3">' + (meta.row + meta.settings._iDisplayStart + 1) + '</div>'
                        //return meta.row + meta.settings._iDisplayStart + 1;
                        return data;
                    }
                },
                {
                    data: 'empName'
                },
                {
                    data: 'empPhone',
                    searchable: true,
                    orderable: false,
                },
                {
                    data: 'branchName'
                },
                {
                    data: 'empRole'
                },
                {
                    data: 'empAddress',
                    searchable: false,
                    orderable: false,
                },
                {
                    data: 'empId',
                    searchable: false,
                    orderable: false,
                    "render": function(data, type, row, meta) {
                        if (type == 'display') {
                            //data = '<button class=" btn btn_actions btn_edit me-3  shadow-none" type="button" data-bs-toggle="tooltip" data-bs-custom-class="edit-tooltip" data-bs-placement="top" data-bs-title="Edit" value="' + data + '"> <i class="material-icons">edit</i> </button>';
                            data = '<div class="d-flex justify-content-end me-3">  <a href="UpdateUser.php?UId=' + data + '" class="btn btn_actions btn_edit me-3" data-bs-toggle="tooltip" data-bs-custom-class="edit-tooltip" data-bs-placement="top" data-bs-title="Edit"><i class="material-icons">edit</i> </a> <button class="btn btn_actions btn_delete" data-bs-toggle="tooltip" data-bs-custom-class="delete-tooltip" data-bs-placement="top" data-bs-title="Delete" value="' + data + '"><i class="material-icons">delete</i> </button>  </div>'
                        }
                        return data;
                    }
                }
            ]
        });


        //tooltip on table
        MasterTable.on('draw', function() {
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
        });


        //Searchbar
        $('#SearchBar').keyup(function() {
            MasterTable.search($(this).val()).draw();
        });



        //delete master
        $('#MasterTable tbody').on('click', '.btn_delete', function() {
            var delValue = $(this).val();
            console.log(delValue);
            $('#delModal').modal('show');
            $('#confirmYes').click(function() {
                if (delValue != null) {
                    $.ajax({
                        type: "POST",
                        url: "MasterOperations.php",
                        data: {
                            delUser: delValue
                        },
                        beforeSend: function() {
                            $('#loading').show();
                            $('#delModal').modal('hide');
                            $('#ResponseImage').html("");
                            $('#ResponseText').text("");
                        },
                        success: function(data) {
                            $('#loading').hide();
                            console.log(data);
                            if (TestJson(data) == true) {
                                var delResponse = JSON.parse(data);
                                if (delResponse.deleteUser == 0) {
                                    $('#ResponseImage').html('<img src="./warning.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                    $('#ResponseText').text("User is Already in Use");
                                    $('#confirmModal').modal('show');
                                } else if (delResponse.deleteUser == 1) {
                                    $('#ResponseImage').html('<img src="./success.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                    $('#ResponseText').text("Successfully Deleted User");
                                    $('#confirmModal').modal('show');
                                    $('#updatebranch_form')[0].reset();
                                    MasterTable.ajax.reload();
                                } else if (delResponse.deleteUser == 2) {
                                    $('#ResponseImage').html('<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                    $('#ResponseText').text("Failed Deleting User");
                                    $('#confirmModal').modal('show');
                                }
                                delValue = undefined;
                                delete window.delValue;
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
                    });
                } else {}
            });
            $('#confirmNo').click(function() {
                delValue = undefined;
                delete window.delValue;
            });
        });


        toastr.options = {
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-bottom-right",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "3000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }

    });
</script>


<!-- footer -->

<?php

include '../MAIN/Footer.php';

?>