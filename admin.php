<!DOCTYPE html>
<html lang="en">

<?php
$scriptList = array('js/jquery-3.3.1.min.js', 'js/admin.js');
$currentPage = basename($_SERVER['PHP_SELF']);
include('hidden/header.php');
?>

<!--Main-->
<main>
    <div id="wrapper">

        <div class="row">
            <div class="col-12" id="admin-header">
                <h1>Hotel Administration</h1>
            </div>
        </div>
        <div class="row">
            <!--Add button-->
            <div class="col-4 admin-forms">
                <h3>Add Room</h3>
                <form action="admin/addRoom.php">
                    <input class="submit" type="submit" value="Add Room">
                </form>
            </div>
            <!--Edit button-->
            <div class="col-4 admin-forms">
                <h3>Edit Room</h3>
                <form action="admin/editRoom.php">
                    <input class="submit" type="submit" value="Edit Room">
                </form>
            </div>
            <!--Delete button-->
            <div class="col-4 admin-forms">
                <h3>Delete Room</h3>
                <form action="admin/deleteRoom.php">
                    <input class="submit" type="submit" value="Delete Room">
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-12" id="h-no-bookings">
                <table id="bookings">
                    <caption>Booking Summary</caption>
                    <thead>
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Name</th>
                        <th scope="col">In</th>
                        <th scope="col">Out</th>
                        <th scope="col">Cx.</th>
                    </tr>
                    </thead>
                    <tbody id="admin-table">
                    </tbody>
                </table>
            </div>
            <!--SUCCESS MODAL-->
            <div id="success-modal" class="modal">
                <div class="modal-content">
                    <div class="row">
                        <div class="col-12">
                            <div id="success-message"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!--Footer-->
<?php include("hidden/footer.php"); ?>
</body>
</html>