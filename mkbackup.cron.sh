#!/bin/bash
# Backup script to be run as cronjob for periodically backing up the
# production environment
# Makes a daily backup every day and keeps one each week
# Be sure to adjust the database name if renaming!
#
# @author Johannes Braun <j.braun@agentur-halma.de>
# @package p8gr
# @version 2018-11-30


# Abort if anything goes wrong
set -e

# The source dir to be backup'ed
src="./httpdocs/"

excludes=""

# The destination path for backups
dest="./backups/cron"

# database name to backup
dbname=haus_st_jakobus
dbuser=cursillo

# suppress mysqldump warnings
export MYSQL_PWD='Pxrb870~'

# The current weekday (1=Monday)
weekday=$(date +%u)
fulldate=$(date +%Y-%m-%d)
fulldatetime=$(date +%Y-%m-%d-%H%M%S)

daily_backup_filename="backup.p8gr-hessen.de.daily.${weekday}.tar.gz"
weekly_backup_filename="backup.p8gr-hessen.de.weekly.${fulldate}.tar.gz"





# Every monday, archive last monday's backup
if [[ $weekday == "1" ]] ; then
	if [[ -e "${dest}/${daily_backup_filename}" ]] ; then
		/bin/mv "${dest}/${daily_backup_filename}" "${dest}/${weekly_backup_filename}"
	fi
fi

# Make daily backup
# 1. Database dump
/usr/bin/mysqldump -u "${dbuser}" "${dbname}" > "${dbname}.${fulldatetime}.sql"

# 2. Files
/bin/tar --create --gzip --exclude="${excludes}" --file "${dest}/${daily_backup_filename}" "${src}" "${dbname}.${fulldatetime}.sql"

/bin/chmod 600 "${dest}/${daily_backup_filename}"

# 5. Clean-up
/bin/rm "${dbname}.${fulldatetime}.sql"

exit 0;
