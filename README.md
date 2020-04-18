# dbpanel
database panel for laravel application

### Installation

```
composer require niaz/dbpanel
```
### Usage

Visit Route:

```
/dbpanel
```
Enter a `table` name in Uri field and pass any query with some `key` name as follows:

+ return_col `id,name,email`, `name`
+ id `5` ,`5-100`
+ sort `asc`, `desc` 
+ sort_column `name`, `email`
+ active `0`,`1`
+ date `2020-04-12`
+ end_date `2020-07-31`
+ date_column `date`, `created_at`, `updated_at`
+ lookup `gmail%`,`%gmail`, `%gmail%`, `!%.com%`
+ lookup_column `email`
+ per_page `5`, `10`, `25`
