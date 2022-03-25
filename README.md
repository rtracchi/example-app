# Laravel assignment documentation

**All required and optional (Docker, PHPUnit automated tests) assignments were completed**

## Used tools:
- Docker
- Laravel Sail

## Artisan commands
- Migration for task 1

## Build
- Builded Laravel Docker image for hypotetical nginx production enviroment, Dockerfile and docker folder created

## Exercise more important files
- 2022_03_22_211023_people.php (migration for task 1)
- PeopleController.php (task 2)
- PeopleControllerTest.php (automated tests)

## Useful info
- Since the aim is to provide people data associated with their planets info, the planets db only contains inhabited planets, if a planet is not inhabited by none of the people, it will not be retrieved and stored
- Not all the planets data is is stored in the database but just a few info, because probably copying all info is not the main focus of the exercise
- .env not present since it goes in .gitignore, but i'm pasting here the interesting lines:

DB_CONNECTION=mysql
DB_HOST='mysql'
DB_PORT=3306
DB_DATABASE='exercise'
DB_USERNAME='root'
DB_PASSWORD='rootpassword'

## APIs

## People list

### Pagination
/api/people?page={pageNumber}
### Order by
/api/people?orderby={columnName}
(I could have created a filter for every field but probably copying all columns names to create filters is not the main focus of the exercise)
### Filter
/api/people?filtername={string}

Pagination, order by and filtering can be all present at the same time
example: /api/people?page=1&orderby=name&filtername=R

## People detail
/api/people/{id}