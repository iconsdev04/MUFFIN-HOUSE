<?php  session_start(); ?>
<?php

include '../MAIN/Dbconfig.php';

$pageTitle = 'CategoryMaster';

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

?>
<style>
#category_image::file-selector-button,
#update_category_image::file-selector-button {

    padding: 0.2em 0.4em;
    border-radius: 0em;
    background-color: rgb(231, 230, 250);
    font-weight: 600;
    height: 45px;
}

#MasterTable .categoryImage {
    height: 30px;
    width: 30px;
    border-radius: 50%;
}
</style>



<?php include '../MAIN/Header.php'; ?>



<!-- Add/ update Modal -->
<div class="modal fade addUpdateModal" id="CategoryModal" tabindex="-1" data-bs-backdrop="static"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-0">
            <div class="modal-body master_modal p-0">
                <div class="modalmainDiv" style="margin-bottom: -20px;">
                    <div class="d-flex justify-content-between px-3 py-3">
                        <h4>Add New Category</h4>
                        <button type="button" class="btn-close CloseBtn" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <form action="" class="AddForm" id="addcategory_form" novalidate>
                        <div class="px-4 py-5">
                            <div class="row">
                                <div class="col-lg-3">
                                    <label for="category_name" class="col-form-label">Category</label>
                                </div>
                                <div class="col-lg-9">
                                    <input type="text" id="category_name" name="CategoryName" class="form-control"
                                        placeholder="Enter Category Name" required>
                                </div>
                            </div>

                            <div class="mt-3 row">
                                <div class="col-lg-3">
                                    <label for="category_name" class="col-form-label">Image</label>
                                </div>
                                <div class="col-lg-9">
                                    <input type="file" id="category_image" name="CategoryImage" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="modalFootDiv">
                            <div class="d-flex justify-content-between ">
                                <div class="d-flex">
                                    <button type="button" class="btn btn_reset"> <i class="material-icons">delete</i>
                                        <span>Reset</span> </button>
                                </div>
                                <div>
                                    <button type="button" data-bs-dismiss="modal" aria-label="Close"
                                        class="btn btn_cancel CloseBtn me-3"> <span>Cancel</span> </button>
                                    <button type="submit" class="btn btn_save"> <span>Save Category</span> </button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <form action="" class="UpdateForm" id="updatecategory_form" novalidate style="display: none;">
                        <div class="px-4 py-5">
                            <div class="row">
                                <div class="col-lg-3">
                                    <label for="update_category_name" class="col-form-label">Category</label>
                                </div>
                                <div class="col-lg-9">
                                    <input type="text" id="edit_category_id" name="UpdateCategoryId" hidden>
                                    <input type="text" id="update_category_name" name="UpdateCategoryName"
                                        class="form-control" placeholder="Enter Category Name" required>
                                </div>
                            </div>

                            <div class="mt-3 row">
                                <div class="col-lg-3">
                                    <label for="update_category_image" class="col-form-label">Image</label>
                                </div>
                                <div class="col-lg-9">
                                    <input type="file" id="update_category_image" name="UpdateCategoryImage"
                                        class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="modalFootDiv">
                            <div class="d-flex justify-content-between ">
                                <div class="d-flex">
                                    <button type="button" class="btn btn_reset"> <i class="material-icons">delete</i>
                                        <span>Reset</span> </button>
                                </div>
                                <div>
                                    <button type="button" data-bs-dismiss="modal" aria-label="Close"
                                        class="btn btn_cancel CloseBtn me-3"> <span>Cancel</span> </button>
                                    <button type="submit" class="btn btn_save"> <span>Update Category</span> </button>
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
<div class="modal fade ResponseModal" id="confirmModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-3 py-5">
                <div class="text-center mb-4" id="ResponseImage">

                </div>
                <h4 id="ResponseText" class="text-center mb-3"></h4>
                <div class="text-center">
                    <button type="button" id="btnConfirm" style="display: none;" class="btn btn_save mt-4 px-5 py-2"
                        data-bs-dismiss="modal">Proceed</button>
                    <button type="button" id="btnClose" class="btn btn_save mt-4 px-5 py-2"
                        data-bs-dismiss="modal">Okay</button>
                </div>
            </div>
        </div>
    </div>
</div>




