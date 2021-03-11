<?php

$old_arr = array(
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
$new_arr = array();

foreach($old_arr as $key => $value){
    if($old_arr[$key]['parent_id'] == 0){
        $new_arr[] = $old_arr[$key];
    }
}

for($i=0; $i<count($old_arr);$i++){
    if($new_arr[$i]['true_child_id'] == $new_arr[$i]['false_child_id']){
        $new_arr[] = $old_arr[$new_arr[$i]['true_child_id']];
    } else {  
        if($new_arr[$i]['true_child_id'] >0 ){
            $new_arr[] = $old_arr[$new_arr[$i]['true_child_id']];
        }
        if($new_arr[$i]['false_child_id'] >0 ){
            $new_arr[] = $old_arr[$new_arr[$i]['false_child_id']];
        }
    }
}
echo '<pre>';

print_r(array_filter($new_arr));
exit();
$true_child_id = $new_arr[0]['true_child_id'];
$false_child_id = $new_arr[0]['false_child_id'];
$new_arr = findNext($true_child_id,$false_child_id,$old_arr,$new_arr);


function findNext($true_child_id,$false_child_id,$old_arr,$new_arr) {
    for($i=0;$i<count($old_arr);$i++){
        if($true_child_id > 0 ){
            array_push($new_arr,$old_arr[$true_child_id]);
            $true_child_id = $old_arr[$true_child_id]['true_child_id'];
        }
        if($false_child_id > 0){
            array_push($new_arr,$old_arr[$false_child_id]);
            $false_child_id = $old_arr[$false_child_id]['false_child_id'];
        }
    }
    // findNext($true_child_id,$false_child_id,$old_arr,$new_arr);
    return $new_arr;
}

echo '<pre>';
print_r($new_arr);

?>