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
Select a `table` name from table option and enter some query string with some `key` name as follows:

#### id
+ id `5` ,`5-100`

#### sort
+ sort `asc`, `desc` 
+ sort_col `name`, `email`

#### is
+ is `0`,`1`
+ is_col `active`,`is_active`, `is_admin`

#### date
+ date `2020-04-12`
+ end_date `2020-07-31`
+ date_col `date`, `created_at`, `updated_at`

#### lookup/search
+ lookup `gmail%`,`%gmail`, `%gmail%`, `!%.com%`
+ lookup_col `email`

#### where
+ where `column_name`, `product_price`,`discount`,`total`, `product_id,product_price`
+ where_val `your_value`, `<50`,`>50`, `~100`, `435,>400`

#### return column list
+ return_col `id,name,email`, `name`

