<?php
require_once __DIR__ . "/../../../Model/adminModel.php";
$adminModel = new AdminModel();
?>
<!DOCTYPE html>
<html>

<head></head>

<body>
    <h1>Customer Information</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Update</th>
            <th>Delete</th>
        </tr>
        <?php
        $company = $adminModel->getCompanies();
        if ($company && mysqli_num_rows($company) > 0) {
            while ($companyRow = mysqli_fetch_assoc($company)) {
                echo "<tr>
                        <td>{$companyRow['userId']}</td>
                        <td>{$companyRow['name']}</td>
                        <td>{$companyRow['email']}</td>
                        <td><a href='/studern/View/Admin_View/ManageCustomer/updateuser.php?user_id={$companyRow['userId']}'>Update</a></td>
                        <td>
                            <form method='POST' action='/studern/Controller/admin/manageCompanies.php'>
                                <input type='hidden' name='userId' value='{$companyRow['userId']}'>
                                <input type='submit' name='delete' value='Delete'>
                            </form>
                        </td>
                      </tr>";
            }
        }

        ?>
    </table>
    <a href="/studern/View/Admin_View/adminhome.php">
        <button type="button" id="back-button">Back</button>
    </a>

    <a href="../../Logout.php">
        <button type="button" id="logout-button">Logout</button>
    </a>

</body>

</html>