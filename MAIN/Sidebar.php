<ul class="list-unstyled menuList">

    <li class=" <?php echo ($pageTitle == 'CategoryMaster') ? 'active' : ""; ?> <?php echo ($_SESSION['custtype'] == 'SUPERADMIN') ? "d-none" : "" ?> ">
        <a href="./CategoryMaster.php" class="mainmenus ">
            <i class="material-icons">category</i>
            <span>Category Master</span>
        </a>
    </li>


    <li class=" <?php echo ($pageTitle == 'BranchMaster') ? 'active' : ""; ?> <?php echo ($pageTitle == 'BranchMaster') ? 'active' : ""; ?> ">
        <a href="./BranchMaster.php" class="mainmenus ">
            <i class="material-icons">room</i>
            <span>Branch Master</span>
        </a>
    </li>


    <li class=" <?php echo ($pageTitle == 'TableMaster') ? 'active' : ""; ?> <?php echo ($_SESSION['custtype'] == 'SUPERADMIN') ? "d-none" : "" ?> ">
        <a href="./TableMaster.php" class="mainmenus ">
            <i class="material-icons">table_bar</i>
            <span>Table Master</span>
        </a>
    </li>


    <li class=" <?php echo ($pageTitle == 'AddProduct' || $pageTitle == 'ProductMaster') ? 'active' : ""; ?> <?php echo ($_SESSION['custtype'] == 'SUPERADMIN') ? "d-none" : "" ?> ">
        <a class="mainmenus" data-bs-toggle="collapse" href="#product" role="button" aria-expanded="false">
            <i class="material-icons">cake</i>
            <span>Product Master</span> <span class="ms-5 dropdown-toggle"></span>
        </a>
        <ul class="list-unstyled submenu collapse" id="product">
            <li class=" <?php echo ($pageTitle == 'AddProduct') ? 'active' : ""; ?> <?php echo ($_SESSION['custtype'] == 'SUPERADMIN') ? "d-none" : "" ?> ">
                <a href="./AddProduct.php" class="">
                    <span>Add Product</span>
                </a>
            </li>
            <li class=" <?php echo ($pageTitle == 'ProductMaster') ? 'active' : ""; ?> <?php echo ($_SESSION['custtype'] == 'SUPERADMIN') ? "d-none" : "" ?> ">
                <a href="./ProductMaster.php" class="">
                    <span>View Products</span>
                </a>
            </li>
        </ul>
    </li>


    <li class=" <?php echo ($pageTitle == 'AddUser' || $pageTitle == 'UserMaster') ? 'active' : ""; ?> <?php echo ($_SESSION['custtype'] == 'SUPERADMIN') ? "d-none" : "" ?> ">
        <a class="mainmenus" data-bs-toggle="collapse" href="#user" role="button" aria-expanded="false">
            <i class="material-icons">person_outline</i>
            <span>User Master</span> <span class="ms-5 dropdown-toggle"></span>
        </a>
        <ul class="list-unstyled submenu collapse" id="user">
            <li class=" <?php echo ($pageTitle == 'AddUser') ? 'active' : ""; ?> <?php echo ($_SESSION['custtype'] == 'SUPERADMIN') ? "d-none" : "" ?> ">
                <a href="./AddUser.php" class="">
                    <span>Add User</span>
                </a>
            </li>
            <li class=" <?php echo ($pageTitle == 'UserMaster') ? 'active' : ""; ?> <?php echo ($_SESSION['custtype'] == 'SUPERADMIN') ? "d-none" : "" ?> ">
                <a href="./UserMaster.php" class="">
                    <span>View Users</span>
                </a>
            </li>
        </ul>
    </li>


    <li class=" <?php echo ($pageTitle == 'DineInOrder') ? 'active' : ""; ?> <?php echo ($_SESSION['custtype'] == 'SUPERADMIN') ? "d-none" : "" ?> ">
        <a href="./DineInOrders.php" class="mainmenus">
            <i class="material-icons">restaurant</i>
            <span>DineIn Orders</span>
        </a>
    </li>

    <li class=" <?php echo ($pageTitle == 'DineInReport') ? 'active' : ""; ?> <?php echo ($_SESSION['custtype'] == 'SUPERADMIN') ? "d-none" : "" ?> ">
        <a href="./DineInReport.php" class="mainmenus">
            <i class="material-icons">assessment</i>
            <span>DineIn Report</span>
        </a>
    </li>

    

</ul>


<div class="LogButtonDiv">
    <a href="../signout.php" class="btn btn_logout"> <i class="material-icons me-2">power_settings_new</i> <span>Logout</span> </a>
</div>