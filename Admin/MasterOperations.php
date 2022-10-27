<?php session_start(); ?>
<?php

include '../MAIN/Dbconfig.php';
include './CommonFunctions.php';


$user_id = $_SESSION['custid'];
$dateToday = date('Y-m-d h:i:s');
$dayToday = date('Ymd');

$ExtensionArray = array('jpg', 'png', 'webp', 'jpeg');
////////////////////////Category///////////////////////////////////


    //Add Category
    if (isset($_POST['CategoryName'])) {
        mysqli_autocommit($con, FALSE);
        $CategoryName = SanitizeInput($_POST['CategoryName']);
        $CategoryImage = $_FILES['CategoryImage']['name'];
        $Categoryextension = pathinfo($CategoryImage, PATHINFO_EXTENSION);
        $Categorytempimage = $_FILES['CategoryImage']['tmp_name'];


        $check_Add_Category_query = mysqli_query($con, "SELECT * FROM category_master WHERE categoryName = '$CategoryName'");
        if (mysqli_num_rows($check_Add_Category_query) > 0) {
            echo json_encode(array('addCategory' => '0'));
        } else {

            if (!empty($_FILES['CategoryImage']['name'])) {

                if (in_array($Categoryextension, $ExtensionArray)) {

                    $find_max_category = mysqli_query($con, "SELECT MAX(catId) FROM category_master");
                    foreach ($find_max_category as $max_category_id) {
                        $categoryMaxId = $max_category_id['MAX(catId)'] + 1;
                    }

                    $final_categoryimage_name = $categoryMaxId . "." . $Categoryextension;
                    $CategoryFolder = "../CATEGORY/" . $final_categoryimage_name;

                    if (move_uploaded_file($Categorytempimage, $CategoryFolder)) {

                        $add_category_query =  mysqli_query($con, "INSERT INTO category_master (catId,categoryName,categoryImage,CreatedBy,CreatedDate) 
                                    VALUES ('$categoryMaxId','$CategoryName','$final_categoryimage_name','$user_id','$dateToday')");
                        if ($add_category_query) {
                            mysqli_commit($con);
                            echo json_encode(array('addCategory' => '1'));
                        } else {
                            mysqli_rollback($con);
                            echo json_encode(array('addCategory' => '2'));
                        }
                    } else {
                        mysqli_rollback($con);
                        echo json_encode(array('addCategory' => '2'));
                    }
                } else {
                    mysqli_rollback($con);
                    echo json_encode(array('addCategory' => '3'));
                }
            }
        }
    }



    //delete Category
    if (isset($_POST['delCategory'])) {

        mysqli_autocommit($con, FALSE);
        $DeleteCategory = SanitizeInt($_POST['delCategory']);

        $check_Category_del_query = mysqli_query($con, "SELECT * FROM product_master WHERE catId = '$DeleteCategory'");
        if (mysqli_num_rows($check_Category_del_query) > 0) {
            echo json_encode(array('delCategory' => '0'));
        } else {

            $DelCategoryImage_query = mysqli_query($con, "SELECT categoryImage FROM category_master WHERE catId = '$DeleteCategory'");
            foreach ($DelCategoryImage_query as $delCategoryImages) {
                $delCategoryImage = $delCategoryImages['categoryImage'];
                $delCategoryImagePath = "../CATEGORY/" . $delCategoryImages['categoryImage'];
            }

            if ($delCategoryImage != null) {
                if (unlink($delCategoryImagePath)) {
                    $delete_Category_With_image_query =  mysqli_query($con, "DELETE FROM category_master WHERE catId = '$DeleteCategory'");
                    if ($delete_Category_With_image_query) {
                        mysqli_commit($con);
                        echo json_encode(array('delCategory' => '1'));
                    } else {
                        mysqli_rollback($con);
                        echo json_encode(array('delCategory' => '2'));
                    }
                } else {
                    echo json_encode(array('delCategory' => 2));
                }
            } else {
                $delete_Category_Without_image_query =  mysqli_query($con, "DELETE FROM category_master WHERE catId = '$DeleteCategory'");
                if ($delete_Category_Without_image_query) {
                    mysqli_commit($con);
                    echo json_encode(array('delCategory' => '1'));
                } else {
                    mysqli_rollback($con);
                    echo json_encode(array('delCategory' => '2'));
                }
            }
        }
    }



    //Edit Category
    if (isset($_POST['editCategory'])) {
        $category_edit_id = SanitizeInt($_POST['editCategory']);

        $edit_category = mysqli_query($con, "SELECT * FROM category_master WHERE catId = '$category_edit_id'");
        if ($edit_category) {
            foreach ($edit_category as $edit_category_result) {
                $category_name = $edit_category_result['categoryName'];
                echo json_encode(array('CategoryName' => $category_name));
            }
        } else {
            echo json_encode(array('CategoryValue' => 'error'));
        }
    }



    //Update Category
    if (isset($_POST['UpdateCategoryId'])) {
        mysqli_autocommit($con, FALSE);
        $updateCategoryId = SanitizeInt($_POST['UpdateCategoryId']);
        $UpdateCategoryName = SanitizeInput($_POST['UpdateCategoryName']);
        $updateCategoryImage = $_FILES['UpdateCategoryImage']['name'];
        $updateCategoryextension = pathinfo($updateCategoryImage, PATHINFO_EXTENSION);
        $updateCategorytempimage = $_FILES['UpdateCategoryImage']['tmp_name'];
        $updatefinal_Categoryimage_name = $updateCategoryId . "." . $updateCategoryextension;
        $updateCategoryfolder = "../CATEGORY/" . $updatefinal_Categoryimage_name;


        $check_category_update_query = mysqli_query($con, "SELECT * FROM category_master WHERE categoryName = '$UpdateCategoryName'  AND catId <> '$updateCategoryId'");
        if (mysqli_num_rows($check_category_update_query) > 0) {
            echo json_encode(array('UpdateCategory' => '0'));
        } else {

            if (!empty($_FILES['UpdateCategoryImage']['name'])) {
                $CategoryFetch_query = mysqli_query($con, "SELECT categoryImage FROM category_master WHERE catId = '$updateCategoryId'");
                foreach ($CategoryFetch_query as $Category_result) {
                    $CategoryUpdateimageValue = $Category_result['categoryImage'];
                    $CategoryUpdateimagePath = "../CATEGORY/" . $Category_result['categoryImage'];
                }
                if ($CategoryUpdateimageValue != null) {
                    if (unlink($CategoryUpdateimagePath)) {

                        if (move_uploaded_file($updateCategorytempimage, $updateCategoryfolder)) {
                            $Category_update_query = mysqli_query($con, "UPDATE category_master SET categoryName = '$UpdateCategoryName', categoryImage = '$updatefinal_Categoryimage_name', UpdatedBy = '$user_id' , UpdatedDate = '$dateToday' WHERE catId = '$updateCategoryId'");
                            if ($Category_update_query) {
                                echo json_encode(array('UpdateCategory' => 1));
                            } else {
                                echo json_encode(array('UpdateCategory' => 2));
                            }
                        }
                    } else {
                        echo json_encode(array('UpdateCategory' => 3));
                    }
                } else {
                    if (move_uploaded_file($updateCategorytempimage, $updateCategoryfolder)) {
                        $Category_update_query = mysqli_query($con, "UPDATE category_master SET categoryName = '$UpdateCategoryName', categoryImage = '$updatefinal_Categoryimage_name', UpdatedBy = '$user_id' , UpdatedDate = '$dateToday' WHERE catId = '$updateCategoryId'");
                        if ($Category_update_query) {
                            echo json_encode(array('UpdateCategory' => 1));
                        } else {
                            echo json_encode(array('UpdateCategory' => 2));
                        }
                    }
                }
            } else {
                $update_category_query =  mysqli_query($con, "UPDATE category_master SET categoryName = '$UpdateCategoryName', UpdatedBy = '$user_id' , UpdatedDate = '$dateToday' WHERE catId = '$updateCategoryId'");

                if ($update_category_query) {
                    mysqli_commit($con);
                    echo json_encode(array('UpdateCategory' => '1'));
                } else {
                    mysqli_rollback($con);
                    echo json_encode(array('UpdateCategory' => '2'));
                }
            }
        }
    }


////////////////////////Category///////////////////////////////////


////////////////////////Branch///////////////////////////////////


    //Add Branch
    if (isset($_POST['BranchName'])) {
        mysqli_autocommit($con, FALSE);
        $BranchName = SanitizeInput($_POST['BranchName']);

        $check_Add_Branch_query = mysqli_query($con, "SELECT * FROM branch_master WHERE branchName = '$BranchName'");
        if (mysqli_num_rows($check_Add_Branch_query) > 0) {
            echo json_encode(array('addBranch' => '0'));
        } else {

            $find_max_branch = mysqli_query($con, "SELECT MAX(brId) FROM branch_master");
            foreach ($find_max_branch as $max_branch_id) {
                $branchMaxId = $max_branch_id['MAX(brId)'] + 1;
            }

            $add_branch_query =  mysqli_query($con, "INSERT INTO branch_master (brId,branchName,CreatedBy,CreatedDate) 
                            VALUES ('$branchMaxId','$BranchName','$user_id','$dateToday')");
            if ($add_branch_query) {
                mysqli_commit($con);
                echo json_encode(array('addBranch' => '1'));
            } else {
                mysqli_rollback($con);
                echo json_encode(array('addBranch' => '2'));
            }
        }
    }




    //Edit Branch
    if (isset($_POST['editBranch'])) {
        $branch_edit_id = SanitizeInt($_POST['editBranch']);

        $edit_branch = mysqli_query($con, "SELECT * FROM branch_master WHERE brId = '$branch_edit_id'");
        if ($edit_branch) {
            foreach ($edit_branch as $edit_branch_result) {
                $branch_name = $edit_branch_result['branchName'];
                echo json_encode(array('BranchName' => $branch_name));
            }
        } else {
            echo json_encode(array('BranchValue' => 'error'));
        }
    }




    //Update Branch
    if (isset($_POST['UpdateBranchId'])) {
        mysqli_autocommit($con, FALSE);
        $updateBranchId = SanitizeInt($_POST['UpdateBranchId']);
        $UpdateBranchName = SanitizeInput($_POST['UpdateBranchName']);

        $check_branch_update_query = mysqli_query($con, "SELECT * FROM Branch_master WHERE branchName = '$UpdateBranchName'  AND brId <> '$updateBranchId'");
        if (mysqli_num_rows($check_branch_update_query) > 0) {
            echo json_encode(array('UpdateBranch' => '0'));
        } else {

            $update_branch_query =  mysqli_query($con, "UPDATE branch_master SET branchName = '$UpdateBranchName', UpdatedBy = '$user_id' , UpdatedDate = '$dateToday' WHERE brId = '$updateBranchId'");

            if ($update_branch_query) {
                mysqli_commit($con);
                echo json_encode(array('UpdateBranch' => '1'));
            } else {
                mysqli_rollback($con);
                echo json_encode(array('UpdateBranch' => '2'));
            }
        }
    }




    //delete Branch
    if (isset($_POST['delBranch'])) {

        mysqli_autocommit($con, FALSE);
        $DeleteBranch = SanitizeInt($_POST['delBranch']);

        $check_Branch_del_query = mysqli_query($con, "SELECT * FROM table_master WHERE brId = '$DeleteBranch'");
        $check_Branch_del_order_query = mysqli_query($con, "SELECT orderBranch FROM order_main WHERE orderBranch = '$DeleteBranch'");
        if (mysqli_num_rows($check_Branch_del_query) > 0) {
            echo json_encode(array('delBranch' => '0'));
        } else if (mysqli_num_rows($check_Branch_del_order_query) > 0) {
            echo json_encode(array('delBranch' => '0'));
        } else {
            $delete_Branch_query =  mysqli_query($con, "DELETE FROM branch_master WHERE brId = '$DeleteBranch'");
            if ($delete_Branch_query) {
                mysqli_commit($con);
                echo json_encode(array('delBranch' => '1'));
            } else {
                mysqli_rollback($con);
                echo json_encode(array('delBranch' => '2'));
            }
        }
    }



////////////////////////Branch///////////////////////////////////




///////////////////////Table////////////////////////////////////


    //Add Table
    if (isset($_POST['BranchId'])) {
        mysqli_autocommit($con, FALSE);
        $BranchId = SanitizeInt($_POST['BranchId']);
        $TableName = SanitizeInput($_POST['TableName']);

        $check_Add_Table_query = mysqli_query($con, "SELECT * FROM table_master WHERE tableName = '$TableName' AND brId = '$BranchId'");
        if (mysqli_num_rows($check_Add_Table_query) > 0) {
            echo json_encode(array('addTable' => '0'));
        } else {

            $find_max_table = mysqli_query($con, "SELECT MAX(tId) FROM table_master");
            foreach ($find_max_table as $max_table_id) {
                $tableMaxId = $max_table_id['MAX(tId)'] + 1;
            }

            $add_table_query =  mysqli_query($con, "INSERT INTO table_master (tId,brId,tableName,tableStatus,CreatedBy,CreatedDate) 
                            VALUES ('$tableMaxId','$BranchId','$TableName','EMPTY','$user_id','$dateToday')");
            if ($add_table_query) {
                mysqli_commit($con);
                echo json_encode(array('addTable' => '1'));
            } else {
                mysqli_rollback($con);
                echo json_encode(array('addTable' => '2'));
            }
        }
    }




    //Edit Table 
    if (isset($_POST['editTable'])) {

        $table_edit_id = SanitizeInt($_POST['editTable']);

        $edit_table = mysqli_query($con, "SELECT * FROM table_master WHERE tId = '$table_edit_id'");
        if ($edit_table) {
            foreach ($edit_table as $edit_table_result) {
                $table_name = $edit_table_result['tableName'];
                $edit_branch_id = $edit_table_result['brId'];
                echo json_encode(array('TableName' => $table_name, 'TableBranchId' => $edit_branch_id));
            }
        } else {
            echo json_encode(array('TableValue' => 'error'));
        }
    }




    //Update Table
    if (isset($_POST['UpdateTableId'])) {
        mysqli_autocommit($con, FALSE);
        $UpdateTableId = SanitizeInt($_POST['UpdateTableId']);
        $UpdateTableBranch = SanitizeInt($_POST['UpdateTableBranch']);
        $UpdateTableName = SanitizeInput($_POST['UpdateTableName']);

        $check_table_update_query = mysqli_query($con, "SELECT * FROM table_master WHERE tableName = '$UpdateTableName' AND brId = '$UpdateTableBranch' AND tId <> '$UpdateTableId'");
        if (mysqli_num_rows($check_table_update_query) > 0) {
            echo json_encode(array('UpdateTable' => '0'));
        } else {

            $update_table_query =  mysqli_query($con, "UPDATE table_master SET tableName = '$UpdateTableName', brId = '$UpdateTableBranch', UpdatedBy = '$user_id' , UpdatedDate = '$dateToday' WHERE tId = '$UpdateTableId'");

            if ($update_table_query) {
                mysqli_commit($con);
                echo json_encode(array('UpdateTable' => '1'));
            } else {
                mysqli_rollback($con);
                echo json_encode(array('UpdateTable' => '2'));
            }
        }
    }





    //delete Table
    if (isset($_POST['delTable'])) {

        mysqli_autocommit($con, FALSE);
        $DeleteTable = SanitizeInt($_POST['delTable']);

        $check_Table_del_query = mysqli_query($con, "SELECT * FROM order_main WHERE orderTable = '$DeleteTable'");
        if (mysqli_num_rows($check_Table_del_query) > 0) {
            echo json_encode(array('delTable' => '0'));
        } else {

            $delete_Table_query =  mysqli_query($con, "DELETE FROM table_master WHERE tId = '$DeleteTable'");
            if ($delete_Table_query) {
                mysqli_commit($con);
                echo json_encode(array('delTable' => '1'));
            } else {
                mysqli_rollback($con);
                echo json_encode(array('delTable' => '2'));
            }
        }
    }





///////////////////////Table////////////////////////////////////


////////////////////////Product///////////////////////////////////



    //Add Product
    if (isset($_POST['ProductName'])) {
        mysqli_autocommit($con, FALSE);

        $ProductName = SanitizeInput($_POST['ProductName']);
        $ProductPrice = SanitizeInt($_POST['ProductPrice']);
        $ProductMini = SanitizeInput($_POST['ProductMini']);
        $ProductDesc = SanitizeInput($_POST['ProductDescription']);
        $ProductBranch = SanitizeInt($_POST['ProductBranch']);
        $ProductCategory = SanitizeInt($_POST['ProductCategory']);
        if (isset($_POST['ProductDineIn'])) {
            $ProductDine = 'YES';
        } else {
            $ProductDine = 'NO';
        }
        if (isset($_POST['ProductEcommerce'])) {
            $ProductEcomm = 'YES';
        } else {
            $ProductEcomm = 'NO';
        }

        $check_Add_Product_query = mysqli_query($con, "SELECT * FROM product_master WHERE productName = '$ProductName' AND brId = '$ProductBranch' AND catId = '$ProductCategory'");
        if (mysqli_num_rows($check_Add_Product_query) > 0) {
            echo json_encode(array('addProduct' => '0'));
        } else {

            $find_max_product = mysqli_query($con, "SELECT MAX(prId) FROM product_master");
            foreach ($find_max_product as $max_product_id) {
                $productMaxId = $max_product_id['MAX(prId)'] + 1;
            }

            $add_product_query =  mysqli_query($con, "INSERT INTO `product_master`(`prId`, `productName`, `productMini`, `productDesc`, `catId`, `brId`, `dineIn`, `ecom`, `stock`,`productPrice`,`createdBy`, `createdDate`) VALUES ('$productMaxId','$ProductName','$ProductMini','$ProductDesc','$ProductCategory','$ProductBranch','$ProductDine','$ProductEcomm','IN','$ProductPrice','$user_id','$dateToday')");
            if ($add_product_query) {
                mysqli_commit($con);
                echo json_encode(array('addProduct' => '1'));
            } else {
                mysqli_rollback($con);
                echo json_encode(array('addProduct' => '2'));
            }
        }
    }




    //Update Product
    if (isset($_POST['UpdateProductId'])) {
        mysqli_autocommit($con, FALSE);

        $UpdateProductId = SanitizeInt($_POST['UpdateProductId']);
        $UpdateProductName = SanitizeInput($_POST['UpdateProductName']);
        $UpdateProductPrice = SanitizeInt($_POST['UpdateProductPrice']);
        $UpdateProductMini = SanitizeInput($_POST['UpdateProductMini']);
        $UpdateProductDesc = SanitizeInput($_POST['UpdateProductDescription']);
        $UpdateProductBranch = SanitizeInt($_POST['UpdateProductBranch']);
        $UpdateProductCategory = SanitizeInt($_POST['UpdateProductCategory']);
        if (isset($_POST['UpdateProductDineIn'])) {
            $UpdateProductDine = 'YES';
        } else {
            $UpdateProductDine = 'NO';
        }
        if (isset($_POST['UpdateProductEcommerce'])) {
            $UpdateProductEcomm = 'YES';
        } else {
            $UpdateProductEcomm = 'NO';
        }

        $check_product_update_query = mysqli_query($con, "SELECT * FROM product_master WHERE productName = '$UpdateProductName' AND prId <> '$UpdateProductId'");
        if (mysqli_num_rows($check_product_update_query) > 0) {
            echo json_encode(array('UpdateProduct' => '0'));
        } else {

            $update_product_query =  mysqli_query($con, "UPDATE product_master SET productName = '$UpdateProductName', productMini = '$UpdateProductMini',productDesc = '$UpdateProductDesc', catId = '$UpdateProductCategory', brId = '$UpdateProductBranch', dineIn = '$UpdateProductDine', ecom = '$UpdateProductEcomm', stock = 'IN', productPrice = '$UpdateProductPrice' , UpdatedBy = '$user_id' , UpdatedDate = '$dateToday' WHERE prId = '$UpdateProductId'");

            if ($update_product_query) {
                mysqli_commit($con);
                echo json_encode(array('UpdateProduct' => '1'));
            } else {
                mysqli_rollback($con);
                echo json_encode(array('UpdateProduct' => '2'));
            }
        }
    }

    //delete Product
    if (isset($_POST['delProduct'])) {

        mysqli_autocommit($con, FALSE);
        $DeleteProduct = SanitizeInt($_POST['delProduct']);

        $check_Product_del_query = mysqli_query($con, "SELECT * FROM order_sub WHERE product_id = '$DeleteProduct'");
        if (mysqli_num_rows($check_Product_del_query) > 0) {
            echo json_encode(array('delProduct' => '0'));
        } else {

            $delete_Product_query =  mysqli_query($con, "DELETE FROM product_master WHERE prId = '$DeleteProduct'");
            if ($delete_Product_query) {
                mysqli_commit($con);
                echo json_encode(array('delProduct' => '1'));
            } else {
                mysqli_rollback($con);
                echo json_encode(array('delProduct' => '2'));
            }
        }
    }



////////////////////////Product///////////////////////////////////




////////////////////////User///////////////////////////////////



    //Add Employee
    if (isset($_POST['FullName'])) {
        mysqli_autocommit($con, FALSE);
        $EmpName = SanitizeInput($_POST['FullName']);
        $EmpUserName = SanitizeInt($_POST['UserName']);
        $EmpPhone = SanitizeInt($_POST['UserPhone']);
        $EmpPass = SanitizeInput($_POST['UserPassword']);
        $EmpAddr = SanitizeInput($_POST['UserAddress']);
        $EmpEmail = SanitizeInput($_POST['UserEmail']);
        $EmpBranch = SanitizeInt($_POST['UserBranch']);
        $EmpRole = SanitizeInput($_POST['UserRole']);


        $check_add_employee_query = mysqli_query($con, "SELECT * FROM employee_master WHERE empPhone = '$EmpPhone'");
        if (mysqli_num_rows($check_add_employee_query) > 0) {
            echo json_encode(array('addUser' => '0'));
        } else {

            $add_employee_max_query = mysqli_query($con, "SELECT MAX(empId) FROM employee_master");
            foreach ($add_employee_max_query as $add_employee_max_result) {
                $add_employee_max = $add_employee_max_result['MAX(empId)'] + 1;
            }

            $add_employee_query =  mysqli_query($con, "INSERT INTO employee_master (empId,empName,empPhone,empAddress,empEmail,empBranch,empRole,createdBy,createdDate) 
                    VALUES ('$add_employee_max','$EmpName','$EmpPhone','$EmpAddr','$EmpEmail','$EmpBranch','$EmpRole','$user_id','$dateToday')");

            if ($add_employee_query) {

                $find_max_user_employee = mysqli_query($con, "SELECT MAX(users_id) FROM user_table");
                foreach ($find_max_user_employee as $max_user_employee) {
                    $MaxEmplUserId = $max_user_employee['MAX(users_id)'] + 1;
                }

                $add_Empl_user_query =  mysqli_query($con, "INSERT INTO user_table (users_id,userName,userPhone,userPassword,userRole,empId,createdBy,createdDate) 
                                VALUES ('$MaxEmplUserId','$EmpName','$EmpPhone','$EmpPass','$EmpRole','$add_employee_max','$user_id','$dateToday')");

                if ($add_Empl_user_query) {
                    mysqli_commit($con);
                    echo json_encode(array('addUser' => '1'));
                } else {
                    mysqli_rollback($con);
                    echo json_encode(array('addUser' => '2'));
                }
            } else {
                mysqli_rollback($con);
                echo json_encode(array('addUser' => '2'));
            }
        }
    }



    //Update Employee
    if (isset($_POST['UpdateEmployeeId'])) {


        $UpdateEmpId = SanitizeInt($_POST['UpdateEmployeeId']);
        $UpdateEmpName = SanitizeInput($_POST['UpdateFullName']);
        $UpdateEmpUserName = SanitizeInt($_POST['UpdateUserName']);
        $UpdateEmpPhone = SanitizeInt($_POST['UpdateUserPhone']);
        $UpdateEmpPass = SanitizeInput($_POST['UpdateUserPassword']);
        $UpdateEmpAddr = SanitizeInput($_POST['UpdateUserAddress']);
        $UpdateEmpEmail = SanitizeInput($_POST['UpdateUserEmail']);
        $UpdateEmpBranch = SanitizeInt($_POST['UpdateUserBranch']);
        $UpdateEmpRole = SanitizeInput($_POST['UpdateUserRole']);


        mysqli_autocommit($con, FALSE);
        $check_employee_update_query = mysqli_query($con, "SELECT * FROM employee_master WHERE empPhone = '$UpdateEmpPhone' AND empId <> '$UpdateEmpId'");
        if (mysqli_num_rows($check_employee_update_query) > 0) {
            echo json_encode(array('EmployeeUpdate' => '0'));
        } else {

            $update_employee_query =  mysqli_query($con, "UPDATE employee_master SET empName = '$UpdateEmpName', empPhone = '$UpdateEmpPhone', empAddress = '$UpdateEmpAddr', 
                    empEmail = '$UpdateEmpEmail', empRole = '$UpdateEmpRole', empBranch = '$UpdateEmpBranch', updatedBy = '$user_id', updatedDate = '$dateToday' WHERE empId = '$UpdateEmpId'");

            if ($update_employee_query) {
                $update_user_query = mysqli_query($con, "UPDATE user_table SET userName = '$UpdateEmpName', userPhone ='$UpdateEmpPhone', userPassword = '$UpdateEmpPass', userRole ='$UpdateEmpRole', updatedBy = '$user_id', updatedDate = '$dateToday' WHERE empId = '$UpdateEmpId'");

                if ($update_user_query) {
                    mysqli_commit($con);
                    echo json_encode(array('EmployeeUpdate' => '1'));
                } else {
                    mysqli_rollback($con);
                    echo json_encode(array('EmployeeUpdate' => '2'));
                }
            } else {
                mysqli_rollback($con);
                echo json_encode(array('EmployeeUpdate' => '2'));
            }
        }
    }


    //Delete Employee
    if (isset($_POST['delUser'])) {

        $DelEmpId = SanitizeInt($_POST['delUser']);

        mysqli_autocommit($con, FALSE);

        $check_Employee_delete_query = mysqli_query($con, "SELECT * FROM order_main WHERE createdBy = '$DelEmpId'");
        if (mysqli_num_rows($check_Employee_delete_query) > 0) {
            echo json_encode(array('deleteUser' => '0'));
        } else {
            $delete_Employee_query =  mysqli_query($con, "DELETE FROM employee_master WHERE empId = '$DelEmpId'");

            if ($delete_Employee_query) {

                $DeleteFromUser = mysqli_query($con, "DELETE FROM user_table WHERE empId = '$DelEmpId'");
                if ($DeleteFromUser) {
                    mysqli_commit($con);
                    echo json_encode(array('deleteUser' => '1'));
                } else {
                    mysqli_rollback($con);
                    echo json_encode(array('deleteUser' => '2'));
                }
            } else {
                mysqli_rollback($con);
                echo json_encode(array('deleteUser' => '2'));
            }
        }
    }


////////////////////////User///////////////////////////////////