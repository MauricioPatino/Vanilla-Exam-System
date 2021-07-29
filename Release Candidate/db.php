<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

function fetchAssocStatement($stmt)
{
    if($stmt->num_rows>0)
    {
        $result = array();
        $md = $stmt->result_metadata();
        $params = array();
        while($field = $md->fetch_field()) {
            $params[] = &$result[$field->name];
        }
        call_user_func_array(array($stmt, 'bind_result'), $params);
        if($stmt->fetch())
            return $result;
    }

    return null;
}

$conn = mysqli_connect("127.0.0.1", "mp924", "Shaka.Juanes.1", "test");
//$conn = mysqli_connect("sql1.njit.edu", "emo26", "Gs5p3GpTcC!QhXr", "emo26");

if (!$conn) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
?>