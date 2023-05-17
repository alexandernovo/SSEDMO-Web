<?php
// Database configuration
$host = "localhost";
$username = "root";
$password = "";
$database = "PDO";
// Create database connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

function save($table, $data)
{
    global $conn;
    $columns = implode(", ", array_keys($data));
    $placeholders = implode(", ", array_fill(0, count($data), '?'));
    $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
    $stmt = mysqli_prepare($conn, $sql);
    $stmt->bind_param(str_repeat("s", count($data)), ...array_values($data));
    if ($stmt->execute()) {
        $last_insert_id = mysqli_insert_id($conn);
        return $last_insert_id;
    } else {
        return false;
    }
}

//sample save('table_name',['column1' => 'value1', 'column2' => 'value2']);
//sample save in data  save('table_name',$data);

function update($table, $id, $data)
{
    global $conn;
    $id_column = array_keys($id)[0];
    $id_value = array_values($id)[0];
    $set = implode(", ", array_map(function ($column) {
        return "$column = ?";
    }, array_keys($data)));
    $sql = "UPDATE $table SET $set WHERE $id_column = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        return false;
    }
    $values = array_values($data);
    array_push($values, $id_value);
    $stmt->bind_param(str_repeat("s", count($data)) . "i", ...$values);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}


//sample update('users', ['id' => $id], ['username' => $username]);


function delete($table, $conditions)
{
    global $conn;
    $sql = "DELETE FROM $table WHERE ";
    $params = [];
    foreach ($conditions as $column => $value) {
        $sql .= "$column = ? AND ";
        $params[] = $value;
    }
    $sql = substr($sql, 0, -4);
    $stmt = mysqli_prepare($conn, $sql);
    $types = str_repeat("s", count($params));
    $stmt->bind_param($types, ...$params);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}
//sample delete('tablename', ['id' => $id]);

function find($table, $conditions)
{
    global $conn;
    $sql = "SELECT * FROM $table WHERE ";
    $params = [];
    foreach ($conditions as $column => $value) {
        $sql .= "$column = ? AND ";
        $params[] = $value;
    }
    $sql = substr($sql, 0, -4);
    $stmt = mysqli_prepare($conn, $sql);
    $types = str_repeat("s", count($params));
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}
function like($table, $columns)
{
    global $conn;
    $whereClauses = array();
    foreach ($columns as $column => $value) {
        $whereClauses[] = "$column LIKE '%" . mysqli_real_escape_string($conn, $value) . "%'";
    }
    $whereClause = implode(' OR ', $whereClauses);
    $query = "SELECT * FROM $table WHERE $whereClause";
    $result = mysqli_query($conn, $query);
    if ($result) {
        $results = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_free_result($result);
        return $results;
    }
}


// usage example: find('tablename', ['username' => $username]);
function findAll($table)
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM $table");
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

//sample findAll('table_name')

