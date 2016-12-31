# TA.ETL
TA.ETL is a helper to handle data ETL processes (extract, transform, load)

![Sample ETL](https://github.com/tebelorg/TA.ETL/raw/master/sample.png)

# Why This
Repository for pooling data management resources. For open-source ETL tools that are based on the graphical user interface and with developed features, consider using [Pentaho Data Integration](http://community.pentaho.com/projects/data-integration/) or [Talend Open Studio](https://www.talend.com/download/talend-open-studio#t4).

The first and base script coded is to transform spreadsheet data by remapping columns and preparing data for import by downstream system. Specific use case is syncing ipcLink system used by Singapore non-profits to MYOB accounting.

# Set Up
Create a transformation mapping file with 2 rows, for eg

Name|Email|User ID
:---|:----|:--
B|LOWER(C)|UPPER(F)

- first row labelling the header fields desired in the output
- second row specifying which column in input to grab data
- UPPER, LOWER, TITLE, SENTENCE text case formatting

For database input, provide input file in below format for script to autoload

TA.ETL_COMMENTS|DB_SERVER|DB_USER|DB_PASSWORD|DB_NAME|DB_TABLE
:--------------|:--------|:------|:----------|:------|:-------
user comments|servername|username|password|database|tablename

# To Use
To transform input.csv using logic in mapping.csv into output.csv (data formats supported - csv xls xlsx html)
```
php etl_start.php input.csv mapping.csv output.csv
```
(note that non-csv files will be converted into csv files having same names but with .csv extension for processing)

# Pipeline
Feature|Details
:-----:|:------
Enhancements|feel free to review and suggest new features

# License
TA.ETL is open-source software released under the MIT license
