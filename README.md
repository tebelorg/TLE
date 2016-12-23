# TA.ETL
TA.ETL is a helper to handle data ETL processes (extract, transform, load)

![Sample ETL](https://github.com/tebelorg/TA.ETL/raw/master/sample.png)

# Why This
Skeleton repository for pooling data management resources.

The first and base script to write is to transform spreadsheet data by remapping columns and preparing data for import by downstream system. Specific use case is syncing ipcLink system used by non-profits to MYOB accounting system.

# Set Up
Create a transformation logic / mapping file with 2 rows
- first row listing the header fields desired in the output
- second row specifying which column in input to take data from

# To Use
To transform input.csv into output.csv (using transformation logic in mapping.csv)
```
php etl_start.php input.csv mapping.csv output.csv
```
# Pipeline
Feature|Details
:-----:|:------
Beyond Mapping|support string manipulation and formulas
New Endpoints|excel spreadsheet, database, webpage, etc
Enhancements|explore ETL features from Pentaho and Talend

# License
TA.ETL is open-source software released under the MIT license
