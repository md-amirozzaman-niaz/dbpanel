# dbpanel

dbpanel for laravel application. You can look around your laravel application's database easily and fastest way with so many filter. You might look around your table's column type and index. You can console your controller methods database query log. How many query it going to used and how long it will take for those query. To use this package follow the instruction below.

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
+ `users.name@employee_name,address,website`

#### return_except *(key)*

Example *(value)*:
+ `id,name,email` `name,email,phone`

### To Check Controller or Model or Other Method

Just type your Controller or Model or any other class name and method as 

```
ClassName@method
```

If you had a more namespace from Controller or Model default namespace prefix, then pass those extra as `dot` notation.

```
ExtraNameSpace.ClassName@method
```

To pass parameter

```
string:value1,value2:45
```

> Note: parameters are separated by `:`. Array parameter value are `,` seprated. Numeric string value will auto converted as `int` type value. This was also applicable for array.

To pass `request` instance 
```
prop.width.px@45
prop.width.rem@4
prop.height.px@45
prop.height.rem@4
```

### Return

It will return a json with `log` and `data` . In `log` all database query,bindings and time are listed.If this method return any data,it will return with `data`.

> Tip: you can test your request data from other tab by passing `request@dd`, `parameters` and `request` 

