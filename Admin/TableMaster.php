<?php session_start(); ?>
<?php

include '../MAIN/Dbconfig.php';

$pageTitle = 'TableMaster';


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



<!-- Add/ update Modal -->
<div class="modal fade addUpdateModal" id="TableModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-0">
            <div class="modal-body master_modal p-0">
                <div class="modalmainDiv ">
                    <div class="d-flex justify-content-between px-3 py-3">
                        <h4>Add New Table</h4>
                        <button type="button" class="btn-close CloseBtn" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" class="AddForm" id="addtable_form" novalidate>
                        <div class="px-4 py-5">
                            <div class="row">
                                <div class="col-lg-3 ">
                                    <label for="branch_id" class="col-form-label">Branch</label>
                                </div>
                                <div class="col-lg-9">
                                    <select name="BranchId" id="branch_id" class="form-select" required>
                                        <option hidden value="">Choose Branch</option>
                                        <?php
                                        $fetchBranches = mysqli_query($con, "SELECT brId,branchName FROM branch_master");
                                        foreach ($fetchBranches as $fetchBranchResult) {
                                            echo '<option value="' . $fetchBranchResult["brId"] . '">' . $fetchBranchResult["branchName"] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-lg-3 ">
                                    <label for="table_name" class="col-form-label">Table</label>
                                </div>
                                <div class="col-lg-9">
                                    <input type="text" id="table_name" name="TableName" class="form-control" placeholder="Enter Table Name" required>
                                </div>
                            </div>
                        </div>

                        <div class="modalFootDiv">
                            <div class="d-flex justify-content-between">
                                <div class="d-flex">
                                    <button type="button" class="btn btn_reset"> <i class="material-icons">delete</i> <span>Reset</span> </button>
                                </div>
                                <div>
                                    <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn_cancel CloseBtn me-3"> <span>Cancel</span> </button>
                                    <button type="submit" class="btn btn_save"> <span>Save Table</span> </button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <form action="" id="updatetable_form" class="UpdateForm" style="display: none;" novalidate>
                        <div class="px-4 py-5">
                            <div class="row">
                                <div class="col-lg-3">
                                    <label for="update_branch_id" class="col-form-label">Branch</label>
                                </div>
                                <div class="col-lg-9">
                                    <input type="text" id="edit_table_id" name="UpdateTableId" hidden>
                                    <select name="UpdateTableBranch" id="update_branch" class="form-select" required>
                                        <?php
                                        foreach ($fetchBranches as $fetchBranchResult) {
                                            echo '<option value="' . $fetchBranchResult["brId"] . '">' . $fetchBranchResult["branchName"] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-lg-3 ">
                                    <label for="update_table_name" class="col-form-label">Table</label>
                                </div>
                                <div class="col-lg-9">
                                    <input type="text" id="update_table_name" name="UpdateTableName" class="form-control" placeholder="Enter Table Name" required>
                                </div>
                            </div>
                        </div>

                        <div class="modalFootDiv">
                            <div class="d-flex justify-content-between">
                                <div class="d-flex">
                                    <button type="button" class="btn btn_reset"> <i class="material-icons">delete</i> <span>Reset</span> </button>
                                </div>
                                <div>
                                    <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn_cancel CloseBtn me-3"> <span>Cancel</span> </button>
                                    <button type="submit" class="btn btn_save"> <span>Update Table</span> </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>




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
                <h5 class="text-center">Delete Table</h5>
                <p class="text-center mt-3 px-3">Are you sure you want to delete this Table?</p>
                <div class="text-center mt-5">
                    <button type="button" id="confirmYes" class="btn btn_save w-100">Yes , Delete Table</button>
                    <button type="button" id="confirmNo" class="btn btn_deleteCancel w-100 mt-3" data-bs-dismiss="modal">No , Cancel Deleting</button>
                </div>
            </div>
        </div>
    </div>
</div>




<!-- Qr Code Modal -->
<div class="modal deleteModal fade" id="QrcodeModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body py-5 px-4">
                <div class="text-center deleteImg">
                    <canvas id="LinkQr"></canvas>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="" class="btn btn-success mt-4 py-2" download="QrCode.png" id="DownloadQr">Download</a>
                    <button class="btn btn-danger mt-4 px-4 py-2" data-bs-dismiss="modal">Cancel</button>
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
                        <h3>Table</h3>
                    </div>
                    <div class="admintoolbar">
                        <div class="card card-body">
                            <div class="row ">
                                <div class="col-lg-4 col-6">
                                    <input type="text" class="form-control" id="SearchBar" placeholder="Search by Table">
                                </div>
                                <div class="col-lg-2 col-6">
                                    <select name="" class="form-select" id="FilterBrand">
                                        <option hidden value="">Branch</option>
                                        <?php
                                        foreach ($fetchBranches as $fetchBranchResult) {
                                            echo '<option value="' . $fetchBranchResult["branchName"] . '">' . $fetchBranchResult["branchName"] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-lg-2 col-6">
                                    <button class="btn btn_reset px-5"><span>Clear</span></button>
                                </div>
                                <div class="col-lg-4 text-end col-4">
                                    <button class="btn add_master px-5" data-bs-toggle="modal" data-bs-target="#TableModal"> <span> <i class="material-icons">add</i> </span> <span>Add Table</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card card-body mastertable mt-3 p-0">
                        <table class="table" id="MasterTable" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th class="ps-3">SL NO.</th>
                                    <th class="">BRANCH</th>
                                    <th class="">TABLE</th>
                                    <th class="">CREATED</th>
                                    <th class="">LINK</th>
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


<script src="https://cdn.jsdelivr.net/npm/@emretulek/jbvalidator"></script>

<script>
    $(document).ready(function() {



        //modal close function
        $(".addUpdateModal").on("hidden.bs.modal", function() {
            $('.UpdateForm').hide();
            $('.AddForm').show();
            $('.UpdateForm')[0].reset();
            $('.AddForm')[0].reset();
        });


        //reset form function
        $('.btn_reset').click(function() {
            $('.UpdateForm')[0].reset();
            $('.AddForm')[0].reset();
            MasterTable.search('').draw();
            MasterTable.column(1).search('').draw();
            $('#SearchBar').val('');
            $('#FilterBrand').val('').change();
        });


        //does not allow special and numbers
        $('#table_name,#update_table_name').keypress(function() {
            return /[a-zA-Z0-9 _-]/i.test(event.key);
        });



        //data Table
        var MasterTable = $('#MasterTable').DataTable({
            "processing": true,
            //"responsive": true,
            "ajax": "TableMasterData.php",
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
                    data: 'branchName'
                },
                {
                    data: 'tableName'
                },
                {
                    data: 'createdDate',
                    render: function(data, type, row, meta) {
                        if (type === 'sort') {
                            return data;
                        }
                        return moment(data).format("MMM D , YYYY");
                    },
                    searchable: false
                },
                {
                    data: 'tId',
                    searchable: false,
                    orderable: false,
                    "render": function(data, type, row, meta) {
                        if (type == 'display') {
                            //data = '<button class=" btn btn_actions btn_edit me-3  shadow-none" type="button" data-bs-toggle="tooltip" data-bs-custom-class="edit-tooltip" data-bs-placement="top" data-bs-title="Edit" value="' + data + '"> <i class="material-icons">edit</i> </button>';
                            data = '<div class="">  <button class="btn btn_actions btn_link me-3" data-bs-toggle="tooltip" data-bs-custom-class="view-tooltip" data-bs-placement="top" data-bs-title="View QR" value="' + data + '"><i class="material-icons">qr_code</i> </button>  </div>'
                        }
                        return data;
                    }
                },
                {
                    data: 'tId',
                    searchable: false,
                    orderable: false,
                    "render": function(data, type, row, meta) {
                        if (type == 'display') {
                            //data = '<button class=" btn btn_actions btn_edit me-3  shadow-none" type="button" data-bs-toggle="tooltip" data-bs-custom-class="edit-tooltip" data-bs-placement="top" data-bs-title="Edit" value="' + data + '"> <i class="material-icons">edit</i> </button>';
                            data = '<div class="d-flex justify-content-end me-3">  <button class="btn btn_actions btn_edit me-3" data-bs-toggle="tooltip" data-bs-custom-class="edit-tooltip" data-bs-placement="top" data-bs-title="Edit" value="' + data + '"><i class="material-icons">edit</i> </button> <button class="btn btn_actions btn_delete" data-bs-toggle="tooltip" data-bs-custom-class="delete-tooltip" data-bs-placement="top" data-bs-title="Delete" value="' + data + '"><i class="material-icons">delete</i> </button>  </div>'
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

        $('#FilterBrand').change(function() {
            var BranchFilter = $(this).val();
            //console.log(BranchFilter);
            MasterTable.column(1).search(BranchFilter).draw();
        });

        /* Add master Start */
        $(function() {

            let validator = $('#addtable_form').jbvalidator({
                language: 'dist/lang/en.json',
                successClass: false,
                html5BrowserDefault: true
            });

            validator.validator.custom = function(el, event) {
                if ($(el).is('#table_name') && $(el).val().match(/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/)) {
                    return 'Only allowed alphabets,numbers,- & _';
                } else if ($(el).is('#table_name') && $(el).val().trim().length == 0) {
                    return 'Cannot be empty';
                }
            }

            $(document).on('submit', '#addtable_form', (function(e) {
                e.preventDefault();
                var TableData = new FormData(this);
                console.log(TableData);
                $.ajax({
                    type: "POST",
                    url: "MasterOperations.php",
                    data: TableData,
                    beforeSend: function() {
                        $('#loading').show();
                        $('#updatetable_form').addClass("disable");
                        $('#TableModal').modal('hide');
                        $('#ResponseImage').html("");
                        $('#ResponseText').text("");;
                    },
                    success: function(data) {
                        $('#loading').hide();
                        console.log(data);
                        if (TestJson(data) == true) {
                            var response = JSON.parse(data);
                            if (response.addTable == "0") {
                                $('#ResponseImage').html('<img src="./warning.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                $('#ResponseText').text("Table is Already Present");
                                $('#confirmModal').modal('show');
                            } else if (response.addTable == "1") {
                                $('#ResponseImage').html('<img src="./success.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                $('#ResponseText').text("Successfully Added Table");
                                $('#confirmModal').modal('show');
                                $('#addtable_form')[0].reset();
                                MasterTable.ajax.reload();
                            } else if (response.addTable == "2") {
                                //$('#TableModal').modal('hide');
                                $('#ResponseImage').html('<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                $('#ResponseText').text("Failed Adding Table");
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
        /* Add master  End */



        /* update master Start */
        $(function() {

            let validator = $('#updatetable_form').jbvalidator({
                //language: 'dist/lang/en.json',
                successClass: false,
                html5BrowserDefault: true
            });

            validator.validator.custom = function(el, event) {
                if ($(el).is('#update_table_name') && $(el).val().match(/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/)) {
                    return 'Only allowed alphabets,numbers,- & _';
                } else if ($(el).is('#update_table_name') && $(el).val().trim().length == 0) {
                    return 'Cannot be empty';
                }
            }

            $(document).on('submit', '#updatetable_form', (function(e) {
                e.preventDefault();
                var UpdateTableData = new FormData(this);
                console.log(UpdateTableData);
                $.ajax({
                    type: "POST",
                    url: "MasterOperations.php",
                    data: UpdateTableData,
                    beforeSend: function() {
                        $('#loading').show();
                        $('#updatetable_form').addClass("disable");
                        $('#TableModal').modal('hide');
                        $('#ResponseImage').html("");
                        $('#ResponseText').text("");
                    },
                    success: function(data) {
                        $('#loading').hide();
                        console.log(data);
                        $('#updatetable_form').removeClass("disable");
                        //console.log(TestJson(data));
                        if (TestJson(data) == true) {
                            var response = JSON.parse(data);
                            if (response.UpdateTable == "0") {
                                $('#ResponseImage').html('<img src="./warning.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                $('#ResponseText').text("Table is Already Present");
                                $('#confirmModal').modal('show');
                            } else if (response.UpdateTable == "1") {
                                $('#ResponseImage').html('<img src="./success.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                $('#ResponseText').text("Successfully Updated Table");
                                $('#confirmModal').modal('show');
                                $('#updatetable_form')[0].reset();
                                MasterTable.ajax.reload();
                            } else if (response.UpdateTable == "2") {
                                //$('#TableModal').modal('hide');
                                $('#ResponseImage').html('<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                $('#ResponseText').text("Failed Updating Table");
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
        /* update master End */



        //edit master
        $('#MasterTable tbody').on('click', '.btn_edit', function() {
            var editValue = $(this).val();
            console.log(editValue);
            $.ajax({
                type: "POST",
                url: "MasterOperations.php",
                data: {
                    editTable: editValue
                },
                beforeSend: function() {
                    //$('#delModal').modal('hide');
                    $('.UpdateForm').show();
                    $('.AddForm').hide();
                },
                success: function(data) {
                    $('#TableModal').modal('show');
                    console.log(data);
                    var EditResponse = JSON.parse(data);
                    //console.log(EditResponse);
                    if (EditResponse.TableValue == 'Error') {
                        toastr.error("some error occured");
                    } else {
                        $('#update_table_name').val(EditResponse.TableName);
                        $('#update_branch').val(EditResponse.TableBranchId).change();
                        $('#edit_table_id').val(editValue);
                    }
                }
            });
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
                            delTable: delValue
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
                                if (delResponse.delTable == 0) {
                                    $('#ResponseImage').html('<img src="./warning.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                    $('#ResponseText').text("Table is Already in Use");
                                    $('#confirmModal').modal('show');
                                } else if (delResponse.delTable == 1) {
                                    $('#ResponseImage').html('<img src="./success.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                    $('#ResponseText').text("Successfully Deleted Table");
                                    $('#confirmModal').modal('show');
                                    $('#updatetable_form')[0].reset();
                                    MasterTable.ajax.reload();
                                } else if (delResponse.delTable == 2) {
                                    $('#ResponseImage').html('<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                    $('#ResponseText').text("Failed Deleting Table");
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


        // button link
        $('#MasterTable tbody').on('click', '.btn_link', function() {
            var linkValue = $(this).val();
            //console.log(linkValue);
            var HostName = '<?php echo $_SERVER['HTTP_HOST'] ?>';
            var Link = "http://" + HostName + "/MUFFIN/Customer/DineInMenu.php?TABLEID=" + linkValue + "";
            console.log(Link);
            $('#QrcodeModal').modal('show');
            var qrcode = new QRious({
                element: document.getElementById("LinkQr"),
                background: '#ffffff',
                backgroundAlpha: 1,
                foreground: '#d94042',
                foregroundAlpha: 1,
                level: 'H',
                padding: 25,
                size: 300,
                value: Link
            });

        });

        var cnvs = document.getElementById('LinkQr')
        var button = document.getElementById('DownloadQr');
        button.addEventListener('click', function(e) {
            var dataURL = cnvs.toDataURL('image/png');
            button.href = dataURL;
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