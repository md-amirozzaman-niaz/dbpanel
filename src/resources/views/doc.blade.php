<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>niaz/dbpanel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="icon" type="image/png" sizes="32x32" href="vendor/dbpanel/media/favicon.png">
        <!-- Styles -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.18.1/styles/github.min.css" integrity="sha256-iAmWN8uaUdN6Y9FCf8srQdrx3eVVwouJ5QtEiyuTQ6A=" crossorigin="anonymous" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/fontawesome.min.css" integrity="sha256-CuUPKpitgFmSNQuPDL5cEfPOOJT/+bwUlhfumDJ9CI4=" crossorigin="anonymous" />
        <link rel="stylesheet" href='/vendor/dbpanel/css/style.css' />

        <!-- Styles -->
        <style>
            code{

    background: #f7f7f7;
            }
            body{
                background: #d5d6d6;
            }
            .sidebar{
                background: #eaeaea;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
        <div class="row m-0">
            <div class="col-md-3 p-0 sidebar">
                <ul class="nav">
                </ul>
            </div>
            <div class="col-md-9 main" style="height:100vh;overflow-y:scroll;">
            <article class="markdown-body col-md-12" itemprop="text">
                <h3>Demo</h3>
<p>Suppose, From `products` table to get ids <code>1 to 50</code> where product price range greater than <em>10</em> and less than <em>50</em>. Return only <code>title</code> and <code>price</code> column.</p><pre>
<code>id=1-50&where=product_price:>10,product_price:<50&return_only=title,price </code></pre>
                <p>Select a <code>table</code> name from table option and enter some query string with some <code>key</code> name are filter name as follows:</p>
                <h4><a id="user-content-id-key" class="anchor" aria-hidden="true" href="#id-key">
                    </a>id <em>(key)</em></h4>
                <p>Example <em>(value)</em>: <code>5</code> <code>5-100</code></p>
                <h4><a id="user-content-sort-key" class="anchor" aria-hidden="true" href="#sort-key">
                    </a>sort <em>(key)</em></h4>
                <p>Example <em>(value</em>: <code>email:asc</code> <code>name:desc</code>  <code>desc</code></p>
                <h4><a id="user-content-is-key" class="anchor" aria-hidden="true" href="#is-key">
                    </a>is <em>(key)</em></h4>
                <p>Example <em>(value)</em>: <code>active:0</code> <code>active:1</code>  <code>date:2020-04-29</code></p>
                <h4><a id="user-content-date-key" class="anchor" aria-hidden="true" href="#date-key">
                    </a>date <em>(key)</em></h4>
                <p>single date</p>
                <p>Example <em>(value)</em>: <code>updated_at:2020-04-29</code></p>
                <p>range of date</p>
                <p>Example <em>(value)</em>: <code>created_at:2020-04-19:2020-04-21</code></p>
                <h4><a id="user-content-lookup-key" class="anchor" aria-hidden="true" href="#lookup-key">
                    </a>lookup <em>(key)</em></h4>
                <p>for <em>variant</em>,</p>
                <ul>
                <li>use <code>!</code> for not match</li>
                <li>use <code>$</code> to specify string postion</li>
                <li>use <code>,</code> for <em>and</em> condition</li>
                <li>use <code>|</code> for <em>or</em> condition</li>
                </ul>
                <p>Example <em>(value)</em>:</p>
                <p><code>email:start$</code> <code>email:$end</code> <code>email:$anywhere$</code> <code>email:!$.com</code></p>
                <h4><a id="user-content-where-key" class="anchor" aria-hidden="true" href="#where-key">
                </a>where <em>(key)</em></h4>
                <p>for <em>variant</em>,</p>
                <ul>
                <li>use <code>!</code> for not equal</li>
                <li>use <code><</code> for less than</li>
                <li>use <code>></code> for greater than</li>
                <li>use <code>,</code> for <em>and</em> condition</li>
                <li>use <code>|</code> for <em>or</em> condition</li>
                </ul>
                <p>Example <em>(value)</em>:</p>
                <ul>
                <li><code>product_price:500</code> <code>discount:<20</code></li>
                <li><code>product_id:<200,product_price:>500</code></li>
                <li><code>product_price:<300|discount:>15</code></li>
                </ul>
                <h4><a id="user-content-join-key" class="anchor" aria-hidden="true" href="#join-key"></a>join <em>(key)</em></h4>
                <p>Example <em>(value)</em>:</p>
                <ul>
                        <li><code>initialTable:Column:firstTable:Column</code></li>
                </ul>
                <p><em>initialColumn=firstColumn</em> and <em>firstColumn=secondColumn</em></p>
                <ul>
                    <li><code>initialTable:Column:firstTable:Column,firstable:Column:secondTable:Column:</code></li>
                </ul>
                <blockquote>
                    <p><strong>Note</strong>: when use <strong>join</strong> Not to use any similar <code>column</code> name related filter
                    it will thrown error.</p>
                </blockquote>
                <h4><a id="user-content-return_only-key" class="anchor" aria-hidden="true" href="#return_only-key"></a>return_only <em>(key)</em></h4>
                <p>for <em>alias</em> use <code>@</code></p>
                <p>Example <em>(value)</em>:</p>
                <ul>
                <li><code>id,name,email</code> <code>name,email,phone</code></li>
                <li><code>id,name@user_name,email@user_email</code></li>
                <li><code>name@employee_name,phone@employee_phone</code></li>
                </ul>
                <h4><a id="user-content-return_except-key" class="anchor" aria-hidden="true" href="#return_except-key"></a>return_except <em>(key)</em></h4>
                <p>Example <em>(value)</em>:</p>
                <ul>
                <li><code>id,name,email</code> <code>name,email,phone</code></li>
                
                </ul>
                <h4>Delete</h4>
                <p>To delete your filtered data just pass <code>&delete</code></p>
                <h3>To Check Controller or Model or Other Method</h3>
                <p>Just type your Controller or Model or any other class name and method as</p>
                <pre><code>ClassName@method
                </code></pre>
                <p>If you had a more namespace from Controller or Model default namespace prefix, then pass those extra as <code>dot</code> notation.</p>
                <pre><code>ExtraNameSpace.ClassName@method
                </code></pre>
                <p>To pass parameter</p>
                <pre><code>App\User 5|string|58,hello,78|12:58:59
                </code></pre>
                <blockquote>
                    <p>Note: parameters are separated by <code>|</code>. Array parameter value are <code>,</code> seprated. Numeric string value will auto converted as <code>int</code> type value. This was also applicable for array.</p>
                    </blockquote>
                    <p>To pass <code>request</code> instance</p>
                    <pre><code>prop.width.px@45
prop.height.px@45
filter.date.start@2020-11-12
filter.date.end@2020-15-12
filter.search@lorem ipsum
filter.range.min@15,158,23
filter.range.max@68
filter.time@12:58:56
                    </code></pre>
                    <br>or<pre><code>
{
"husky": {
"hooks": {
"pre-commit": "npm test",
"pre-push": "npm test",
"...": "..."
}
}
}
                        </code></pre>
                    <h3>Return</h3>
                    <p>It will return a json with <code>log</code> and <code>data</code> . In <code>log</code> all database query,bindings and time are listed.If this method return any data,it will return with <code>data</code>.</p>
                    <blockquote>
                          Tip: you can test your request data from other tab by passing <code>request@dd</code>, <code>parameters</code> and <code>request</code>
                    </blockquote>
                </article>
            </div> 
        </div>
    </body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.js" integrity="sha256-bd8XIKzrtyJ1O5Sh3Xp3GiuMIzWC42ZekvrMMD4GxRg=" crossorigin="anonymous"></script>
    <script src='/vendor/dbpanel/js/app.js'></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.18.1/highlight.min.js" integrity="sha256-eOgo0OtLL4cdq7RdwRUiGKLX9XsIJ7nGhWEKbohmVAQ=" crossorigin="anonymous"></script>
</html>
