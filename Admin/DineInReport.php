<?php session_start(); ?>
<?php

include '../MAIN/Dbconfig.php';

$pageTitle = 'DineInReport';


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
<div class="modal fade addUpdateModal" id="BranchModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-0">
            <div class="modal-body master_modal p-0">
                <div class="modalmainDiv ">
                    <div class="d-flex justify-content-between px-3 py-3">
                        <h4>Add New Branch</h4>
                        <button type="button" class="btn-close CloseBtn" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="" class="AddForm" id="addbranch_form" novalidate>
                        <div class="row px-4 py-5">
                            <div class="col-lg-3">
                                <label for="branch_name" class="col-form-label">Branch</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="text" id="branch_name" name="BranchName" class="form-control" placeholder="Enter Branch Name" required>
                            </div>
                        </div>

                        <div class="modalFootDiv">
                            <div class="d-flex justify-content-between">
                                <div class="d-flex">
                                    <button type="button" class="btn btn_reset"> <i class="material-icons">delete</i> <span>Reset</span> </button>
                                </div>
                                <div>
                                    <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn_cancel CloseBtn me-3"> <span>Cancel</span> </button>
                                    <button type="submit" class="btn btn_save"> <span>Save Branch</span> </button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <form action="" id="updatebranch_form" class="UpdateForm" style="display: none;" novalidate>
                        <div class="row px-3 py-5">
                            <div class="col-lg-3">
                                <label for="update_branch_name" class="col-form-label">Branch</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="text" id="edit_branch_id" name="UpdateBranchId" hidden>
                                <input type="text" id="update_branch_name" name="UpdateBranchName" class="form-control" placeholder="Enter Branch Name" required>
                            </div>

                        </div>

                        <div class="modalFootDiv">
                            <div class="d-flex justify-content-between">
                                <div class="d-flex">
                                    <button type="button" class="btn btn_reset"> <i class="material-icons">delete</i> <span>Reset</span> </button>
                                </div>
                                <div>
                                    <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn_cancel CloseBtn me-3"> <span>Cancel</span> </button>
                                    <button type="submit" class="btn btn_save"> <span>Update Branch</span> </button>
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
                <h5 class="text-center">Delete Branch</h5>
                <p class="text-center mt-3 px-3">Are you sure you want to delete this Branch?</p>
                <div class="text-center mt-5">
                    <button type="button" id="confirmYes" class="btn btn_save w-100">Yes , Delete Branch</button>
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
                        <h3>DineIn Report</h3>
                    </div>
                    <div class="admintoolbar">
                        <div class="card card-body">
                            <div class="row">
                                <div class="col-lg-2 col-4">
                                    <input type="text" class="form-control" id="SearchBar" placeholder="Search by Branch">
                                </div>
                                <div class="col-lg-2 col-6">
                                    <select name="" class="form-select" id="FilterBranch">
                                        <option hidden value="">Branch</option>
                                        <?php
                                        $FindBranches = mysqli_query($con, "SELECT branchName FROM branch_master");
                                        foreach ($FindBranches as $FindBranchResult) {
                                            echo '<option value="' . $FindBranchResult["branchName"] . '">' . $FindBranchResult["branchName"] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-lg-2 col-6">
                                    <select name="" class="form-select" id="FilterTable">
                                        <option hidden value="">Table</option>
                                        <?php
                                        $FindTables = mysqli_query($con, "SELECT tableName FROM table_master");
                                        foreach ($FindTables as $FindTableResult) {
                                            echo '<option value="' . $FindTableResult["tableName"] . '">' . $FindTableResult["tableName"] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-lg-2 col-4">
                                    <label for="min" class="d-flex">
                                        <span class="mt-2">From</span>
                                        <input type="text" class="form-control ms-2 w-75 dateSelect" id="min" name="min" value="<?= date('m/d/Y'); ?>" readonly>
                                    </label>
                                </div>
                                <div class="col-lg-2 col-4">
                                    <label for="max" class="d-flex">
                                        <span class="mt-2">To</span>
                                        <input type="text" class="form-control ms-2 w-75 dateSelect" id="max" name="max" value="<?= date('m/d/Y'); ?>" readonly>
                                    </label>
                                </div>
                                <div class="col-lg-2 col-6 text-end">
                                    <button class="btn btn_reset px-5"><span>Clear</span></button>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card card-body mastertable mt-3 p-0">
                        <table class="table" id="MasterTable" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th class="ps-3">ORDER ID</th>
                                    <th class="">BRANCH</th>
                                    <th class="">TABLE</th>
                                    <th class="">AMOUNT</th>
                                    <th class="">STATUS</th>
                                    <th class="">PAYMENT</th>
                                    <th class="">DATE</th>
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


        $('.btn_reset').click(function() {
            location.reload();
        });


        $('#FilterBranch').change(function() {
            var BranchFilter = $(this).val();
            //console.log(BranchFilter);
            MasterTable.column(1).search(BranchFilter).draw();
        });


        $('#FilterTable').change(function() {
            var TableFilter = $(this).val();
            //console.log(BranchFilter);
            MasterTable.column(2).search(TableFilter).draw();
        });




        var minDate, maxDate;

        // Custom filtering function which will search data in column four between two values
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                var min_date = document.getElementById("min").value;
                var min = new Date(min_date);
                console.log(min);
                var max_date = document.getElementById("max").value;
                var max = new Date(max_date);

                var startDate = new Date(data[6]);
                //window.confirm(startDate);
                if (!min_date && !max_date) {
                    return true;
                }
                if (!min_date && startDate <= max) {
                    return true;
                }
                if (!max_date && startDate >= min) {
                    return true;
                }
                if (startDate <= max && startDate >= min) {
                    return true;
                }
                return false;
            }
        );


        // Create date inputs
        minDate = new DateTime($('#min'), {
            format: 'M/D/YYYY'
        });
        maxDate = new DateTime($('#max'), {
            format: 'M/D/YYYY'
        });


        // Refilter the table
        $('#min, #max').on('change', function() {
            MasterTable.draw();
            

        });



        //data Table
        var MasterTable = $('#MasterTable').DataTable({
            "processing": true,
            //"responsive": true,
            "ajax": "DineInReportData.php",
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
                    data: 'orderId',
                    // searchable: false,
                    // orderable: false,
                    "render": function(data, type, row, meta) {
                        if (type == 'display') {
                            //data = '<button class=" btn btn_actions btn_edit me-3  shadow-none" type="button" data-bs-toggle="tooltip" data-bs-custom-class="edit-tooltip" data-bs-placement="top" data-bs-title="Edit" value="' + data + '"> <i class="material-icons">edit</i> </button>';
                            data = '<div class="ms-3"> ' + data + ' </div>'
                        }
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
                    data: 'orderTotal',
                    searchable: false,
                    orderable: false,
                },
                {
                    data: 'orderStatus',
                    searchable: false,
                    orderable: false,
                },
                {
                    data: 'orderPayment',
                    searchable: false,
                    orderable: false,
                },
                {
                    data: 'createdDate',
                    render: function(data, type, row, meta) {
                        if (type === 'sort') {
                            return data;
                        }
                        return moment(data).format("MMM D , YYYY");
                    },

                },
                {
                    data: 'oId',
                    searchable: false,
                    orderable: false,
                    "render": function(data, type, row, meta) {
                        if (type == 'display') {
                            //data = '<button class=" btn btn_actions btn_edit me-3  shadow-none" type="button" data-bs-toggle="tooltip" data-bs-custom-class="edit-tooltip" data-bs-placement="top" data-bs-title="Edit" value="' + data + '"> <i class="material-icons">edit</i> </button>';
                            data = '<div class="d-flex justify-content-end me-3"> <a class="btn btn_actions btn_delete" data-bs-toggle="tooltip" data-bs-custom-class="delete-tooltip" data-bs-placement="top" data-bs-title="View Detail" href=DineInReportDetail.php?OrderId=' + data + '><i class="material-icons">search</i> </a>  </div>'
                        }
                        return data;
                    }
                },

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




    });
</script>


<!-- footer -->

<?php

include '../MAIN/Footer.php';

?>