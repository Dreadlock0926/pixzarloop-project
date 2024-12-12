<?php

// function that connects to the database
function startConnection($connection, $sql, $message, $isListed = false)
{
    if ($connection->query($sql) === TRUE) {
        echo $message;
    } else {
        echo "Error found: " . $connection->error;
    }

    if ($isListed) {
        $result = $connection->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo sprintf("ID: %d - Name: %s - Email: %s - Role: %s<br>", $row['id'], $row['name'], $row['email'], $row['role']);
            }
        } else {
            echo "No users found";
        }
    }

}

// functions for operations on users
function add_user($name, $email, $role, $connection)
{
    $sql = "CALL add_user('$name', '$email', '$role')";
    startConnection($connection, $sql, 'User added');
}

function delete_user($id, $connection)
{
    $sql = "CALL delete_user($id)";
    startConnection($connection, $sql, 'User deleted');
}

function update_user($name, $email, $role, $id, $connection)
{
    $sql = "CALL update_user('$name', '$email', '$role', $id)";
    startConnection($connection, $sql, 'User updated');
}

function list_users($connection)
{
    $sql = "CALL list_users()";
    startConnection($connection, $sql, 'Users listed', true);
}

// function to manage user operations
function manageUser($user, $operation, $connection)
{

    switch ($operation) {

        case 'add':
            add_user($user['name'], $user['email'], $user['role'], $connection);
            break;

        case 'delete':
            delete_user($user['id'], $connection);
            break;

        case 'update':
            update_user($user['name'], $user['email'], $user['role'], $user['id'], $connection);
            break;

        case 'list':
            list_users($connection);
            break;

        default:
            echo "Invalid operation";
            return;

    }
}

// Test case
$connection = new mysqli("localhost", "username", "password", "database");
$user = array(
    'id' => 1,
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'role' => 'admin'
);

manageUser($user, 'add', $connection);

?>

