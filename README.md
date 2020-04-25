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

Example: `5` `5-100`

#### sort

Example `email:asc` `name:desc`  `desc`

#### is

Example: `active:0` `active:1`  `date:2020-04-29`

#### date

single date

Example: `updated_at:2020-04-29`

range of date

Example: `created_at:2020-04-19:2020-04-21`

#### lookup

for *variant*,

+ use `!` for not match
+ use `$` to specify string postion
+ use `,` for *and* condition
+ use `|` for *or* condition

Example:

`email:start$` `email:$end` `email:$anywhere$` `email:!$.com` 

#### where
for *variant*,

+ use `!` for not equal
+ use `<` for less than
+ use `>` for greater than
+ use `,` for *and* condition
+ use `|` for *or* condition

Example:

+ `product_price:500` `discount:<20`
+ `product_id:<200,product_price:>500`
+ `product_price:<300|discount:>15`

#### return_only

for *alias* use `@`

Example:

+ `id,name,email` `name,email,phone`
+ `id,name@user_name,email@user_email`
+ `name@employee_name,phone@employee_phone`

#### return_except

+ `id,name,email`, `name,email,phone`

