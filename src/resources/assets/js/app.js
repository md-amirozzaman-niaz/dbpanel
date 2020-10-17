import JSONFormatter from 'json-formatter-js'
import $ from "jquery";
import 'bootstrap';
const axios = require('axios').default;
const Vue = require('vue').default;
import hljs from 'highlight.js';


const dataDom = document.getElementById('data');
const totalDom = document.getElementById('total');
const tableDom = document.getElementById('table');
const ulOfPagination = document.getElementsByClassName('pagination')[0];
const requestParams = document.getElementById('request-parameter');
const params = document.getElementById('parameters');
const openFileDom=document.getElementById('open-file-in-editor');

function setPagination(pageNo,total){
    ulOfPagination.innerHTML =null ;
    if(total>1){
        if(total > 10){
            let st = pageNo-4 >  1 ? pageNo - 3 : 1;
            let la = pageNo+4 > total ? total+1 : pageNo+4 ;
            if(pageNo- 4 >  1){
                ulOfPagination.innerHTML += '<li class="page-item"><a class="page-link" onclick="getData('+1+')">'+1+'</a></li>';
                ulOfPagination.innerHTML += '<li class="page-item"><a class="page-link" >...</a></li>';
            }
            for(var i=st;i < la;i++){
                let activeClass = i== pageNo ? ' active' : '';
                ulOfPagination.innerHTML += '<li class="page-item'+activeClass+'"><a class="page-link" onclick="getData('+i+')">'+i+'</a></li>';
            }
            if(la<total){
                ulOfPagination.innerHTML += '<li class="page-item"><a class="page-link" >...</a></li>';
                ulOfPagination.innerHTML += '<li class="page-item"><a class="page-link" onclick="getData('+total+')">'+total+'</a></li>';
            }
            ulOfPagination.innerHTML += '<li class="page-item"><div class="d-flex"><input type="number" onkeydown="callGo(event)" id="pageNumber" class="form-control brr-0" value=""><div class="btn brl-0"  onclick="getDataFromGoTo()">Go</div></div></li>';
        }else{

            for(var i=1;i < total+1;i++){
                let activeClass = i==pageNo ? ' active' : '';
                ulOfPagination.innerHTML += '<li class="page-item'+activeClass+'"><a class="page-link" onclick="getData('+i+')">'+i+'</a></li>';
            }
        }
    }  
}
  
