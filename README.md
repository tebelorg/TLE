# TA.ETL
TA.ETL is a helper to handle data ETL processes (extract, transform, load)

![Sample ETL](https://github.com/tebelorg/TA.ETL/raw/master/sample.png)

# Why This
Skeleton repository for pooling data management resources. For open-source ETL tools that are based on the graphical user interface and with developed features, consider using [Pentaho Data Integration](http://community.pentaho.com/projects/data-integration/) or [Talend Open Studio](https://www.talend.com/download/talend-open-studio#t4).

The first and base script to write is to transform spreadsheet data by remapping columns and preparing data for import by downstream system. Specific use case is syncing ipcLink system used by non-profits to MYOB accounting system.

# Set Up
Create a transformation logic / mapping file with 2 rows
- first row listing the header fields desired in the output
- second row specifying which column in input to take data

# To Use
To transform input.csv using logic in mapping.csv into output.csv (data formats supported - csv xls xlsx html)
```
php etl_start.php input.csv mapping.csv output.csv
```
Note that non-csv files will be converted into csv files having same names but with .csv extension for processing.

# Pipeline
Feature|Details
:-----:|:------
New Endpoints|database connections for read and write
Enhancements|add support for string manipulation and formulas

# License
TA.ETL is open-source software released under the MIT license
