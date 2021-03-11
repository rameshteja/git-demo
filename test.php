<?php
$old_arr = array(

   "51" => array(
        "flow_id" => 51,
        "parent_id" => 0,
        "true_child_id" => 52
    ),
  "52" =>  array(
        "flow_id" => 52,
        "parent_id" => 51,
        "true_child_id" => 53
    ),
  "42" =>  array(
        "flow_id" => 42,
        "parent_id" => 53,
        "true_child_id" => 44,
        "false_child_id" => 45
    ),
  "43" =>  array(
        "flow_id" => 43,
        "parent_id" => 41
    ),
   "44" => array(
        "flow_id" => 44,
        "parent_id" => 42
    ),
   "45" => array(
        "flow_id" => 45,
        "parent_id" => 42
    ),
   "53" => array(
        "flow_id" => 53,
        "parent_id" => 52,
        "true_child_id" => 41,
        "false_child_id" => 42,
    ),
   "41" => array(
        "flow_id" => 41,
        "parent_id" => 53,
        "true_child_id" => 43
    ),
);

$final_arr = array(
    array(
        "flow_id" => 51,
        "parent_id" => 0,
        "true_child_id" => 52
    ),
    array(
        "flow_id" => 52,
        "parent_id" => 51,
        "true_child_id" => 53
    ),
    array(
        "flow_id" => 53,
        "parent_id" => 52,
        "true_child_id" => 41,
        "false_child_id" => 42,
    ),
    array(
        "flow_id" => 41,
        "parent_id" => 53,
        "true_child_id" => 43
    ),
    
    array(
        "flow_id" => 42,
        "parent_id" => 53,
        "true_child_id" => 44,
        "false_child_id" => 45
    ),
    array(
        "flow_id" => 43,
        "parent_id" => 41
    ),
    array(
        "flow_id" => 44,
        "parent_id" => 42
    ),

    array(
        "flow_id" => 45,
        "parent_id" => 42
    ),
);
// function build_sorter($key) {
//     return function ($a, $b) use ($key) {
//         return strnatcmp($a[$key], $b[$key]);
//     };
// }
// usort($old_arr, build_sorter('parent_id'));

// $Sort_arr = array_column($old_arr, 'parent_id');

// $new_array = array();
// array_multisort($Sort_arr, SORT_ASC, $old_arr);



$new_array = array();

$ext_arr = array();
for($i=0; $i<count($old_arr); $i++){
    if($i == 0){
        $new_array[] = $old_arr[$i];
    }
    
    if( array_key_exists('true_child_id', $old_arr[$i]) ) {
        for($j=0; $j<count($old_arr); $j++){
            if($old_arr[$i]['true_child_id'] == $old_arr[$j]['flow_id']){
                $new_array[] = $old_arr[$j];
            }
        }

    }

    if(array_key_exists('false_child_id',$old_arr[$i])){
        for($k=0; $k<count($old_arr);$k++){
            if($old_arr[$i]['false_child_id'] == $old_arr[$k]['flow_id']){
                $new_array[] = $old_arr[$k];
            }
        }
    }
    // $new_array = continueLoop($old_arr[$j], $old_arr,$new_array);
}
function continueLoop($current_arr, $old_array,$final_arr) {
    if(array_key_exists('true_child_id', $current_arr)){
        for($i=0; $i<count($old_arr);$i++){
            if($current_arr['true_child_id'] == $old_arr[$i]){
                $final_arr[] = $old_arr[$i];
            }
        }
    }
    if(array_key_exists('false_child_id', $current_arr)){
        for($j=0; $j<count($old_arr);$j++){
            if($current_arr['false_child_id'] == $old_arr[$j]){
                $final_arr[] = $old_arr[$j];
            }
        }
    }
    return $final_arr;
    // $final_arr[] = continueLoop($current_arr, $old_array,$final_arr);
}
// $finela_arr = array_merge($new_array,$ext_arr);
// $new_arr = array_unique($new_array);
// $final = array_multisort($new_array, SORT_ASC, $old_arr);
echo '<pre>';
print_r($new_array);
?>