window.getData = function(pageNo=1){
    if(dbpanelBeforeProcess()){
        return ;
    }
    let url= document.getElementById('uri').value+"?"+document.getElementById('query').value+"&per_page="+document.getElementById('per_page').value+"&page="+pageNo;
    dbpanelProcessing();
    axios.post('/dbpanel/database/'+url).then( 
        function(response){
          dataDom.innerHTML=null;
          let formatter = new JSONFormatter(response.data.result.data,1,{
            hoverPreviewEnabled: true});

          dataDom.appendChild(formatter.render());
           
            let tbleaFormatter = new JSONFormatter(response.data.filter_status,1,{
              hoverPreviewEnabled: true});
  
              tableDom.appendChild(tbleaFormatter.render());
            totalDom.innerHTML='Success';
            totalDom.classList.remove('badge-primary');
            totalDom.classList.add('badge-success');
            setPagination(response.data.result.current_page,response.data.result.last_page);
        })
        .catch(
        function(exception){
            if(exception["response"]){
                dbpanelError(exception.response.data);
            }else{
                dbpanelError(exception);
            }
        });

};
window.dbpanelBeforeProcess=function(){
    if(totalDom.innerText=='processing....'){
        console.log('one process is already runing');
        return true;
    }
}
window.dbpanelProcessing=function(){
    $('.dbpanel-overlay').removeClass('d-block');
    dataDom.innerHTML=null;
    tableDom.innerHTML=null;
    totalDom.innerHTML='processing....';
    totalDom.classList.remove('badge-success');
    totalDom.classList.remove('badge-danger');
    totalDom.classList.add('badge-primary');
    openFileDom.classList.contains('d-none')? false:openFileDom.classList.add('d-none');
}
window.dbpanelProcessed=function(url){

    axios.get(url).then( 
        function(response){ 
            if(response['data']){
                dbpanelSuccess(response.data);
            }else{
                dbpanelSuccess(response); 
            }
        })
        .catch(
        function(exception){
            if(exception["response"]){
                dbpanelError(exception.response.data);
            }else{
                dbpanelError(exception);
            }
        });

}
window.loadRoute=function(event){
    if(event.keyCode === 13){
        let url =document.getElementById('address').value;
        if(url !=="/dbpanel"){
            let data = {'Url':url};
            changeRoute(data);
        }
    }
}
window.callGo=function(event){
    if(event.keyCode === 13){
        getDataFromGoTo();
    }
}
window.callCheckMethod=function(event){
    if(event.keyCode === 13){
        checkMethod();
    }
}
window.callGetData=function(event){
    if(event.keyCode === 13){
        getData();
    }
}
window.changeRoute=function(data){
    document.getElementById('webview').src = data.Url;
        document.getElementById('address').value = data.Url;
}
window.dbpanelSuccess =function(data){
    dataDom.innerHTML=null;
    if(data["Database log"] || data["request"]){
        let formatter = new JSONFormatter(data,1,{
            hoverPreviewEnabled: true
         });
        dataDom.appendChild(formatter.render());
        if(data['Url'] &&  data['Url'] !=='no route'){
            changeRoute(data);
        }
    }
    else if (typeof data === "object") {
        var formatter = new json_formatter_js__WEBPACK_IMPORTED_MODULE_0___default.a(
            data,
            1,
            {
                hoverPreviewEnabled: true
            }
        );
        dataDom.appendChild(formatter.render());
    }
    else if(data.indexOf("sf-dump") > -1 ) {
        dataDom.innerHTML=data;
    }
    else if(data.indexOf("</") > -1 ){
        dataDom.innerHTML='custom response';
    }
    else{
         dataDom.innerHTML=data;
        // hljs.highlightBlock(dataDom);   
    }
    totalDom.innerHTML='Success';
    totalDom.classList.remove('badge-primary');
    totalDom.classList.add('badge-success');
}
window.dbpanelError = function(error){
    dataDom.innerHTML=null;
    if(error == 'Error: Network Error'){
        dataDom.innerHTML=error;
    }else{
   
    let formatter = new JSONFormatter(error,1,{
        hoverPreviewEnabled: true,theme:'dark'});
        dataDom.appendChild(formatter.render());
    if(error['file']){
        let fileLocation = error.file;
        let line=error.line;
        let url=fileLocation+'&line='+line;
        openFileDom.setAttribute('file-location',url);
        openFileDom.classList.contains('d-none')? openFileDom.classList.remove('d-none'):false;
    }
    }
    totalDom.innerHTML='Error';
    totalDom.classList.remove('badge-primary');
    totalDom.classList.add('badge-danger');
}
window.openFileInEditor=function(el){
    let param= el.getAttribute('file-location');
    axios.get('/__open-in-editor?file='+param).then( 
        function(response){
            console.log('file opened');
        }).catch(function(error){ console.log(error)})
}
window.controller =function(){
    
    let controller = document.getElementById('controller-input').value.replace(/\\/gi,'.');
    let dbpanel_auth_id = document.getElementById('dbpanel_auth_id').value;
    let dbpanel_custom_namespace = document.getElementById("otherRequest").value;
    let rData = requestParams.value.indexOf("{") === 0 ? requestParams.value :requestParams.value.replace(/^\s+|\s+$/g, '').replace(/\n/gi,'|');
    let param = params.value;
    param = document.getElementById('hadRequest').checked?param+'&hadRequest='+rData +"&dbpanel_custom_namespace=" +dbpanel_custom_namespace:param;
    param = dbpanel_auth_id?param+'&dbpanel_auth_id='+dbpanel_auth_id:param;
    dbpanelProcessing();
    let url='/dbpanel/controller/'+controller+'?parameters='+param;
    dbpanelProcessed(url);
}

