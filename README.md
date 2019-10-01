# ogenius_sync
Syncing Two Identical  Databases
# Using db_sync_1 and db_sync_2 in this example
On every table u create in each database, add a field called origin containing which database u are on.
# Guidelines
Setup .cyumaconfig file and put respective data on each line
respect the structure of lines
Include the main_sync.php in your local project files, 
Modify the js variable remoteDomainUrlForFiles to your own server php root folder so as to access the sync_files.
Finally copy both files on local and remote servers.
 Tips: unable to sync duplicate entries in on both databases.




