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
        <link rel="stylesheet" href='vendor/dbpanel/css/style.css' />
    </head>
    <body>
        <!-- developed by md.amirozzaman@gmail.com-->
        <div class="container-fluid"><div class="info-container shadow">
            <div class="info-btn" onclick="viewInfo()"></div>
            <ul class="nav nav-tabs pl-2 pt-2" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="help-tab" data-toggle="tab" href="#help" role="tab" aria-controls="help" aria-selected="false">How to Use</a>
                </li>
              </ul>
            <div class="tab-content p-2 active" style="background:#fff;" id="myTabContent">
                <div class="info-table tab-pane fade active show" id="help" role="tabpanel" aria-labelledby="help-tab">
                    <article class="markdown-body entry-content" itemprop="text">
                        <h1><a id="user-content-dbpanel" class="anchor" aria-hidden="true" href="#dbpanel"></a>dbpanel</h1>                                                                      
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
        </div><form class="row">
            <div class="col-md-3 p-0 sidebar">
                <ul class="nav nav-tabs pl-2 pt-2" id="mySideBarTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="controller-type-tab" data-toggle="tab" href="#controller-type" role="tab" aria-controls="controller-type" aria-selected="true">Controller</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="model-tab" data-toggle="tab" href="#model" role="tab" aria-controls="model" aria-selected="true">Model</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="other-tab" data-toggle="tab" href="#other" role="tab" aria-controls="model" aria-selected="true">Other</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="command-tab" data-toggle="tab" href="#command" role="tab" aria-controls="model" aria-selected="true">Command</a>
                      </li>
                </ul>
                <div class="tab-content p-2"  id="mySideBarTabContent">
                    <div class=" tab-pane fade show active" id="controller-type" role="tabpanel" aria-labelledby="controller-type-tab">
                        <div class="form-inline">
                            <input type="text" id="label" spellcheck="false" class="form-control" placeholder="save as...">
                            <input type="button" onclick="save()" class="btn btn-sm ml-1 mr-1" value="save">
                            <input type="button" onclick="load()" class="btn btn-sm" value="load">
                        </div>
                        <input type="text" id="controller-input" spellcheck="false" class="form-control mt-2" placeholder="Controller@method">
                        <small>Namespace: {{config('dbpanel.controller')}}</small>                       
                    </div>
                    <div class=" tab-pane fade" id="model" role="tabpanel" aria-labelledby="history-tab">
                        <input type="text" id="model-input" spellcheck="false" class="form-control mt-2" placeholder="model@method">
                        <small>Namespace: {{config('dbpanel.model')}}</small>                 
                    </div>
                    <div class=" tab-pane fade" id="other" role="tabpanel" aria-labelledby="history-tab">
                        <input type="text" id="other-input" spellcheck="false" class="form-control mt-2" value="request@dd" placeholder="other@method">
                        <small>Namespace: {{config('dbpanel.other')}}</small>
                    </div>
                    <div class="tab-pane fade" id="command" role="tabpanel" aria-labelledby="controller-type-tab">
                        <input type="text" id="command-input" spellcheck="false" class="form-control mt-2" placeholder="commands.....">
                        <small>For `php artisan route:list` need to pass `route:list`</small>        
                    </div>
                    <div class="form-group">
                        <input type="text" id="parameters" spellcheck="false" class="form-control mt-2" placeholder="parameters">
                    </div>
                    <div class="form-check mt-2">
                        <input type="checkbox" id="hadRequest" spellcheck="false" name="hadRequest" class="form-check-input mt-2">
                        <label class="form-check-label pt-1" for="hadRequest">Illuminate\Support\Request </label><br>
                        {{-- <input type="checkbox" id="otherRequest" spellcheck="false" name="otherRequest" class="form-check-input mt-2"> --}}
                    </div>    
                    <div class="form-group">
                        <input type="text" class="form-control mt-1" id="otherRequest" spellcheck="false" name="otherRequest" placeholder="custom request namespace....">
                    </div>
                    <div class="form-group">
                        <textarea id="request-parameter" spellcheck="false" rows="12" class="form-control mt-2" ></textarea>
                    </div>
                    <input type="text" id="dbpanel_auth_id" class="form-control mt-2" placeholder="auth user id...">
                    <input type="button" onclick="checkMethod()" class="btn btn-block mt-2" value="check">
                    <div class="mt-2">
                        developed by © <a href="http://me.amirozzaman.com">niaz@dev</a>
                    </div>
                </div>

            </div>
            <div class="col-md-9 row pt-2 main pr-0">
            <div class="col-md-12 row m-0 h-0">
                <div class="col-md-2 p-0">
                    <div class="input-group">                
                        <div class="input-group-prepend">
                            <div class="input-group-text">Table</div>
                        </div>
                        <select type="url" class="form-control brr-0" id="uri">
                        @foreach($tables as $key=>$table)
                            @foreach($table as $key=>$name)
                                <option>{{$name}}</option>
                            @endforeach
                        @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-2 p-0">
                    <div class="input-group">                
                        <div class="input-group-prepend">
                            <div class="input-group-text brr-0">Per Page</div>
                        </div>
                        <select class="form-control brr-0" id="per_page">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="25">25</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-7 p-0">
                    <div class="input-group">

                        <div class="input-group-prepend">
                            <div class="input-group-text brr-0">Query</div>
                        </div>
                        <input type="url" class="form-control brr-0" id="query" placeholder="filter your data table....">
                    </div>
                </div>
                <div class="col-md-1 p-0">
                    <input type="button" class="btn brl-0" onclick="getData()" value="Get Data">
                </div>
            </div>
            <div class="col-md-8 pr-0">
            <div class="form-group">
                <label class="header">
                    Console
                    <span class="badge ml-2" id="total"></span>
                    {{-- <div class="float-right">
                        <div class="btn">table</div>
                        <div class="btn">json</div>
                    </div> --}}
                    <div class="btn-open-file float-right d-none" id="open-file-in-editor" title="open file in editor" file-location="" onclick="openFileInEditor(this)">
                        open file
                    </div>
                </label>
              <pre spellcheck="false" class="window"><div id="data" class="p-2 shell"></div></pre>
            </div>
            <div class="col-md-12 pl-0">
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-right" style="height:60px;">
                      <li class="nav-item"><a class="nav-link"></a></li>
                    </ul>
                  </nav>
                </div>
        </div>
        <div class="col-md-4 pl-0 pr-0">
            <div class="form-group">
                <label class="header">Table</label>
                <pre spellcheck="false" class="window"><div id="table" class="p-2"></div></pre>
            </div>           
        </div>
    </div>
          </form>
        </div>
    </body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.js" integrity="sha256-bd8XIKzrtyJ1O5Sh3Xp3GiuMIzWC42ZekvrMMD4GxRg=" crossorigin="anonymous"></script>
    <script src='vendor/dbpanel/js/app.js'></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.18.1/highlight.min.js" integrity="sha256-eOgo0OtLL4cdq7RdwRUiGKLX9XsIJ7nGhWEKbohmVAQ=" crossorigin="anonymous"></script>
</html>