<?php
session_start();
include("database.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="crud.css">
    <title>TEST</title>
</head>
<body>

<div class="container">
    <form class="row g-3" action="crud.php" method="POST">
        <div class="col-md-4">
            <label for="inputEmail4" class="form-label">First Name</label>
            <input type="text" name="firstname" class="form-control" id="inputEmail4" required>
        </div>

        <div class="col-md-4">
            <label for="inputPassword4" class="form-label">Last Name</label>
            <input type="text" name="lastname" class="form-control" id="inputPassword4" required>
        </div>

        <div class="col-4">
            <label for="inputAddress" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" id="inputAddress" required>
        </div>

        <div class="col-md-4">
            <label for="inputState" class="form-label">Gender</label>
            <select id="inputState" name="gender" class="form-select" required>
                <option selected>Male</option>
                <option>Female</option>
            </select>
        </div>

        <div class="col-md-4">
            <label for="inputCity" class="form-label">Birthdate</label>
            <input type="date" name="birth" class="form-control" id="inputCity" required>
        </div>

        <div class="col-md-4">
            <label for="inputZip" class="form-label">Address</label>
            <input type="text" name="address" class="form-control" id="inputZip" placeholder="123 Main St" required>
        </div>

        <div class="col-12">
            <input type="submit" class="btn btn-outline-primary float-end" value="Add" name="reg-submit">
        </div>
    </form>
</div>

<div class="info-table container">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Email</th>
                <th scope="col">Gender</th>
                <th scope="col">Birthdate</th>
                <th scope="col">Address</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $sql = "SELECT * FROM users";
        $statement = $con->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();

        if ($result) {
            foreach ($result as $row) {
                ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['first_name']; ?></td>
                    <td><?php echo $row['last_name']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['gender']; ?></td>
                    <td><?php echo $row['birthdate']; ?></td>
                    <td><?php echo $row['address']; ?></td>
                    <td>
                        <!-- Edit Button -->
                        <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['id']; ?>">Edit</button>
                        <form action="crud.php" method="POST" style="display:inline;" onsubmit="return confirmDelete();">
                            <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="btn btn-outline-danger" name="delete_btn">Delete</button>
                        </form>
                    </td>
                </tr>

                <!-- Edit Modal -->
                <div class="modal fade" id="editModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Edit Record</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="crud.php" method="POST">
                                    <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">First Name</label>
                                        <input type="text" name="firstname" class="form-control" value="<?php echo $row['first_name']; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="lastname" class="form-label">Last Name</label>
                                        <input type="text" name="lastname" class="form-control" value="<?php echo $row['last_name']; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control" value="<?php echo $row['email']; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="gender" class="form-label">Gender</label>
                                        <select name="gender" class="form-select" required>
                                            <option value="Male" <?php echo ($row['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                                            <option value="Female" <?php echo ($row['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="birth" class="form-label">Birthdate</label>
                                        <input type="date" name="birth" class="form-control" value="<?php echo $row['birthdate']; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" name="address" class="form-control" value="<?php echo $row['address']; ?>" required>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <input type="submit" class="btn btn-primary" name="update-submit" value="Update" style="background: #000; color: #ffffff; border-radius: 5px;">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

<script>
function confirmDelete() {
    return confirm("SURE NAGUD KA ANI!?");
}
</script>
</body>
</html>
