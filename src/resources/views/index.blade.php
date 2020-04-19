<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
         <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
         {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.18.1/styles/a11y-dark.min.css" integrity="sha256-7L/IK7qUTcgTXtfLAxip5Eo+hnp+pSe5htBCh5pYg6o=" crossorigin="anonymous" /> --}}
         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.18.1/styles/github-gist.min.css" integrity="sha256-xKngFRXh54wtbQtuYDjv4R5dJSjZAjRiq5u0dlUxAM0=" crossorigin="anonymous" />
         {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.18.1/styles/github.min.css" integrity="sha256-iAmWN8uaUdN6Y9FCf8srQdrx3eVVwouJ5QtEiyuTQ6A=" crossorigin="anonymous" /> --}}
        <style>
            label{
                padding: 16px;
                background-color: #f6f8fa;
                border: 1px solid #d1d5da;
                border-top-left-radius: 3px;
                border-top-right-radius: 3px;
                width: 100%;
                margin-bottom: 0px;
            }
            body{
                background: #f8f8f8;
    font-family: monospace;
    font-size:12px;
            }
            #output{
                height:70vh;
                width:100%;
                border:none;

            }
            #uri{
                border-left: 1px solid #e3e3e3;
            }
            #data{
                height:70vh;
            }
            #table{
                height:35vh;
            }
            #query{
                border-radius: 0;
            }
            #request{
                height: calc(35vh - 66px);
            }
            .btn{

                /* background: -webkit-linear-gradient(#fafafa, #f4f4f4 40%, #e5e5e5); */
                background: aliceblue;
                color: #24292e;
                background-color: #eff3f6;
                background-image: linear-gradient(-180deg,#fafbfc,#eff3f6 90%);
                font-size: 13px;
                padding: 7px;
            }
            .brr-0{
                border-radius: 0 !important;
                border-left: 0px;
            }
            .window{
                border: 1px solid #ced4da;
                padding: 10px;
                background: #fff;
                border-top: 0px;
                border-bottom-left-radius: 3px;
                border-bottom-right-radius: 3px;
            }
            .input-group-text{
                color: #24292e;
    background-color: #eff3f6;
    background-image: linear-gradient(-180deg,#fafbfc,#eff3f6 90%);
    font-size: 13px;
    
            }
            .form-control{
                font-size:14px;
            }
            .btn{
                border: 1px solid #d2d2d2;
                border-left: 0px;
                border-top-left-radius: 0px;
                border-bottom-left-radius: 0px;
                color: #24292e;
                background-color: #eff3f6;
                background-image: linear-gradient(-180deg,#fafbfc,#eff3f6 90%);
                font-size: 13px;
                padding: 7px;
            }
        </style>
    </head>
    <body>
        <div class="container-fluid">       
        <form class="row pt-2">
            <div class="col-md-12 row m-0">
                <div class="col-md-2 p-0">    <div class="input-group">                
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
            </div>  <div class="col-md-9 p-0">
            <div class="input-group">

                <div class="input-group-prepend">
                    <div class="input-group-text brr-0">Query</div>
                </div>
                <input type="url" class="form-control" id="query" value="id=20-24&return_col=id,name,email">
            </div>
        </div>
            <div class="col-md-1 p-0">
            <input type="button" class="btn btn-block" onclick="getData()" value="Get Data"></div>
        </div><div class="col-md-8 mt-2 pr-0">
            <div class="form-group">
                <label>Data<span class="badge badge-primary ml-2" id="total"></span></label>
              <pre spellcheck="false" class="window"><code id="data">No data</code></pre>
            </div>
            {{-- <div class="form-group"><iframe id="output" src=""></iframe></div> --}}
        </div>
        <div class="col-md-4 mt-2">
            <div class="form-group">
                <label>Table</label>
                <pre spellcheck="false" class="window"><code id="table" class="json">No info</code></pre>
            </div>
            <div class="form-group">
                <label>Response <span class="badge badge-primary ml-2" id="response"></span></label>
                <pre spellcheck="false" class="window"><code id="request" class="json">No request</code></pre>
            </div>
            
        </div>
          </form>
        </div>
    </body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.js" integrity="sha256-bd8XIKzrtyJ1O5Sh3Xp3GiuMIzWC42ZekvrMMD4GxRg=" crossorigin="anonymous"></script>
    <script>window.getData = function(){
        let url= "/"+document.getElementById('uri').value+"?"+document.getElementById('query').value;
        let dataDom = document.getElementById('data');
        let tableDom = document.getElementById('table');
        let requestDom = document.getElementById('request');
        let totalDom = document.getElementById('total');
        let responseDom = document.getElementById('response');
        dataDom.innerHTML=null;
        tableDom.innerHTML=null;
        requestDom.innerHTML=null;
        totalDom.innerHTML='processing....';
        responseDom.innerHTML='processing....';
        // document.getElementById('output').src=url;
        axios.post('/dbpanel'+url).then( 
            function(response){ 
                dataDom.innerHTML=JSON.stringify(response.data.result, undefined, 4);
                tableDom.innerHTML=JSON.stringify(response.data.filter_status, undefined, 4);
                requestDom.innerHTML=JSON.stringify(response.headers, undefined, 4);
                totalDom.innerHTML=response.data.total;
                responseDom.innerHTML=response.status;
                hljs.highlightBlock(dataDom);
                hljs.highlightBlock(tableDom);
                hljs.highlightBlock(requestDom);
            })
            .catch(
            function(error){
                dataDom.innerHTML='Error';
                requestDom.innerHTML=JSON.stringify(error.message, undefined, 4);
                hljs.highlightBlock(requestDom);
                hljs.highlightBlock(document.querySelector('code'));
            });
    
    };</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.18.1/highlight.min.js" integrity="sha256-eOgo0OtLL4cdq7RdwRUiGKLX9XsIJ7nGhWEKbohmVAQ=" crossorigin="anonymous"></script>
</html>