<?php

$input_array = array(
    "58882" => array
        (
            "flow_id" => 58882,
            "parent_id" => 58890,
            "true_child_id" => 58900,
            "false_child_id" => 0,
            "flow_type" => "Query",
            "flow_create" => "Module"
        ),

"58883" => array
    (
        "flow_id" => 58883,
        "parent_id" => 58900,
        "true_child_id" => 58884,
        "false_child_id" => 58885,
        "flow_type" => "Condition",
        "flow_create" => "Module"
    ),

"58884" => array
    (
        "flow_id" => 58884,
        "parent_id" => 58883,
        "true_child_id" => 0,
        "false_child_id" => 0,
        "flow_type" => "Finish",
        "flow_create" => "Module"
    ),

"58885" => array
    (
        "flow_id" => 58885,
        "parent_id" => 58883,
        "true_child_id" => 0,
        "false_child_id" => 0,
        "flow_type" => "Finish",
        "flow_create" => "Module"
    ),

"58890" => array
    (
        "flow_id" => 58890,
        "parent_id" => 0,
        "true_child_id" => 58882,
        "false_child_id" => 0,
        "flow_type" => "Query",
        "flow_create" => "Custom"
    ),

"58900" => array
    (
        "flow_id" => 58900,
        "parent_id" => 58882,
        "true_child_id" => 58883,
        "false_child_id" => 0,
        "flow_type" => "Function",
        "flow_create" => "Custom"
    )
);

$response_arr = array();
foreach( $input_array as $key => $value ){
    if($input_array[$key]['parent_id'] == 0){
        $response_arr[] = $input_array[$key];
        break;
    }
}
$j = 0;
foreach( $input_array as $key => $value ) {
    
    if($response_arr[$j]['true_child_id'] >0 ){
        $derieved = getNode($input_array,$response_arr[$j]['true_child_id']);
        $response_arr[] = $derieved;
    }
    if($response_arr[$j]['false_child_id'] >0 ){
        $derieved = getmyinode($input_array,$response_arr[$j]['false_child_id']);
        $response_arr[] = $derieved;
    }
    $j++;
}

function getNode($input_array, $array_index){
    foreach($input_array as $key => $value){
        if($input_array[$key]['flow_id'] == $array_index){
            $return_arr = $input_array[$array_index];
        }
    }
    
    return $return_arr;
}
echo '<pre>';
print_r($response_arr);
?>