#!/bin/bash

echo "DROP DATABASE gachenti" | mysql -u enti -p
echo "gachenti database has been deleted, now reinitializing"
cat main.sql | mysql
echo "\033[32msucces\033[0m"
