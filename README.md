# dbpanel

## Introduction 

dbpanel is a developer tool for laravel application. You can test your `controller`'s action methods by calling its `namepspace@method` and save them for your future need. You can also run artisan command, namespace lookup for available methods and all their associated doc and parameters type.

 :loudspeaker: You can also access your laravel application's `database` easily and fastest way in a same panel. There are some cool filter available with this package. You might look around your table's column type and index also. You can also update and delete your filtered data.

:loudspeaker: You can also open vue component in code editor (phpstorm,vscode) by clicking `open file` from vue chrome extention tool.

### Installation :satellite:

```
composer require niaz/dbpanel --dev
```
### Publish assets :electric_plug:
```
php artisan vendor:publish --tag=dbpanel --force
```
### SetUp Configuration :rocket:

You need to edit `config/dbpanel.php` as your configuration

If your default code editor is `phpstorm`,then need to set as

```
 'editor'=>'phpstorm'  // default 'editor'=>'vscode'
```

If your application not used controller namespace property, then you need to set this value as

```
  'controller' => '',  // deafult 'controller' => 'App\\Http\\Controllers\\',
```
### Usage :package:

Visit Route:

```
/dbpanel
```
### To Check Controller or Model or Other Method

Just type your Controller or Model or any other class name and method as 

```
ClassName@method
```

If you had a more namespace from Controller or Model default namespace prefix, then

```
ExtraNameSpace\ClassName@method
```

To pass parameter

```
App\User 5|string|58,hello,78|12:58:59
```

> Note: parameters are separated by `|`. Array parameter value are `,` seprated. Numeric string value will auto converted as `int` type value. This was also applicable for array.

To pass `request` instance 
```
prop.width.px@45
prop.height.px@45
filter.date.start@2020-11-12
filter.date.end@2020-15-12
filter.search@lorem ipsum
filter.range.min@15
filter.range.max@68
filter.time@12:58:56
```
> every formData are in a new line

or Raw json

```
{
    "husky": {
        "hooks": {
        "pre-commit": "npm test",
        "pre-push": "npm test",
        "...": "..."
        }
    }
}
```

### Return

It will return a json with `log` and `data` . In `log` all database query,bindings and time are listed.If this method return any data,it will return with `data`.

> Tip: you can test your request data from other tab by passing `request@dd`, `parameters` and `request` 

### To pass auth for login with `ID`

```
5@id,name,email
```

> id_number@id,column_name,email

### Run Artisan Command

### Database

Select a `table` name from table option and enter some query string with some `key` name are filter name as follows:

#### id *(key)*

Example: `&id=5` `&id=5-100`

#### sort *(key)*

Example: `&sort=email:asc` `&sort=name:desc`  `&sort=desc`

#### is *(key)*

Example: `&is=active:0` `&is=active:1`  `&is=date:2020-04-29`

#### date *(key)*

single date

Example: `&date=updated_at:2020-04-29`

range of date

Example: `&date=created_at:2020-04-19:2020-04-21`

#### lookup *(key)*

for *variant*,

+ use `!` for not match
+ use `$` to specify string postion
+ use `,` for *and* condition
+ use `|` for *or* condition

Example:

`&lookup=email:start$` `&lookup=email:$end` `&lookup=email:$anywhere$` `&lookup=email:!$.com` 

#### where *(key)*
for *variant*,

+ use `!` for not equal
+ use `<` for less than
+ use `>` for greater than
+ use `,` for *and* condition
+ use `|` for *or* condition

Example:

+ `&where=product_price:500` `&where=discount:<20` 
+ `&where=product_id:<200,product_price:>500`
+ `&where=product_price:<300|discount:>15`

#### join *(key)*

Example:

+ `&join=initialTable:Column:firstTable:Column`

*initialColumn=firstColumn* and *firstColumn=secondColumn*

+ `&join=initialTable:Column:firstTable:Column,firstable:Column:secondTable:Column:`

> **Note**: when use **join** Not to use any similar `column` name related filter
> it will thrown error.

#### return_only *(key)*

for *alias* use `@`

Example:

+ `&return_only=id,name,email` `&return_only=name,email,phone`
+ `&return_only=id,name@user_name,email@user_email`
+ `&return_only=name@employee_name,phone@employee_phone`
+ `&return_only=users.name@employee_name,address,website`

#### return_except *(key)*

Example:
+ `&return_except=id,name,email` `&return_except=name,email,phone`

#### Delete

To delete your filtered data just pass `&delete`

#### Update

Example : `&update=column_name:value,column_name:value`


## Lisence

[MIT Lisence]( https://github.com/md-amirozzaman-niaz/dbpanel/blob/License.md)


