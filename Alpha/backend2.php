<?php
    require 'db.php';
    $decode = file_get_contents('php://input');
    $data = json_decode($decode, true);

    // Input Data
    $question = $data['question'];
    $topic = $data['topic'];
    $difficulty = $data['difficulty'];
    $case = $data['case'];
    $functionName = $data['fName'];
    $constraints = $data['constraints'];


    $sql = "INSERT INTO questionBank 
        (topic, difficulty, question, fname, case, constraints)
        VALUES ($topic, $difficulty, $question, $functionName, $case, $constraints)";

    $result = mysqli_query($conn, $sql) OR DIE(json_encode(mysql_error()));
    if($result){
        $return = array(
            'response' => 'Success',
            'topic_added' => $topic,
            'difficulty_added' => $difficulty,
            'question_added' => $question,
            'function_added' => $functionName,
            'case_added' => $case,
            'constraints' => $constraints
        );
    }else{
        $return = array(
            'response' => 'Failed to add',
            'topic_added' => $topic,
            'difficulty_added' => $difficulty,
            'question_added' => $question,
            'function_added' => $functionName,
            'case_added' => $case,
            'constraints' => $constraints
        );
    }
    echo json_encode($return);
    
 mysqli_close($conn);

?> 