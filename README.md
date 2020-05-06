# dbpanel
database panel for laravel application. You can look around your laravel application's database easily and fastest way with so many filter. You might look around your table's column type and index.

### Installation

```
composer require niaz/dbpanel --dev
```
### Publish assets
```
php artisan vendor:publish --tag=dbpanel
```
### Usage

Visit Route:

```
/dbpanel
```
Select a `table` name from table option and enter some query string with some `key` name are filter name as follows:

#### id *(key)*

Example *(value)*: `5` `5-100`

#### sort *(key)*

Example *(value)*: `email:asc` `name:desc`  `desc`

#### is *(key)*

Example *(value)*: `active:0` `active:1`  `date:2020-04-29`

#### date *(key)*

single date

Example *(value)*: `updated_at:2020-04-29`

range of date

Example *(value)*: `created_at:2020-04-19:2020-04-21`

#### lookup *(key)*

for *variant*,

+ use `!` for not match
+ use `$` to specify string postion
+ use `,` for *and* condition
+ use `|` for *or* condition

Example *(value)*:

`email:start$` `email:$end` `email:$anywhere$` `email:!$.com` 

#### where *(key)*
for *variant*,

+ use `!` for not equal
+ use `<` for less than
+ use `>` for greater than
+ use `,` for *and* condition
+ use `|` for *or* condition

Example *(value)*:

+ `product_price:500` `discount:<20` 
+ `product_id:<200,product_price:>500`
+ `product_price:<300|discount:>15`

#### join *(key)*

Example *(value)*:

+ `initialTable:Column:firstTable:Column`

*initialColumn=firstColumn* and *firstColumn=secondColumn*

+ `initialTable:Column:firstTable:Column,firstable:Column:secondTable:Column:`

> **Note**: when use **join** Not to use any similar `column` name related filter
> it will thrown error.

#### return_only *(key)*

for *alias* use `@`

Example *(value)*:

+ `id,name,email` `name,email,phone`
+ `id,name@user_name,email@user_email`
+ `name@employee_name,phone@employee_phone`
+ `upazilas.name@upazila,districts.name@district,divisions.name@division,website`

#### return_except *(key)*

Example *(value)*:
+ `id,name,email` `name,email,phone`

