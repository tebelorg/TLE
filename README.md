# TA.ETL
TA.ETL is a helper to handle data ETL processes ~ http://tebel.org

![Sample ETL](https://github.com/tebelorg/TA.ETL/raw/master/sample.png)

# Why This
TA.ETL lets you programmatically transform spreadsheet data (or MySQL database) by remapping columns and preparing data (eg changing case-formatting) for consumption by downstream systems.

Originally developed pro bono for syncing ipcLink system used by Singapore non-profits to MYOB accounting system. For open-source ETL tools that are based on GUI, consider using [Pentaho Data Integration](http://community.pentaho.com/projects/data-integration/) or [Talend Open Studio](https://www.talend.com/download/talend-open-studio#t4).

# Set Up
Create a transformation mapping file with 2 rows, for eg

Name|Email|User ID
:---|:----|:--
B|LOWER(C)|UPPER(F)

- first row labelling the header fields desired in the output
- second row specifying which column in input to grab data
- use UPPER, LOWER, TITLE, SENTENCE for formatting case

For database input, provide input file in below format for script to read from database

TA.ETL_COMMENTS|DB_SERVER|DB_USER|DB_PASSWORD|DB_NAME|DB_TABLE
:--------------|:--------|:------|:----------|:------|:-------
user comments|servername|username|password|database|tablename

# To Use
To transform input.csv using mapping.csv logic into output.csv (supported data formats - csv xls xlsx html)
```
php etl_start.php input.csv mapping.csv output.csv
```
To call TA.ETL within a PHP script, simply assign the variables accordingly and include etl_start.php
```php
$argv[1] = "input.csv"; $argv[2] = "mapping.csv"; $argv[3] = "output.csv"; include('etl_start.php');
```

# Pipeline
Feature|Details
:-----:|:------
Enhancements|feel free to review and suggest new features

# License
TA.ETL is open-source software released under the MIT license
