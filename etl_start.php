<?php

/* ETL BASE SCRIPT FOR TA.ETL TO EXTRACT TRANSFORM LOAD DATA ~ TEBEL.SG */

require_once('PHPExcel/PHPExcel.php'); // for managing xls/xlsx/html - https://github.com/PHPOffice/PHPExcel

// check for first parameter - data extract file in csv, xls, xlsx, html
if ($argv[1]=="") die("ERROR - data extract file missing for first parameter\n"); $data_extract_file = $argv[1];
if (!file_exists($data_extract_file)) die("ERROR - cannot find " . $data_extract_file . "\n");
$ext_len = strlen(pathinfo($data_extract_file, PATHINFO_EXTENSION)); // use in generating csv filename
convert_datafile($data_extract_file,substr($data_extract_file,0,strlen($data_extract_file)-$ext_len).'csv');
$data_extract_file = substr($data_extract_file,0,strlen($data_extract_file)-$ext_len).'csv';
$data_extract = fopen($data_extract_file,'r') or die("ERROR - cannot open " . $data_extract_file . "\n");

// check for second parameter - data transform file in csv, xls, xlsx, html
if ($argv[2]=="") die("ERROR - data transform file missing for second parameter\n"); $data_transform_file = $argv[2];
if (!file_exists($data_transform_file)) die("ERROR - cannot find " . $data_transform_file . "\n");
$ext_len = strlen(pathinfo($data_transform_file, PATHINFO_EXTENSION)); // use in generating csv filename
convert_datafile($data_transform_file,substr($data_transform_file,0,strlen($data_transform_file)-$ext_len).'csv');
$data_transform_file = substr($data_transform_file,0,strlen($data_transform_file)-$ext_len).'csv';
if (count(file($data_transform_file)) != 2) die ("ERROR - data transform file does not have exactly 2 rows\n");
$data_transform = fopen($data_transform_file,'r') or die("ERROR - cannot open " . $data_transform_file . "\n");

// check for third parameter - data load file in csv, xls, xlsx, html
if ($argv[3]=="") die("ERROR - data load file missing for third parameter\n"); $data_load_file = $argv[3];
$ext_len = strlen(pathinfo($data_load_file, PATHINFO_EXTENSION)); // use in generating csv filename
$data_load = fopen(substr($data_load_file,0,strlen($data_load_file)-$ext_len).'csv','w') 
or die("ERROR - cannot open " . substr($data_load_file,0,strlen($data_load_file)-$ext_len).'csv' . "\n");

fputcsv($data_load,fgetcsv($data_transform)); // write header to output
$data_transform_mapping = fgetcsv($data_transform); // get transform mapping
fgetcsv($data_extract); // discard header from input to prepare for iteration

while (!feof($data_extract)) { // loop through input, transform data, write to output
$data_extract_row = fgetcsv($data_extract); if ($data_extract_row != "")
fputcsv($data_load,etl_transform($data_extract_row,$data_transform_mapping));}

fclose($data_extract); fclose($data_transform); fclose($data_load); // close all open files
convert_datafile(substr($data_load_file,0,strlen($data_load_file)-$ext_len).'csv',$data_load_file);

function etl_transform($row_extract, $row_mapping) {
$row_load = $row_mapping; $num_col = count($row_mapping); for ($curr_col=0; $curr_col<$num_col; $curr_col++){
$row_load[$curr_col] = $row_extract[column_to_index($row_mapping[$curr_col])];} return $row_load;}

function column_to_index($column_value) {
$column_range = range('A', 'Z'); return array_search(strtoupper($column_value), $column_range);}

function convert_datafile($infile,$outfile) {if ($infile==$outfile) return; // exit if I/O files are the same
if ((strtolower(pathinfo($infile, PATHINFO_EXTENSION))!='csv') and 
(strtolower(pathinfo($infile, PATHINFO_EXTENSION))!='xls') and
(strtolower(pathinfo($infile, PATHINFO_EXTENSION))!='xlsx') and
(strtolower(pathinfo($infile, PATHINFO_EXTENSION))!='html')) 
die("ERROR - unsupported input format " . $infile . "\n");
$infileType = PHPExcel_IOFactory::identify($infile); $objReader = PHPExcel_IOFactory::createReader($infileType);
$objReader->setReadDataOnly(true); $objPHPExcel = $objReader->load($infile); // load file base on detected type   
// if input file is Excel remove first row, which is an empty row with sheet name (not supporting multiple sheets)
if (($infileType == 'Excel5') or ($infileType == 'Excel2007')) $objPHPExcel->getActiveSheet()->removeRow(1);

if (strtoupper(pathinfo($outfile, PATHINFO_EXTENSION))=='CSV') $outfileType = 'CSV'; // set output file type
else if (strtoupper(pathinfo($outfile, PATHINFO_EXTENSION))=='XLS') $outfileType = 'Excel5'; // legacy Excel'95
else if (strtoupper(pathinfo($outfile, PATHINFO_EXTENSION))=='XLSX') $outfileType = 'Excel2007'; // new Excel'07
else if (strtoupper(pathinfo($outfile, PATHINFO_EXTENSION))=='HTML') $outfileType = 'HTML'; // HTML format
// skip below PDF as it requires either tcPDF, DomPDF or mPDF libraries, and need to be installed separately
// else if (strtoupper(pathinfo($outfile, PATHINFO_EXTENSION))=='PDF') $outfileType = 'PDF'; // PDF format
else die("ERROR - unsupported output format " . $outfile . "\n");
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $outfileType);
if ($outfileType == 'CSV') $objWriter->setUseBOM(true);  $objWriter->save($outfile);}

?>
