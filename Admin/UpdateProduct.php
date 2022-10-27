<?php session_start(); ?>
<?php

include '../MAIN/Dbconfig.php';

$pageTitle = 'UpdateProduct';


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


        <?php

        if (isset($_GET['ProductId'])) {

            $ProductId = $_GET['ProductId'];
            $FetchDetails = mysqli_query($con, "SELECT * FROM product_master p INNER JOIN category_master c ON p.catId = c.catId INNER JOIN branch_master b ON p.brId = b.brId WHERE p.prId = '$ProductId'");
            foreach ($FetchDetails as $FetchResults) {
            }

        ?>

            <main id="adminmain">

                <div class="mainContents">
                    <div class="container-lg">

                        <form action="" id="UpdateProduct" novalidate>

                            <div class="Adminheading">
                                <h3>Add Product</h3>
                            </div>
                            <div class="admintoolbar">
                                <div class="card card-body">
                                    <div class="row justify-content-between">
                                        <div class="col-lg-4 col-6">
                                            <button type="button" class="btn btn_reset shadow-none px-lg-5"> <i class="material-icons">delete</i> <span>Reset</span> </button>
                                        </div>
                                        <div class="col-lg-4 text-end col-4">
                                            <button class="btn add_master px-lg-5" type="submit"> <span> <i class="material-icons">update</i> </span> <span>Update Product</span></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3 MasterForm mb-5">
                                <div class="col-5">

                                    <div class="card card-body">
                                        <h5 class="subheadings">Pricing Info</h5>
                                        <div class="mb-3 mt-3">
                                            <input type="text" name="UpdateProductId" value="<?= $ProductId ?>" hidden>
                                            <label for="product_price" class="form-label">Product Price</label>
                                            <input type="number" class="form-control" name="UpdateProductPrice" id="product_price" value="<?= intval($FetchResults['productPrice']); ?>" required>
                                        </div>
                                    </div>

                                    <div class="card card-body mt-4">
                                        <h5 class="subheadings">Availability</h5>
                                        <div class="mb-3 mt-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="UpdateProductDineIn" id="DineInMenu" <?php echo ($FetchResults['dineIn'] == 'YES') ? "checked" : "" ?> >
                                                <label class="form-check-label" for="DineInMenu">Dine-In-Menu</label>
                                            </div>
                                            <div class="form-check mt-2">
                                                <input class="form-check-input" type="checkbox" name="UpdateProductEcommerce" id="ECommerce" <?php echo ($FetchResults['ecom'] == 'YES') ? "checked" : "" ?>>
                                                <label class="form-check-label" for="ECommerce">E-Commerce</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card card-body mt-4">
                                        <h5 class="subheadings">Category</h5>
                                        <div class="mb-3 mt-3">
                                            <label for="product_category" class="form-label">Product Category</label>
                                            <select name="UpdateProductCategory" id="product_category" class="form-select" required>
                                                <option hidden selected  value="<?= $FetchResults['catId']; ?>"><?= $FetchResults['categoryName']; ?></option>
                                                <?php
                                                $findcategories = mysqli_query($con, "SELECT catId,categoryName FROM category_master");
                                                foreach ($findcategories as $categoryResults) {
                                                    echo '<option value="' . $categoryResults["catId"] . '">' . $categoryResults["categoryName"] . '</option>';
                                                }
                                                ?>
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
                                                    <input class="form-check-input" type="radio" name="UpdateProductBranch" value="<?php echo $branchResults['brId']; ?>" id="<?php echo $branchResults['branchName']; ?>"  <?php echo ($FetchResults['brId'] == $branchResults['brId']) ? "checked" : "" ?>   required>
                                                    <label class="form-check-label" for="<?php echo $branchResults['branchName']; ?>"> <?php echo $branchResults['branchName']; ?></label>
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
                                            <label for="product_name" class="form-label">Product Name</label>
                                            <input type="text" class="form-control" name="UpdateProductName" id="product_name" value="<?= $FetchResults['productName']; ?>" required>
                                        </div>
                                        <div class="mb-2">
                                            <label for="product_mini" class="form-label">Mini Description</label>
                                            <input type="text" class="form-control" name="UpdateProductMini" id="product_mini" value="<?= $FetchResults['productMini']; ?>" required>
                                        </div>
                                        <div class="mb-2">
                                            <label for="product_desc" class="form-label">Description</label>
                                            <textarea name="UpdateProductDescription" id="product_desc" cols="30" rows="10"><?= $FetchResults['productDesc']; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>

            </main>

        <?php

        }

        ?>

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

        $('#product_desc').summernote({
            tabsize: 2,
            height: 200,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['view', ['fullscreen', 'codeview']]
            ]
        });


        $('#btnConfirm').click(function(){
            location.replace('./ProductMaster.php');
        });

        //reset form function
        $('.btn_reset').click(function() {
            $('#UpdateProduct')[0].reset();
        });


        //does not allow special and numbers
        $('#product_name,#product_mini').keypress(function() {
            return /[a-zA-Z0-9 _-]/i.test(event.key);
        });

        //only allow numbers
        $('#product_price').keypress(function() {
            return /[0-9]/i.test(event.key);
        });




        /* Update master Start */
        $(function() {

            let validator = $('#UpdateProduct').jbvalidator({
                //language: 'dist/lang/en.json',
                successClass: false,
                html5BrowserDefault: true
            });

            validator.validator.custom = function(el, event) {
                if ($(el).is('#product_name') && $(el).val().match(/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/)) {
                    return 'Only allowed alphabets,numbers,- & _';
                } else if ($(el).is('#product_name,#product_mini') && $(el).val().trim().length == 0) {
                    return 'Cannot be empty';
                }
            }

            $(document).on('submit', '#UpdateProduct', (function(e) {
                e.preventDefault();
                var ProductUpdateData = new FormData(this);
                console.log(ProductUpdateData);
                $.ajax({
                    type: "POST",
                    url: "MasterOperations.php",
                    data: ProductUpdateData,
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
                            if (response.UpdateProduct == "0") {
                                $('#ResponseImage').html('<img src="./warning.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                $('#ResponseText').text("Product With this Name Already Exists");
                                $('#confirmModal').modal('show');
                            } else if (response.UpdateProduct == "1") {
                                $('#ResponseImage').html('<img src="./success.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                $('#ResponseText').text("Successfully Updated Product");
                                $('#btnConfirm').show();
                                $('#btnClose').hide();
                                $('#confirmModal').modal('show');
                                $('#AddProduct')[0].reset();

                            } else if (response.UpdateProduct == "2") {
                                //$('#TableModal').modal('hide');
                                $('#ResponseImage').html('<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                $('#ResponseText').text("Failed Updating Product");
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