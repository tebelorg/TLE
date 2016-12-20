<?php

/* ETL SCRIPT FOR TA.ETL TO EXTRACT TRANSFORM LOAD DATA ~ TEBEL.SG */

// check for first parameter - data extract file in csv
if ($argv[1]=="") die("ERROR - data extract file missing for first parameter\n"); $data_extract_file = $argv[1];
if (!file_exists($data_extract_file)) die("ERROR - cannot find " . $data_extract_file . "\n");
$data_extract = fopen($data_extract_file,'r') or die("ERROR - cannot open " . $data_extract_file . "\n");

// check for second parameter - data transform file in csv
if ($argv[2]=="") die("ERROR - data transform file missing for second parameter\n"); $data_transform_file = $argv[2];
if (!file_exists($data_transform_file)) die("ERROR - cannot find " . $data_transform_file . "\n");
if (count(file($data_transform_file)) != 2) die ("ERROR - data transform file does not have exactly 2 rows\n");
$data_transform = fopen($data_transform_file,'r') or die("ERROR - cannot open " . $data_transform_file . "\n");

// check for third parameter - data load file in csv
if ($argv[3]=="") die("ERROR - data load file missing for third parameter\n"); $data_load_file = $argv[3];
$data_load = fopen($data_load_file,'w') or die("ERROR - cannot open " . $data_load_file . "\n");

fputcsv($data_load,fgetcsv($data_transform)); // write header to output
$data_transform_mapping = fgetcsv($data_transform); // get transform mapping
fgetcsv($data_extract); // discard header from input to prepare for iteration

while (!feof($data_extract)) { // loop through input, transform data, write to output
$data_extract_row = fgetcsv($data_extract); if ($data_extract_row != "")
fputcsv($data_load,etl_transform($data_extract_row,$data_transform_mapping));}

fclose($data_extract); fclose($data_transform); fclose($data_load); // close all open files

function etl_transform($row_extract, $row_mapping) {
$row_load = $row_mapping; $num_col = count($row_mapping); for ($curr_col=0; $curr_col<$num_col; $curr_col++){
$row_load[$curr_col] = $row_extract[column_to_index($row_mapping[$curr_col])];} return $row_load;}

function column_to_index($column_value) {
$column_range = range('A', 'Z'); return array_search(strtoupper($column_value), $column_range);}

?>
