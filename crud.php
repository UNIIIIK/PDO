<?php

include("database.php");

//add query
if(isset($_POST['reg-submit']))
{
    $first = $_POST['firstname'];
    $last = $_POST['lastname'];
    $email = $_POST['email']; 
    $gender = $_POST['gender'];
    $birth = $_POST['birth'];
    $address = $_POST['address'];

    //if user and email already exist
    $query = "insert into users (first_name,last_name,email,gender,birthdate,address) VALUES (:first, :last, :email, :gender, :birth, :address)";
    $query_run = $con->prepare($query);

    $data = [
        ':first' => $first,
        ':last' => $last,
        ':email' => $email,
        ':gender' => $gender,
        ':birth' => $birth,
        ':address' => $address,
    ];
    $query_execute = $query_run->execute($data);

    if($query_execute)
    {
        $_SESSION['message'] = "Inserted Successfully";
        header('Location: index.php');
        die;
    }
        $_SESSION['message'] = "Not Inserted";
        header('Location: index.php');
        die;
    }

//Delete Query
if (isset($_POST['delete_btn'])) {
    $delete_id = $_POST['delete_id'];

    // Prepare the delete query
    $delete_query = "DELETE FROM users WHERE id = :id";
    $delete_statement = $con->prepare($delete_query);
    $delete_execute = $delete_statement->execute([':id' => $delete_id]);

    if ($delete_execute) {
        $_SESSION['message'] = "Record Deleted Successfully";
    } else {
        $_SESSION['message'] = "Failed to Delete Record";
    }

    header('Location: index.php');
    exit();
}

//update

if (isset($_POST['update-submit'])) {
    $id = $_POST['user_id']; // Ensure this is the correct hidden field for the ID
    $first = $_POST['firstname'];
    $last = $_POST['lastname'];
    $email = $_POST['email']; 
    $gender = $_POST['gender'];
    $birth = $_POST['birth'];
    $address = $_POST['address'];

    // Prepare the update query
    $query = "UPDATE users SET first_name = :first, last_name = :last, email = :email, gender = :gender, birthdate = :birth, address = :address WHERE id = :id";
    $query_run = $con->prepare($query);

    $data = [
        ':first' => $first,
        ':last' => $last,
        ':email' => $email,
        ':gender' => $gender,
        ':birth' => $birth,
        ':address' => $address,
        ':id' => $id,
    ];
    
    $query_execute = $query_run->execute($data);

    if ($query_execute) {
        $_SESSION['message'] = "Updated Successfully";
        header('Location: index.php');
        die;
    } else {
        $_SESSION['message'] = "Update Failed";
        header('Location: index.php');
        die;
    }
}