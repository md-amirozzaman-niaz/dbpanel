# dbpanel
database panel for laravel application

### Installation

```
composer require niaz/dbpanel
```
### Publish assets
```
php artisan vendor:publish --tag=public --force
```
### Usage

Visit Route:

```
/dbpanel
```
Select a `table` name from table option and enter some query string with some `key` name are filter name as follows:

#### id

+ `5` ,`5-100`

#### sort

+ `email:asc`, `name:desc` , `desc`

#### is
+ `active:0`, `active:1` , `date:2020-04-29`

#### date

single date

+ `updated_at:2020-04-29`

range of date

+ `created_at:2020-04-19:2020-04-21`

#### lookup
for `variant` use `!` for not match, use `$` to specify string postion

+ `email:start$`,`email:$end`, `email:$anywhere$`, `email:!$.com`


#### where
for `variant`, use `!` for not equal, use `<` for less than, use `>` for greater than

+ `column_name:column_value`, `product_price:500`,`discount_amount:!200`

for `and` condition, use `,`

+ `product_id:<200,product_price:>500`

for `or` condition, use `|`

+ `product_id:<200,product_price:<300|id:100`

#### return_only

+ `id,name,email`, `name,email,phone`

for alias use `@`

+ `id,name@user_name,email@user_email`, `name@employee_name,phone@employee_phone`

#### return_except
+ `id,name,email`, `name,email,phone`

