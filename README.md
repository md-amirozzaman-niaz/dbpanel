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
+ sort `email:asc`, `name:desc` 

#### date
+ date `created_at:2020-04-19:2020-04-21`

#### lookup/search
+ lookup `email:start$`,`email:$end`, `email:$anywhere$`, `email:!$.com`

#### where
+ where `column_name:column_value`, `product_price:500`,`discount_amount:!200`, `product_id:<200,product_price:>500`

#### return column list
+ return_col `id,name,email`, `name,email,phone`

