<div class="offcanvas offcanvas-start" tabindex="-1" id="SidebarMenu" aria-labelledby="offcanvasExampleLabel">

    <div class="offcanvas-body p-0">
        <div class="py-3">
            <h5 class="menu_heading">THE MUFFIN HOUSE</h5>
        </div>

        <div>
            <ul class="list-unstyled menuList">
                <li class=" <?php echo ($_SESSION['custtype'] == 'SUPERADMIN') ? "d-none" : "" ?> ">
                    <a href="./CategoryMaster.php" class="mainmenus <?php echo ($pageTitle == 'CategoryMaster') ? 'active' : ""; ?>">
                        <i class="material-icons">category</i>
                        <span>Category Master</span>
                    </a>
                </li>
                <li class=" <?php echo ($_SESSION['custtype'] == 'SUPERADMIN') ? "d-none" : "" ?> ">
                    <a href="./BranchMaster.php" class="mainmenus <?php echo ($pageTitle == 'BranchMaster') ? 'active' : ""; ?>">
                        <i class="material-icons">room</i>
                        <span>Branch Master</span>
                    </a>
                </li>
                <li class=" <?php echo ($_SESSION['custtype'] == 'SUPERADMIN') ? "d-none" : "" ?> ">
                    <a href="./TableMaster.php" class="mainmenus <?php echo ($pageTitle == 'TableMaster') ? 'active' : ""; ?>">
                        <i class="material-icons">table_bar</i>

                        <span>Table Master</span>
                    </a>
                </li>


                <li class=" <?php echo ($_SESSION['custtype'] == 'SUPERADMIN') ? "d-none" : "" ?> ">
                    <a class="mainmenus" data-bs-toggle="collapse" href="#product" role="button" aria-expanded="false">
                        <i class="material-icons">cake</i>
                        <span>Product Master</span> <span class="ms-5 dropdown-toggle"></span>
                    </a>
                    <ul class="list-unstyled submenu collapse" id="product">
                        <li class=" <?php echo ($_SESSION['custtype'] == 'SUPERADMIN') ? "d-none" : "" ?> ">
                            <a href="./ProductMaster.php" class="<?php echo ($pageTitle == 'AddProduct') ? 'active' : ""; ?>">
                                <span>Add Product</span>
                            </a>
                        </li>
                        <li class=" <?php echo ($_SESSION['custtype'] == 'SUPERADMIN') ? "d-none" : "" ?> ">
                            <a href="./UserMaster.php" class="<?php echo ($pageTitle == 'ProductMaster') ? 'active' : ""; ?>">
                                <span>View Products</span>
                            </a>
                        </li>
                    </ul>

                </li>


                <li class=" <?php echo ($_SESSION['custtype'] == 'SUPERADMIN') ? "d-none" : "" ?> ">
                    <a class="mainmenus" data-bs-toggle="collapse" href="#user" role="button" aria-expanded="false">
                        <i class="material-icons">person_outline</i>
                        <span>User Master</span> <span class="ms-5 dropdown-toggle"></span>
                    </a>
                    <ul class="list-unstyled submenu collapse" id="user">
                        <li class=" <?php echo ($_SESSION['custtype'] == 'SUPERADMIN') ? "d-none" : "" ?> ">
                            <a href="./ProductMaster.php" class="<?php echo ($pageTitle == 'AddUser') ? 'active' : ""; ?>">
                                <span>Add User</span>
                            </a>
                        </li>
                        <li class=" <?php echo ($_SESSION['custtype'] == 'SUPERADMIN') ? "d-none" : "" ?> ">
                            <a href="./UserMaster.php" class="<?php echo ($pageTitle == 'UserMaster') ? 'active' : ""; ?>">
                                <span>View Users</span>
                            </a>
                        </li>
                    </ul>

                </li>


            </ul>
        </div>
    </div>

</div>