function find_where($table, $columns_and_values)
{
    global $conn;
    $sql = "SELECT * FROM $table WHERE ";
    $params = [];
    $types = "";
    $i = 0;
    foreach ($columns_and_values as $column => $value) {
        $sql .= "$column = ? ";
        $params[] = &$columns_and_values[$column];
        $types .= "s";
        if (++$i !== count($columns_and_values)) {
            $sql .= "AND ";
        }
    }
    $stmt = mysqli_prepare($conn, $sql);
    array_unshift($params, $types);
    call_user_func_array(array($stmt, "bind_param"), $params);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

//sample find_where('table_name', ['column'=>$username]);

function first($table, $columns_and_values)
{
    global $conn;
    $sql = "SELECT * FROM $table WHERE ";
    $params = [];
    $types = "";
    $i = 0;
    foreach ($columns_and_values as $column => $value) {
        $sql .= "$column = ? ";
        $params[] = &$columns_and_values[$column];
        $types .= "s";
        if (++$i !== count($columns_and_values)) {
            $sql .= "AND ";
        }
    }
    $sql .= "LIMIT 1";
    $stmt = mysqli_prepare($conn, $sql);
    array_unshift($params, $types);
    call_user_func_array(array($stmt, "bind_param"), $params);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}
//sample $first = first('users', ['username'=>$username]);  return the first value find
function whereNotIn($table, $exclude_columns)
{
    global $conn;
    $conditions = array();
    $values = array();
    $types = "";
    foreach ($exclude_columns as $column => $exclude_values) {
        $placeholders = implode(',', array_fill(0, count($exclude_values), '?'));
        $conditions[] = "$column NOT IN ($placeholders)";
        $values = array_merge($values, $exclude_values);
        $types .= str_repeat("s", count($exclude_values));
    }
    $sql = "SELECT * FROM $table WHERE " . implode(' AND ', $conditions);
    $stmt = mysqli_prepare($conn, $sql);
    array_unshift($values, $types);
    call_user_func_array(array($stmt, "bind_param"), makeValuesReferenced($values));
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

//sample $data = whereNotIn($table, 'column_name', ['value1', 'value2', 'value3']);
function makeValuesReferenced($arr)
{
    $refs = array();
    foreach ($arr as $key => $value)
        $refs[$key] = &$arr[$key];
    return $refs;
}

function joinTable($table, $joins, $conditions = [])
{
    global $conn;
    $query = "SELECT * FROM $table";
    foreach ($joins as $join) {
        $query .= " INNER JOIN $join[0] ON $join[1] = $join[2]";
    }
    if (!empty($conditions)) {
        $where_clauses = array();
        $params = array();
        foreach ($conditions as $column => $value) {
            $where_clauses[] = "$column = ?";
            $params[] = $value;
        }
        $query .= " WHERE " . implode(" AND ", $where_clauses);
        $stmt = mysqli_prepare($conn, $query);
        $types = str_repeat("s", count($params));
        $stmt->bind_param($types, ...$params);
    } else {
        $stmt = mysqli_prepare($conn, $query);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $rows = array();
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    return $rows;
}
function countResutlt($table, $conditions)
{
    global $conn;
    $query = "SELECT COUNT(*) FROM $table WHERE ";
    $where = array();
    foreach ($conditions as $field => $value) {
        $where[] = "$field = '$value'";
    }
    $query .= implode(' AND ', $where);
    // execute the query and return the count
    $result = mysqli_query($conn, $query);
    $count = mysqli_fetch_row($result)[0];
    return $count;
}

function lastResult($table, $idField, $conditions)
{
    global $conn;
    $query = "SELECT * FROM $table WHERE ";
    $where = array();
    foreach ($conditions as $field => $value) {
        $where[] = "$field = '$value'";
    }
    $query .= implode(' AND ', $where);
    $query .= " ORDER BY $idField DESC LIMIT 1"; // Use the provided id field
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row;
}

function joinTableWherein($table, $joins, $conditions = [])
{
    global $conn;
    $query = "SELECT * FROM $table";
    foreach ($joins as $join) {
        $query .= " INNER JOIN $join[0] ON $join[1] = $join[2]";
    }
    if (!empty($conditions)) {
        $where_clauses = array();
        $params = array();
        foreach ($conditions as $column => $value) {
            if (is_array($value)) {
                $in_values = implode(',', array_fill(0, count($value), '?'));
                $where_clauses[] = "$column IN ($in_values)";
                $params = array_merge($params, array_values($value));
            } else {
                $where_clauses[] = "$column = ?";
                $params[] = $value;
            }
        }
        $query .= " WHERE " . implode(" AND ", $where_clauses);
        $stmt = mysqli_prepare($conn, $query);
        $types = str_repeat("s", count($params));
        $stmt->bind_param($types, ...$params);
    } else {
        $stmt = mysqli_prepare($conn, $query);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $rows = array();
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    return $rows;
}

//sample $result = join("users", [["departments", "users.department_id", "departments.department_id"]], ["users.name" => "John Doe"]);
//$result = join("users", [["departments", "users.department_id", "departments.department_id"]]);