window.model =function(){
    let model = document.getElementById('model-input').value.replace(/\\/gi,'.');

    let dbpanel_auth_id = document.getElementById('dbpanel_auth_id').value;
    let rData = requestParams.value.indexOf("{") === 0 ? requestParams.value :requestParams.value.replace(/^\s+|\s+$/g, '').replace(/\n/gi,'|');
    let param = params.value;
    param = document.getElementById('hadRequest').checked?param+'&hadRequest='+rData:param;
    param = dbpanel_auth_id?param+'&dbpanel_auth_id='+dbpanel_auth_id:param;
    dbpanelProcessing();
    let url='/dbpanel/model/'+model+'?parameters='+param;
    dbpanelProcessed(url);
}
window.save=function(){
    let controller = document.getElementById('controller-input').value;
    let label = document.getElementById('label').value;
    let dbpanel_auth_id = document.getElementById('dbpanel_auth_id').value;
    let dbpanel_custom_namespace = document.getElementById("otherRequest").value;
    let rData = requestParams.value.indexOf("{") === 0 ? requestParams.value.replace( /  +/g, ' ' ) :requestParams.value.replace(/^\s+|\s+$/g, '').replace(/\n/gi,'|');
    let param = params.value;
    param +='&hadRequest='+rData +"&dbpanel_custom_namespace=" +dbpanel_custom_namespace+"&label="+label;
    param +='&dbpanel_auth_id='+dbpanel_auth_id;
    dbpanelProcessing();
    let url='/dbpanel/save?controller='+controller+'&parameters='+param;
    dbpanelProcessed(url);
}
window.loadToggle=function(){
    let modal = document.getElementById('loadModal');
    modal.classList.toggle('active');
}
window.activeToggle=function(el){
    el.classList.toggle('active');
}
window.load=function(v){
    let url='/dbpanel/load?controller='+v.getAttribute('data-key');  
    axios.get(url).then( 
        function(response){ 
            document.getElementById('label').value=response.data['label'];
            document.getElementById('controller-input').value=response.data['controller'];
            document.getElementById('dbpanel_auth_id').value=response.data['dbpanel_auth_id'] ? response.data['dbpanel_auth_id'] :'';
            document.getElementById('hadRequest').checked=response.data['hadRequest']?true:false;
            if(response.data['hadRequest']){
                requestParams.value=response.data['hadRequest'].indexOf("{") === 0 ? JSON.stringify(JSON.parse(response.data['hadRequest']), undefined, 4) :response.data['hadRequest'].replace(/\|/gi,'\n');;
            }else{
                requestParams.value='';
            }
            params.value=response.data['parameters'] ? response.data['parameters'] :'';
            document.getElementById("otherRequest").value=response.data['dbpanel_custom_namespace'] ? response.data['dbpanel_custom_namespace'] :'';
            setTimeout(()=>{
                loadToggle();
                controller();
            },300);
        })
        .catch(
        function(exception){
            if(exception["response"]){
                dbpanelError(exception.response.data);
            }else{
                dbpanelError(exception);
            }
        });
}

window.other =function(namespace=null){
    let other = namespace ? document.getElementById('namespace-input').value.replace(/\\/gi,'.'):document.getElementById('other-input').value.replace(/\\/gi,'.');
    let dbpanel_auth_id = document.getElementById('dbpanel_auth_id').value;
    let rData = requestParams.value.indexOf("{") === 0 ? requestParams.value :requestParams.value.replace(/\n/gi,'|');
    let param = params.value;
    param = document.getElementById('hadRequest').checked?param+'&hadRequest='+rData:param;
    param = dbpanel_auth_id?param+'&dbpanel_auth_id='+dbpanel_auth_id:param;

    dbpanelProcessing();
    let url='/dbpanel/other/'+other+'?parameters='+param;
    dbpanelProcessed(url);
}

window.command =function(){
    let command = document.getElementById('command-input').value;
    let dbpanel_auth_id = document.getElementById('dbpanel_auth_id').value;
    let param = dbpanel_auth_id?'?dbpanel_auth_id='+dbpanel_auth_id:'';
    dbpanelProcessing();
    let url='/dbpanel/command/'+command+param;
    dbpanelProcessed(url);
}
window.route= function(){
    let uri = document.getElementById('route-input').value;
    let method = document.getElementById('route-method-input').value;
    dbpanelProcessing();
    let url='/dbpanel/route?uri='+uri+'&method='+method;
    dbpanelProcessed(url);
}
window.checkMethod =function(){
    if(dbpanelBeforeProcess()){
        return ;
    }
    ulOfPagination.innerHTML= null ;
    let whichMethod = document.getElementById('mySideBarTab').getElementsByClassName('active')[0].innerText.trim().toLowerCase();
    if(whichMethod == 'controller'){
        window.controller();
    }else if(whichMethod == 'model'){
        window.model();
    }else if(whichMethod == 'command'){
        window.command();
    }else if(whichMethod == 'namespace'){
        window.other('namespace');
    }else if(whichMethod == 'route'){
        window.route();
    }
    else{
        window.other();
    }
}
window.getDataFromGoTo=function(){
    let p =document.getElementById('pageNumber').value;
    window.getData(p);
}
window.viewInfo=function(){
    event.stopPropagation();
    document.getElementsByClassName('info-container')[0].classList.toggle('active');
}

document.addEventListener('DOMContentLoaded', (event) => {
    document.querySelectorAll('pre code').forEach((block) => {
        hljs.highlightBlock(block);
    });
});
document.addEventListener('DOMContentLoaded', (event) => {
    document.querySelectorAll('td code').forEach((block) => {
        hljs.highlightBlock(block);
    });
});

$( document ).ready($('.focus-in').on('focus',function(){
    if(!$('.dbpanel-overlay').hasClass('d-block')){
        $('.dbpanel-overlay').addClass('d-block');
    }
}));

$( document ).ready($('.dbpanel-overlay').on('click',function(){
    $('.dbpanel-overlay').removeClass('d-block');
}));
