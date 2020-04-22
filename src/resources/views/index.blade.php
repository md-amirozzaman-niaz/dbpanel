<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>niaz/dbpanel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
         <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
         {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.18.1/styles/a11y-dark.min.css" integrity="sha256-7L/IK7qUTcgTXtfLAxip5Eo+hnp+pSe5htBCh5pYg6o=" crossorigin="anonymous" /> --}}
         {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.18.1/styles/github-gist.min.css" integrity="sha256-xKngFRXh54wtbQtuYDjv4R5dJSjZAjRiq5u0dlUxAM0=" crossorigin="anonymous" /> --}}
         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.18.1/styles/github.min.css" integrity="sha256-iAmWN8uaUdN6Y9FCf8srQdrx3eVVwouJ5QtEiyuTQ6A=" crossorigin="anonymous" />
         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/fontawesome.min.css" integrity="sha256-CuUPKpitgFmSNQuPDL5cEfPOOJT/+bwUlhfumDJ9CI4=" crossorigin="anonymous" />
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
                background: #fdfdfd;
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
                height:60vh;
            }
            #table{
                height:60vh;
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
                background: #f8f8f8;
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
            .info-container{
                position: fixed;
                z-index: 12;
                background: #f2f2f2;
                border-left: 1px solid #999;
                padding: 15px;
                padding-top:0px;
                transition: 800ms;
                right: -79.5%;
                width: 80%;
            }
            .info-table{
                height: calc(100vh - 60px);
                overflow-y: scroll;
            }
            .info-container.active{
                right:0px;
            }
            .info-btn{
                position:absolute;
                width: 31px;
                padding: 0.62em;
                margin-top: 8px;
                margin-left: -46px;
                z-index: 15;
                cursor: pointer;
                background: #f2f2f2;
                border: 1px solid #9e9e9e;
                border-right: 0px;
                border-radius: 5px;
                border-bottom-right-radius: 0px;
                border-top-right-radius: 0px;
            }
            .page-item .page-link{
                background-color: #eff3f6;
                background-image: linear-gradient(-180deg,#fafbfc,#eff3f6 90%);
                color: #888;
            }
            .page-item.active .page-link {
                background-image:none;
                background-color: #5d646d;
                border-color: #454646;
            }
        </style>
    </head>
    <body>
        <div class="container-fluid"><div class="info-container shadow">
            <div class="info-btn" onclick="viewInfo()"><i class="fas fa-cogs"></i></div>
            <ul class="nav nav-tabs pl-2 pt-2" id="myTab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="data-type-tab" data-toggle="tab" href="#data-type" role="tab" aria-controls="data-type" aria-selected="true">Data type</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="modifier-tab" data-toggle="tab" href="#modifier" role="tab" aria-controls="modifier" aria-selected="false">Modifier</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="builder-tab" data-toggle="tab" href="#builder" role="tab" aria-controls="builder" aria-selected="false">Builder</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="facades-tab" data-toggle="tab" href="#facades" role="tab" aria-controls="facades" aria-selected="false">Facades</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="artisan-tab" data-toggle="tab" href="#artisan" role="tab" aria-controls="artisan" aria-selected="false">Artisan Commands</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="help-tab" data-toggle="tab" href="#help" role="tab" aria-controls="help" aria-selected="false">How to Use</a>
                </li>
              </ul>
            <div class="tab-content p-2" style="background:#fff;" id="myTabContent">
                <div class="info-table tab-pane fade show active" id="data-type" role="tabpanel" aria-labelledby="data-type-tab">
               
                    <table class="table table-striped">
                        <thead>
                        <tr>
                        <th>Command</th>
                        <th>Description</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">id</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>Alias of <code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">bigIncrements</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'id'</span><span class="token punctuation">)</span></code>.</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">foreignId</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'user_id'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>Alias of <code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">unsignedBigInteger</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'user_id'</span><span class="token punctuation">)</span></code>.</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">bigIncrements</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'id'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>Auto-incrementing UNSIGNED BIGINT (primary key) equivalent column.</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">bigInteger</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'votes'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>BIGINT equivalent column.</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">binary</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'data'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>BLOB equivalent column.</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">boolean</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'confirmed'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>BOOLEAN equivalent column.</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">char</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'name'</span><span class="token punctuation">,</span> <span class="token number">100</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>CHAR equivalent column with a length.</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">date</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'created_at'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>DATE equivalent column.</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">dateTime</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'created_at'</span><span class="token punctuation">,</span> <span class="token number">0</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>DATETIME equivalent column with precision (total digits).</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">dateTimeTz</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'created_at'</span><span class="token punctuation">,</span> <span class="token number">0</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>DATETIME (with timezone) equivalent column with precision (total digits).</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">decimal</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'amount'</span><span class="token punctuation">,</span> <span class="token number">8</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>DECIMAL equivalent column with precision (total digits) and scale (decimal digits).</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">double</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'amount'</span><span class="token punctuation">,</span> <span class="token number">8</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>DOUBLE equivalent column with precision (total digits) and scale (decimal digits).</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">enum</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'level'</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token single-quoted-string string">'easy'</span><span class="token punctuation">,</span> <span class="token single-quoted-string string">'hard'</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>ENUM equivalent column.</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">float</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'amount'</span><span class="token punctuation">,</span> <span class="token number">8</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>FLOAT equivalent column with a precision (total digits) and scale (decimal digits).</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">geometry</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'positions'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>GEOMETRY equivalent column.</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">geometryCollection</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'positions'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>GEOMETRYCOLLECTION equivalent column.</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">increments</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'id'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>Auto-incrementing UNSIGNED INTEGER (primary key) equivalent column.</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">integer</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'votes'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>INTEGER equivalent column.</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">ipAddress</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'visitor'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>IP address equivalent column.</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">json</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'options'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>JSON equivalent column.</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">jsonb</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'options'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>JSONB equivalent column.</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">lineString</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'positions'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>LINESTRING equivalent column.</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">longText</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'description'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>LONGTEXT equivalent column.</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">macAddress</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'device'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>MAC address equivalent column.</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">mediumIncrements</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'id'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>Auto-incrementing UNSIGNED MEDIUMINT (primary key) equivalent column.</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">mediumInteger</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'votes'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>MEDIUMINT equivalent column.</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">mediumText</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'description'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>MEDIUMTEXT equivalent column.</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">morphs</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'taggable'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>Adds <code class=" language-php">taggable_id</code> UNSIGNED BIGINT and <code class=" language-php">taggable_type</code> VARCHAR equivalent columns.</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">uuidMorphs</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'taggable'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>Adds <code class=" language-php">taggable_id</code> CHAR(36) and <code class=" language-php">taggable_type</code> VARCHAR(255) UUID equivalent columns.</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">multiLineString</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'positions'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>MULTILINESTRING equivalent column.</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">multiPoint</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'positions'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>MULTIPOINT equivalent column.</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">multiPolygon</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'positions'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>MULTIPOLYGON equivalent column.</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">nullableMorphs</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'taggable'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>Adds nullable versions of <code class=" language-php"><span class="token function">morphs</span><span class="token punctuation">(</span><span class="token punctuation">)</span></code> columns.</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">nullableUuidMorphs</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'taggable'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>Adds nullable versions of <code class=" language-php"><span class="token function">uuidMorphs</span><span class="token punctuation">(</span><span class="token punctuation">)</span></code> columns.</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">nullableTimestamps</span><span class="token punctuation">(</span><span class="token number">0</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>Alias of <code class=" language-php"><span class="token function">timestamps</span><span class="token punctuation">(</span><span class="token punctuation">)</span></code> method.</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">point</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'position'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>POINT equivalent column.</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">polygon</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'positions'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>POLYGON equivalent column.</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">rememberToken</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>Adds a nullable <code class=" language-php">remember_token</code> VARCHAR(100) equivalent column.</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">set</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'flavors'</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token single-quoted-string string">'strawberry'</span><span class="token punctuation">,</span> <span class="token single-quoted-string string">'vanilla'</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>SET equivalent column.</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">smallIncrements</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'id'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>Auto-incrementing UNSIGNED SMALLINT (primary key) equivalent column.</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">smallInteger</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'votes'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>SMALLINT equivalent column.</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">softDeletes</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'deleted_at'</span><span class="token punctuation">,</span> <span class="token number">0</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>Adds a nullable <code class=" language-php">deleted_at</code> TIMESTAMP equivalent column for soft deletes with precision (total digits).</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">softDeletesTz</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'deleted_at'</span><span class="token punctuation">,</span> <span class="token number">0</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>Adds a nullable <code class=" language-php">deleted_at</code> TIMESTAMP (with timezone) equivalent column for soft deletes with precision (total digits).</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">string</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'name'</span><span class="token punctuation">,</span> <span class="token number">100</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>VARCHAR equivalent column with a length.</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">text</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'description'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>TEXT equivalent column.</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">time</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'sunrise'</span><span class="token punctuation">,</span> <span class="token number">0</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>TIME equivalent column with precision (total digits).</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">timeTz</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'sunrise'</span><span class="token punctuation">,</span> <span class="token number">0</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>TIME (with timezone) equivalent column with precision (total digits).</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">timestamp</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'added_on'</span><span class="token punctuation">,</span> <span class="token number">0</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>TIMESTAMP equivalent column with precision (total digits).</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">timestampTz</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'added_on'</span><span class="token punctuation">,</span> <span class="token number">0</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>TIMESTAMP (with timezone) equivalent column with precision (total digits).</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">timestamps</span><span class="token punctuation">(</span><span class="token number">0</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>Adds nullable <code class=" language-php">created_at</code> and <code class=" language-php">updated_at</code> TIMESTAMP equivalent columns with precision (total digits).</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">timestampsTz</span><span class="token punctuation">(</span><span class="token number">0</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>Adds nullable <code class=" language-php">created_at</code> and <code class=" language-php">updated_at</code> TIMESTAMP (with timezone) equivalent columns with precision (total digits).</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">tinyIncrements</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'id'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>Auto-incrementing UNSIGNED TINYINT (primary key) equivalent column.</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">tinyInteger</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'votes'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>TINYINT equivalent column.</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">unsignedBigInteger</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'votes'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>UNSIGNED BIGINT equivalent column.</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">unsignedDecimal</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'amount'</span><span class="token punctuation">,</span> <span class="token number">8</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>UNSIGNED DECIMAL equivalent column with a precision (total digits) and scale (decimal digits).</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">unsignedInteger</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'votes'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>UNSIGNED INTEGER equivalent column.</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">unsignedMediumInteger</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'votes'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>UNSIGNED MEDIUMINT equivalent column.</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">unsignedSmallInteger</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'votes'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>UNSIGNED SMALLINT equivalent column.</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">unsignedTinyInteger</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'votes'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>UNSIGNED TINYINT equivalent column.</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">uuid</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'id'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>UUID equivalent column.</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">year</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'birth_year'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></td>
                        <td>YEAR equivalent column.</td>
                        </tr>
                        </tbody>
                        </table>
                </div>
                <div class="info-table tab-pane fade" id="modifier" role="tabpanel" aria-labelledby="modifier-tab">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                        <th>Modifier</th>
                        <th>Description</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                        <td><code class=" language-php"><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">after</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'column'</span><span class="token punctuation">)</span></code></td>
                        <td>Place the column "after" another column (MySQL)</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">autoIncrement</span><span class="token punctuation">(</span><span class="token punctuation">)</span></code></td>
                        <td>Set INTEGER columns as auto-increment (primary key)</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">charset</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'utf8'</span><span class="token punctuation">)</span></code></td>
                        <td>Specify a character set for the column (MySQL)</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">collation</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'utf8_unicode_ci'</span><span class="token punctuation">)</span></code></td>
                        <td>Specify a collation for the column (MySQL/PostgreSQL/SQL Server)</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">comment</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'my comment'</span><span class="token punctuation">)</span></code></td>
                        <td>Add a comment to a column (MySQL/PostgreSQL)</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token keyword">default</span><span class="token punctuation">(</span><span class="token variable">$value</span><span class="token punctuation">)</span></code></td>
                        <td>Specify a "default" value for the column</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">first</span><span class="token punctuation">(</span><span class="token punctuation">)</span></code></td>
                        <td>Place the column "first" in the table (MySQL)</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">nullable</span><span class="token punctuation">(</span><span class="token variable">$value</span> <span class="token operator">=</span> <span class="token boolean constant">true</span><span class="token punctuation">)</span></code></td>
                        <td>Allows (by default) NULL values to be inserted into the column</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">storedAs</span><span class="token punctuation">(</span><span class="token variable">$expression</span><span class="token punctuation">)</span></code></td>
                        <td>Create a stored generated column (MySQL)</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">unsigned</span><span class="token punctuation">(</span><span class="token punctuation">)</span></code></td>
                        <td>Set INTEGER columns as UNSIGNED (MySQL)</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">useCurrent</span><span class="token punctuation">(</span><span class="token punctuation">)</span></code></td>
                        <td>Set TIMESTAMP columns to use CURRENT_TIMESTAMP as default value</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">virtualAs</span><span class="token punctuation">(</span><span class="token variable">$expression</span><span class="token punctuation">)</span></code></td>
                        <td>Create a virtual generated column (MySQL)</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">generatedAs</span><span class="token punctuation">(</span><span class="token variable">$expression</span><span class="token punctuation">)</span></code></td>
                        <td>Create an identity column with specified sequence options (PostgreSQL)</td>
                        </tr>
                        <tr>
                        <td><code class=" language-php"><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">always</span><span class="token punctuation">(</span><span class="token punctuation">)</span></code></td>
                        <td>Defines the precedence of sequence values over input for an identity column (PostgreSQL)</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="info-table tab-pane fade" id="builder" role="tabpanel" aria-labelledby="builder-tab">
                    <table class="table table-striped">
                        <thead>
                            <th>
                                Namespace
                            </th>
                            <th>
                                Details
                            </th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Illuminate\Database\Eloquent\Builder</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Illuminate\Database\Query\Builder</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Illuminate\Database\Schema\Builder</td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="info-table tab-pane fade" id="facades" role="tabpanel" aria-labelledby="facades-tab">
                    <table class="table table-striped">
                        <thead>
                            <th>
                                Namespace
                            </th>
                            <th>
                                Details
                            </th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Illuminate\SUpport\Facades\DB</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Illuminate\SUpport\Facades\Schema</td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="info-table tab-pane fade" id="artisan" role="tabpanel" aria-labelledby="artisan-tab">
                    <table class="table table-striped">
                        <thead>
                            <th>
                                Commands
                            </th>
                            <th>
                                Details
                            </th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>php artisan migrate</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>php artisan db:seed</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>php artisan db:fresh</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>php artisan db:refresh</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>php artisan make:model</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>php artisan db:seeder</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>php artisan make:migration</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>php artisan migrate:rollback</td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="info-table tab-pane fade" id="help" role="tabpanel" aria-labelledby="help-tab">
                    <ul><li> return_col `id,name,email`, `name` </li>
                        <li> id `5` ,`5-100`</li>
                        <li>sort `asc`, `desc` </li>
                        <li> sort_col `name`, `email`</li>
                        <li> active `0`,`1`</li>
                        <li> date `2020-04-12`</li>
                        <li>end_date `2020-07-31`</li>
                        <li> date_col `date`, `created_at`, `updated_at`</li>
                        <li>lookup `gmail%`,`%gmail`, `%gmail%`, `!%.com%`</li>
                        <li>lookup_col `email`</li>
                        <li> per_page `5`, `10`, `25`</li>
                        <li> where `column_name`, `product_price`,`discount`,`total`, `product_id,product_price`</li>
                        <li>where_val `your_value`, `<50`,`>50`, `~100`, `435,>400`</li>
                    </ul></div>
            </div>
        </div><form class="row pt-2">
            <div class="col-md-12 row m-0">
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
                        <input type="url" class="form-control" id="query" value="id=20-24&return_col=id,name,email">
                    </div>
                </div>
                <div class="col-md-1 p-0">
                    <input type="button" class="btn" onclick="getData()" value="Get Data">
                </div>
            </div>
            <div class="col-md-8 mt-2 pr-0">
            <div class="form-group">
                <label>
                    Data
                    <span class="badge badge-primary ml-2" id="total"></span>
                    {{-- <div class="float-right">
                        <div class="btn">table</div>
                        <div class="btn">json</div>
                    </div> --}}
                </label>
              <pre spellcheck="false" class="window"><code id="data">No data</code></pre>
            </div>
            {{-- <div class="form-group"><iframe id="output" src=""></iframe></div> --}}
            <div class="col-md-12">
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                      
                    </ul>
                  </nav>
                </div>
        </div>
        <div class="col-md-4 mt-2">
            <div class="form-group">
                <label>Table</label>
                <pre spellcheck="false" class="window"><code id="table" class="json">No info</code></pre>
            </div>
            {{-- <div class="form-group">
                <label>Response <span class="badge badge-primary ml-2" id="response"></span></label>
                <pre spellcheck="false" class="window"><code id="request" class="json">No request</code></pre>
            </div> --}}
            
        </div>
          </form>
        </div>
    </body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.js" integrity="sha256-bd8XIKzrtyJ1O5Sh3Xp3GiuMIzWC42ZekvrMMD4GxRg=" crossorigin="anonymous"></script>
    <script>
    function setPagination(pageNo,total){
        let ulOfPagination = document.getElementsByClassName('pagination')[0];
        
        let li ='';
        
            if(!pageNo){
                ulOfPagination.innerHTML =null ;
                if(total>1){
                    if(total > 10){
                        for(i=1;i < 11;i++){
                            let activeClass = i==1 ? ' active' : '';
                            ulOfPagination.innerHTML += '<li class="page-item'+activeClass+'"><a class="page-link" onclick="getData('+i+')">'+i+'</a></li>';
                        }
                        ulOfPagination.innerHTML += '<li class="page-item"><a class="page-link" >...</a></li>';
                        ulOfPagination.innerHTML += '<li class="page-item"><a class="page-link" onclick="getData('+total+')">'+total+'</a></li>';
                        
                    }else{

                        for(i=1;i < total+1;i++){
                            let activeClass = i==1 ? ' active' : '';
                            ulOfPagination.innerHTML += '<li class="page-item'+activeClass+'"><a class="page-link" onclick="getData('+i+')">'+i+'</a></li>';
                        }
                    }
                } 
            }else{
                ulOfPagination.getElementsByClassName('active')[0].classList.remove('active');
                ulOfPagination.getElementsByClassName('page-item')[pageNo-1].classList.add('active');
            }
        
    }
    window.getData = function(pageNo=null){
        let url= "/"+document.getElementById('uri').value+"?"+document.getElementById('query').value+"&per_page="+document.getElementById('per_page').value+"&page="+pageNo;
        let dataDom = document.getElementById('data');
        let tableDom = document.getElementById('table');
        // let requestDom = document.getElementById('request');
        let totalDom = document.getElementById('total');
        // let responseDom = document.getElementById('response');
        dataDom.innerHTML=null;
        tableDom.innerHTML=null;
        // requestDom.innerHTML=null;
        totalDom.innerHTML='processing....';
        // responseDom.innerHTML='processing....';
        // document.getElementById('output').src=url;
        axios.post('/dbpanel'+url).then( 
            function(response){ 
                // console.log(response.data.result);
                dataDom.innerHTML=JSON.stringify(response.data.result.data, undefined, 4);
                tableDom.innerHTML=JSON.stringify(response.data.filter_status, undefined, 4);
                // requestDom.innerHTML=JSON.stringify(response.headers, undefined, 4);
                totalDom.innerHTML=response.data.total;
                // responseDom.innerHTML=response.status;
                hljs.highlightBlock(dataDom);
                hljs.highlightBlock(tableDom);
                setPagination(pageNo,response.data.result.last_page);
                // hljs.highlightBlock(requestDom);
            })
            .catch(
            function(error){
                dataDom.innerHTML='Error';
                // requestDom.innerHTML=JSON.stringify(error.message, undefined, 4);
                // hljs.highlightBlock(requestDom);
                
            });
    
    };
    // hljs.highlightBlock(document.querySelector('code'));
    function viewInfo(){
        event.stopPropagation();
        document.getElementsByClassName('info-container')[0].classList.toggle('active');
    }
    </script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script>
        $('#myTab a').on('click', function (e) {
            e.preventDefault();
            $(this).tab('show');
        })
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.18.1/highlight.min.js" integrity="sha256-eOgo0OtLL4cdq7RdwRUiGKLX9XsIJ7nGhWEKbohmVAQ=" crossorigin="anonymous"></script>
</html>