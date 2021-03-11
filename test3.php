<?php
   $old_array2 = array(
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

$old_array = array(

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
         "true_child_id" => 0,
         "false_child_id" => 42 ,
     ),
    "41" => array(
         "flow_id" => 41,
         "parent_id" => 53,
         "true_child_id" => 43
     ),
 );
 

// echo '<pre>';
//print_r($old_array);
$new_array = array();
$p = array();

// Determine parent

$keys = array_keys($old_array);

for($i=0; $i<count($old_array); $i++)
{
    if($old_array[$keys[$i]]["parent_id"] == 0)
    {
        $new_array[0] = $old_array[$keys[$i]];
        break;
    }
    
}


$j = 0;
for ($i=0;$i<count($old_array);$i++)
{

    $driverNode = $new_array[$i];

    
    if($driverNode['true_child_id'] > 0)
    {

        $nodeDetails = getNode($old_array, $driverNode['true_child_id']);
        $new_array[] = $nodeDetails;
    }
    
    if($driverNode['false_child_id'] > 0)
    {
        $nodeDetails = getNode($old_array, $driverNode['false_child_id']);
        $new_array[] = $nodeDetails;
    }
    
}


function getNode($old_array, $flowId)
{
    $keys = array_keys($old_array);
    for($i=0; $i<count($old_array); $i++)
    {
        if($old_array[$keys[$i]]['flow_id'] == $flowId)
        {
            return $old_array[$keys[$i]];
        }
    
    }
    
}
echo '<pre>';
print_r($new_array);

?>