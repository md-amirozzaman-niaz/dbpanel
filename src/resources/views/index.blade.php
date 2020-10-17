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
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.18.1/styles/github.min.css"
        integrity="sha256-iAmWN8uaUdN6Y9FCf8srQdrx3eVVwouJ5QtEiyuTQ6A=" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/fontawesome.min.css"
        integrity="sha256-CuUPKpitgFmSNQuPDL5cEfPOOJT/+bwUlhfumDJ9CI4=" crossorigin="anonymous" />
    <link rel="stylesheet" href='vendor/dbpanel/css/style.css' />
</head>

<body>
    <!-- developed by md.amirozzaman@gmail.com-->
    <div class="container-fluid">
        <div class="info-container shadow">
            <div class="info-btn" onclick="viewInfo()"></div>
            <div class="tab-content m-2 active" id="myTabContent">
                <input type="url" id="address" onkeydown="loadRoute(event)" value="/dbpanel/doc"
                    class="form-control mr-2 mb-2">
                <div class="info-table tab-pane fade active show" id="help" role="tabpanel" aria-labelledby="help-tab">
                    <iframe src="/dbpanel/doc" id="webview"></iframe>
                </div>
            </div>
        </div>

        <form class="row">
            <div class="dbpanel-overlay"></div>
            <div class="col-md-3 p-0 sidebar focus-dom">
                <ul class="nav nav-tabs pl-2" id="mySideBarTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="controller-type-tab" data-toggle="tab" href="#controller-type"
                            role="tab" aria-controls="controller-type" aria-selected="true">Controller</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="route-type-tab" data-toggle="tab" href="#route-type"
                            role="tab" aria-controls="route-type" aria-selected="true">Route</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="model-tab" data-toggle="tab" href="#model" role="tab"
                            aria-controls="model" aria-selected="true">Model</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="other-tab" data-toggle="tab" href="#other" role="tab"
                            aria-controls="model" aria-selected="true">Other</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="namespace-tab" data-toggle="tab" href="#namespace" role="tab"
                            aria-controls="model" aria-selected="true">Namespace</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="command-tab" data-toggle="tab" href="#command" role="tab"
                            aria-controls="model" aria-selected="true">Command</a>
                    </li>
                </ul>
                <div class="tab-content p-2" id="mySideBarTabContent">
                    <div class=" tab-pane fade show active" id="controller-type" role="tabpanel"
                        aria-labelledby="controller-type-tab">
                        <div class="form-row mr-0 ml-0">
                            <input type="text" id="label" spellcheck="false" class="col form-control pl-2"
                                placeholder="label">
                            <div type="button" onclick="save()" class="btn btn-sm ml-1 mr-1" title="save">
                                <i class="far fa-bookmark" aria-hidden="true"></i>
                            </div>
                            <div type="button" onclick="loadToggle()" class="btn btn-sm" title="load">
                                <i class="far fa-folder-open" aria-hidden="true"></i>
                            </div>

                        </div>
                        <input type="text" onkeydown="callCheckMethod(event)" id="controller-input" spellcheck="false"
                            class="form-control mt-2 focus-in" placeholder="Controller@method">
                        <small>Namespace: {{config('dbpanel.controller')}}</small>
                    </div>
                    <div class=" tab-pane fade show" id="route-type" role="tabpanel"
                        aria-labelledby="route-type-tab">
                        <select name="route-method-input" id="route-method-input" class="form-control">
                            <option value="GET">GET</option>
                            <option value="POST">POST</option>
                            <option value="PATCH">PATCH</option>
                            <option value="PUT">PUT</option>
                            <option value="DELETE">DELETE</option>
                            <option value="ANY">ANY</option>
                        </select>
                        <input type="text" onkeydown="callCheckMethod(event)" id="route-input" spellcheck="false"
                            class="form-control mt-2" placeholder="your/route">
                    </div>
                    <div class=" tab-pane fade" id="model" role="tabpanel" aria-labelledby="history-tab">
                        <input type="text" id="model-input" onkeydown="callCheckMethod(event)" spellcheck="false"
                            class="form-control mt-2 focus-in" placeholder="model@method">
                        <small>Namespace: {{config('dbpanel.model')}}</small>
                    </div>
                    <div class=" tab-pane fade" id="other" role="tabpanel" aria-labelledby="history-tab">
                        <input type="text" id="other-input" onkeydown="callCheckMethod(event)" spellcheck="false"
                            class="form-control mt-2 focus-in" value="request@dd" placeholder="other@method">
                        <small>Namespace: {{config('dbpanel.other')}}</small>
                    </div>
                    <div class="tab-pane fade" id="command" role="tabpanel" aria-labelledby="controller-type-tab">
                        <input type="text" id="command-input" onkeydown="callCheckMethod(event)" spellcheck="false"
                            class="form-control mt-2 focus-in" placeholder="commands.....">
                        <small>For `php artisan route:list` need to pass `route:list`</small>
                    </div>
                    <div class="tab-pane fade" id="namespace" role="tabpanel" aria-labelledby="history-tab">
                        <input type="text" id="namespace-input" onkeydown="callCheckMethod(event)" spellcheck="false"
                            class="form-control mt-2 focus-in" value="Illuminate\Foundation\Application"
                            placeholder="Namespace or global methods name..">
                        <small>Namespace lookup</small>
                    </div>
                    <hr>
                    <div>
                        <input type="text" id="parameters" spellcheck="false" class="form-control mt-2 focus-in"
                            placeholder="parameters">
                    </div>
                    <div class="form-check mt-2">
                        <input type="checkbox" id="hadRequest" spellcheck="false" name="hadRequest"
                            class="form-check-input mt-2">
                        <label class="form-check-label pt-1" for="hadRequest">Illuminate\Http\Request </label><br>
                        {{-- <input type="checkbox" id="otherRequest" spellcheck="false" name="otherRequest" class="form-check-input mt-2"> --}}
                    </div>
                    <div>
                        <input type="text" class="form-control mt-1 focus-in" id="otherRequest" spellcheck="false"
                            name="otherRequest" placeholder="custom request namespace....">
                    </div>
                    <div>
                        <textarea id="request-parameter" spellcheck="false" rows="12"
                            class="form-control mt-2 focus-in"></textarea>
                    </div>
                    <input type="text" id="dbpanel_auth_id" class="form-control mt-1 focus-in"
                        placeholder="auth user id...">
                    <input type="button" onclick="checkMethod()" class="btn btn-block mt-2" value="check">
                    <div class="mt-2">
                        <b>dbpanel</b> <em>{{config('dbpanel.version')}}</em> - developed by © <a
                            href="http://me.amirozzaman.com">niaz@dev</a>
                    </div>
                </div>
                <div id="loadModal">
                    <div class="btn-primary btn-block p-2" onclick="loadToggle()">
                        <i class="fas fa-arrow-left"></i> Collection
                    </div>
                    <ul class="nav outer-list p-2">
                        @if(config()->has('dbpanel_collections'))
                        @foreach(config('dbpanel_collections') as $k=>$v)
                        <li onclick="activeToggle(this)">{{str_replace('App\Http\Controllers\\','',$k)}}
                            <span
                                class="badge badge-sm badge-secondary float-right">{{substr($k,strpos($k,'@'))}}</span>
                            <ul class="nav mt-1 inner-list">
                                @foreach($v as $ki=>$vi)
                                <li onclick="load(this)" data-key="{{$k.'.'.$ki}}">
                                    {{-- <i class="fas fa-arrow-left mr-1"></i> --}}
                                    <span
                                        class="badge badge-sm badge-primary float-right badge-{{$vi['label']}}">{{$vi['label']}}</span>
                                    <small> {{date("Y-m-d H:m A",$vi['created_at'])}}</small>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                        @endforeach
                        @endif
                    </ul>
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
                            <input type="url" onkeydown="callGetData(event)" class="form-control brr-0" id="query"
                                placeholder="each filter are separeted by '&' ">
                        </div>
                    </div>
                    <div class="col-md-1 p-0">
                        <input type="button" class="btn brl-0" onclick="getData()" value="Get Data">
                    </div>
                </div>
                <div class="col-md-8 pr-0 pt-2" style="height: calc(100vh - 80px);">
                    <div class="col-md-12 p-0">
                        <label class="header">
                            Console
                            <span class="badge ml-2" id="total"></span>
                            {{-- <div class="float-right">
                            <div class="btn">table</div>
                            <div class="btn">json</div>
                        </div> --}}
                            <div class="btn-open-file float-right d-none" id="open-file-in-editor"
                                title="open file in editor" file-location="" onclick="openFileInEditor(this)">
                                open file
                            </div>
                        </label>
                        <pre spellcheck="false" class="window mb-2"><div id="data" class="p-2 shell"></div></pre>
                    </div>
                    <div class="col-md-12 pl-0">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-right" style="height:20px;">
                                <li class="nav-item"><a class="nav-link"></a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-md-4 pl-0 pr-0 pt-2">
                    <div class="form-group">
                        <label class="header">Table</label>
                        <pre spellcheck="false" class="window"><div id="table" class="p-2"></div></pre>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"
    integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
<script src='vendor/dbpanel/js/app.js'></script>

</html>