<!-- Delete  Modal -->
<div class="modal deleteModal fade" id="delModal" tabindex="-1" data-bs-backdrop="static"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body py-5 px-4">
                <div class="text-center deleteImg mb-5">
                    <img src="./error.jpg" class="img-fluid" alt="">
                </div>
                <h5 class="text-center">Delete Category</h5>
                <p class="text-center mt-3 px-3">Are you sure you want to delete this Category?</p>
                <div class="text-center mt-5">
                    <button type="button" id="confirmYes" class="btn btn_save w-100">Yes , Delete Category</button>
                    <button type="button" id="confirmNo" class="btn btn_deleteCancel w-100 mt-3"
                        data-bs-dismiss="modal">No , Cancel Deleting</button>
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
                        <h3>Category</h3>
                    </div>
                    <div class="admintoolbar">
                        <div class="card card-body">
                            <div class="row justify-content-between">
                                <div class="col-lg-4 col-4">
                                    <input type="text" class="form-control" id="SearchBar"
                                        placeholder="Search by Branch">
                                </div>
                                <div class="col-lg-4 text-end col-4">
                                    <button class="btn add_master px-5" data-bs-toggle="modal"
                                        data-bs-target="#CategoryModal"> <span> <i class="material-icons">add</i>
                                        </span> <span>Add Category</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card card-body mastertable mt-3 p-0">
                        <table class="table" id="MasterTable" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th class="ps-3">SL NO.</th>
                                    <th class="">IMAGE</th>
                                    <th class="">CATEGORY</th>
                                    <th class="">CREATED</th>
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


    $('.btn_reset').click(function() {
        $('.UpdateForm')[0].reset();
        $('.AddForm')[0].reset();
    })


    //does not allow special and numbers
    $('#category_name,#update_category_name').keypress(function() {
        return /[a-zA-Z0-9 _-]/i.test(event.key);
    });



    //Table
    var MasterTable = $('#MasterTable').DataTable({
        "processing": true,
        //"responsive": true,
        "ajax": "CategoryMasterData.php",
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
                    data = '<div class="ps-3">' + (meta.row + meta.settings._iDisplayStart +
                        1) + '</div>'
                    //return meta.row + meta.settings._iDisplayStart + 1;
                    return data;
                }
            },
            {
                data: 'categoryImage',
                searchable: false,
                orderable: false,
                "render": function(data, type, row, meta) {
                    if (type == 'display') {
                        data = ' <div>   <img class="categoryImage" src="../CATEGORY/' + data +
                            '"> </div>'
                    }
                    return data;
                }
            },
            {
                data: 'categoryName'
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
                data: 'catId',
                searchable: false,
                orderable: false,
                "render": function(data, type, row, meta) {
                    if (type == 'display') {
                        //data = '<button class=" btn btn_actions btn_edit me-3  shadow-none" type="button" data-bs-toggle="tooltip" data-bs-custom-class="edit-tooltip" data-bs-placement="top" data-bs-title="Edit" value="' + data + '"> <i class="material-icons">edit</i> </button>';
                        data =
                            '<div class="d-flex justify-content-end me-3">  <button class="btn btn_actions btn_edit me-3" data-bs-toggle="tooltip" data-bs-custom-class="edit-tooltip" data-bs-placement="top" data-bs-title="Edit" value="' +
                            data +
                            '"><i class="material-icons">edit</i> </button> <button class="btn btn_actions btn_delete" data-bs-toggle="tooltip" data-bs-custom-class="delete-tooltip" data-bs-placement="top" data-bs-title="Delete" value="' +
                            data + '"><i class="material-icons">delete</i> </button>  </div>'
                    }
                    return data;
                }
            }
        ]
    });


    //Tooltip
    MasterTable.on('draw', function() {
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(
            tooltipTriggerEl));
    });


    //Searchbar
    $('#SearchBar').keyup(function() {
        MasterTable.search($(this).val()).draw();
    });


    /* Add master Start */
    $(function() {

        let validator = $('#addcategory_form').jbvalidator({
            language: 'dist/lang/en.json',
            successClass: false,
            html5BrowserDefault: true
        });

        validator.validator.custom = function(el, event) {
            if ($(el).is('#category_name') && $(el).val().match(
                    /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/)) {
                return 'Only allowed alphabets,numbers,- & _';
            } else if ($(el).is('#category_name') && $(el).val().trim().length == 0) {
                return 'Cannot be empty';
            }
        }

        $(document).on('submit', '#addcategory_form', (function(e) {
            e.preventDefault();
            var CategoryData = new FormData(this);
            console.log(CategoryData);
            $.ajax({
                type: "POST",
                url: "MasterOperations.php",
                data: CategoryData,
                beforeSend: function() {
                    $('#loading').show();
                    $('#updatecategory_form').addClass("disable");
                    $('#CategoryModal').modal('hide');
                    $('#ResponseImage').html("");
                    $('#ResponseText').text("");;
                },
                success: function(data) {
                    $('#loading').hide();
                    console.log(data);
                    if (TestJson(data) == true) {
                        var response = JSON.parse(data);
                        if (response.addCategory == "0") {
                            $('#ResponseImage').html(
                                '<img src="./warning.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
                                );
                            $('#ResponseText').text(
                                "Category is Already Present");
                            $('#confirmModal').modal('show');
                        } else if (response.addCategory == "1") {
                            $('#ResponseImage').html(
                                '<img src="./success.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
                                );
                            $('#ResponseText').text(
                                "Successfully Added Category");
                            $('#confirmModal').modal('show');
                            $('#addcategory_form')[0].reset();
                            MasterTable.ajax.reload();
                        } else if (response.addCategory == "2") {
                            //$('#CategoryModal').modal('hide');
                            $('#ResponseImage').html(
                                '<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
                                );
                            $('#ResponseText').text("Failed Adding Category");
                            $('#confirmModal').modal('show');
                        } else if (response.addCategory == "3") {
                            //$('#CategoryModal').modal('hide');
                            $('#ResponseImage').html(
                                '<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
                                );
                            $('#ResponseText').text(
                                "Image format is not corerct");
                            $('#confirmModal').modal('show');
                        }
                    } else {
                        $('#ResponseImage').html(
                            '<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
                            );
                        $('#ResponseText').text(
                            "Some Error Occured, Please refresh the page (ERROR : 12ENJ)"
                            );
                        $('#confirmModal').modal('show');
                    }
                },
                error: function() {
                    $('#ResponseImage').html(
                        '<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
                        );
                    $('#ResponseText').text(
                        "Please refresh the page to continue (ERROR : 12EFF)"
                        );
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

        let validator = $('#updatecategory_form').jbvalidator({
            //language: 'dist/lang/en.json',
            successClass: false,
            html5BrowserDefault: true
        });

        validator.validator.custom = function(el, event) {
            if ($(el).is('#update_category_name') && $(el).val().match(
                    /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/)) {
                return 'Only allowed alphabets,numbers,- & _';
            } else if ($(el).is('#update_category_name') && $(el).val().trim().length == 0) {
                return 'Cannot be empty';
            }
        }

        $(document).on('submit', '#updatecategory_form', (function(e) {
            e.preventDefault();
            var UpdateCategoryData = new FormData(this);
            console.log(UpdateCategoryData);
            $.ajax({
                type: "POST",
                url: "MasterOperations.php",
                data: UpdateCategoryData,
                beforeSend: function() {
                    $('#loading').show();
                    $('#updatecategory_form').addClass("disable");
                    $('#CategoryModal').modal('hide');
                    $('#ResponseImage').html("");
                    $('#ResponseText').text("");
                },
                success: function(data) {
                    $('#loading').hide();
                    console.log(data);
                    $('#updatecategory_form').removeClass("disable");
                    //console.log(TestJson(data));
                    if (TestJson(data) == true) {
                        var response = JSON.parse(data);
                        if (response.UpdateCategory == "0") {
                            $('#ResponseImage').html(
                                '<img src="./warning.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
                                );
                            $('#ResponseText').text(
                                "Category is Already Present");
                            $('#confirmModal').modal('show');
                        } else if (response.UpdateCategory == "1") {
                            $('#ResponseImage').html(
                                '<img src="./success.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
                                );
                            $('#ResponseText').text(
                                "Successfully Updated Category");
                            $('#confirmModal').modal('show');
                            $('#updatecategory_form')[0].reset();
                            MasterTable.ajax.reload();
                        } else if (response.UpdateCategory == "2") {
                            //$('#CategoryModal').modal('hide');
                            $('#ResponseImage').html(
                                '<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
                                );
                            $('#ResponseText').text("Failed Updating Category");
                            $('#confirmModal').modal('show');
                        }
                    } else {
                        $('#ResponseImage').html(
                            '<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
                            );
                        $('#ResponseText').text(
                            "Some Error Occured, Please refresh the page (ERROR : 12ENJ)"
                            );
                        $('#confirmModal').modal('show');
                    }
                },
                error: function() {
                    $('#ResponseImage').html(
                        '<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
                        );
                    $('#ResponseText').text(
                        "Please refresh the page to continue (ERROR : 12EFF)"
                        );
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
                editCategory: editValue
            },
            beforeSend: function() {
                //$('#delModal').modal('hide');
                $('.UpdateForm').show();
                $('.AddForm').hide();
            },
            success: function(data) {
                $('#CategoryModal').modal('show');
                console.log(data);
                var EditResponse = JSON.parse(data);
                //console.log(EditResponse);
                if (EditResponse.CategoryValue == 'Error') {
                    toastr.error("some error occured");
                } else {
                    $('#update_category_name').val(EditResponse.CategoryName);
                    $('#edit_category_id').val(editValue);
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
                        delCategory: delValue
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
                            if (delResponse.delCategory == 0) {
                                $('#ResponseImage').html(
                                    '<img src="./warning.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
                                    );
                                $('#ResponseText').text(
                                    "Category is Already in Use");
                                $('#confirmModal').modal('show');
                            } else if (delResponse.delCategory == 1) {
                                $('#ResponseImage').html(
                                    '<img src="./success.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
                                    );
                                $('#ResponseText').text(
                                    "Successfully Deleted Category");
                                $('#confirmModal').modal('show');
                                $('#updatecategory_form')[0].reset();
                                MasterTable.ajax.reload();
                            } else if (delResponse.delCategory == 2) {
                                $('#ResponseImage').html(
                                    '<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
                                    );
                                $('#ResponseText').text("Failed Deleting Category");
                                $('#confirmModal').modal('show');
                            }
                            delValue = undefined;
                            delete window.delValue;
                        } else {
                            $('#ResponseImage').html(
                                '<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
                                );
                            $('#ResponseText').text(
                                "Some Error Occured, Please refresh the page (ERROR : 12ENJ)"
                                );
                            $('#confirmModal').modal('show');
                        }
                    },
                    error: function() {
                        $('#ResponseImage').html(
                            '<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
                            );
                        $('#ResponseText').text(
                            "Please refresh the page to continue (ERROR : 12EFF)"
                            );
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