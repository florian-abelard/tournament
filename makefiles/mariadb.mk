#------------------------------------------------------------------------------
# Mariadb Makefile
#------------------------------------------------------------------------------


#------------------------------------------------------------------------------

db-init: ##@database Create mariadb database and schema
	$(call docker-compose-exec, mysql --user=root --password=${MYSQL_ROOT_PASSWORD} --host=${DATABASE_HOST} < data/sql/01-system.sql)
	$(call docker-compose-exec, mysql --user=root --password=${MYSQL_ROOT_PASSWORD} --host=${DATABASE_HOST} < data/sql/02-schema.sql)

db-populate: ##@database filled database with sample data
	$(call docker-compose-exec, mysql --user=root --password=${MYSQL_ROOT_PASSWORD} --host=${DATABASE_HOST} < data/sql/03-data.sql)

#------------------------------------------------------------------------------

clean-db: ##@database clean database  TODO?

#------------------------------------------------------------------------------

.PHONY: db-init db-populate
