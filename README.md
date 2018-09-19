GIT Operations
==============

GIT repetitive opertions made easy


## What is this repository for? ##

This repository is intended to ease various GIT operations


## Who do I talk to? ##

Repository owner is: [Daniel Popiniuc](mailto:danielpopiniuc@gmail.com)


## Usage ##

1. Generate CSV output by running `<git_binary_path>git.exe log --decorate --oneline --no-abbrev-commit --pretty=tformat:\"%%an;%%ae;%%cn;%%ce;%%T;%%H;%%aI;%%cI;%%D;%%s;%%-\" --shortstat > <your_path_where_results_will_be_stored><results_file_name_raw>`. As this file will have some empty lines and unstructured ones to highlight file changes, insertions or deletions.
2. To standardize prior generate file into proper CSV format run `<php_binary_path>php.exe -c <php_configuration_path>php.ini <path_where_this_package_resides_on_your_hdd>/source/HandleGitLogOutput.php --strInputFormat=<git_log_switches> --strInputPath=<results_file_path> --strInputFileName=<results_file_name_raw> --strOutputHeaderLabel=<label_configured_in_json_file_containing_list_of_meaningfull_words> --strOutputPath=<results_file_path_final> --strOutputFileName=<results_file_name_final>`
