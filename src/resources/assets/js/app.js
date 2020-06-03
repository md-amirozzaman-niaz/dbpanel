import JSONFormatter from 'json-formatter-js'

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
            ulOfPagination.innerHTML += '<li class="page-item"><div class="d-flex"><input type="number" id="pageNumber" class="form-control brr-0" value=""><div class="btn brl-0" onclick="getDataFromGoTo()">Go</div></div></li>';
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
        function(error){
            dbpanelError(error.esponse.data);
        });

};
window.dbpanelBeforeProcess=function(){
    if(totalDom.innerText=='processing....'){
        console.log('one process is already runing');
        return true;
    }
}
window.dbpanelProcessing=function(){

    ulOfPagination.innerHTML= null ;
    dataDom.innerHTML=null;
    tableDom.innerHTML=null;
    totalDom.innerHTML='processing....';
    totalDom.classList.remove('badge-success');
    totalDom.classList.remove('badge-danger');
    totalDom.classList.add('badge-primary');
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
window.dbpanelSuccess =function(data){
    dataDom.innerHTML=null;
    if(data["Database log"] || data["request"]){
        let formatter = new JSONFormatter(data,1,{
            hoverPreviewEnabled: true
         });
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
    openFileDom.classList.contains('d-none')? false:openFileDom.classList.add('d-none');
    totalDom.classList.remove('badge-primary');
    totalDom.classList.add('badge-success');
}
window.dbpanelError = function(error){
    dataDom.innerHTML=null;
    if(error == 'Error: Network Error'){
        dataDom.innerHTML=error;
    }else{
    let fileLocation = error.file;
    let line=error.line;
    let formatter = new JSONFormatter(error,1,{
        hoverPreviewEnabled: true,theme:'dark'});
        dataDom.appendChild(formatter.render());
    let url=fileLocation+':'+line;
    openFileDom.setAttribute('file-location',url);
    openFileDom.classList.contains('d-none')? openFileDom.classList.remove('d-none'):false;
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
    let rData = requestParams.value.indexOf("{") === 0 ? requestParams.value :requestParams.value.replace(/\n/gi,'|');
    let param = params.value;
    param = document.getElementById('hadRequest').checked?param+'&hadRequest='+rData:param;
    param = dbpanel_auth_id?param+'&dbpanel_auth_id='+dbpanel_auth_id:param;
    dbpanelProcessing();
    let url='/dbpanel/controller/'+controller+'?parameters='+param;
    dbpanelProcessed(url);
}

window.model =function(){
    let model = document.getElementById('model-input').value.replace(/\\/gi,'.');

    let dbpanel_auth_id = document.getElementById('dbpanel_auth_id').value;
    let rData = requestParams.value.indexOf("{") === 0 ? requestParams.value :requestParams.value.replace(/\n/gi,'|');
    let param = params.value;
    param = document.getElementById('hadRequest').checked?param+'&hadRequest='+rData:param;
    param = dbpanel_auth_id?param+'&dbpanel_auth_id='+dbpanel_auth_id:param;
    dbpanelProcessing();
    let url='/dbpanel/model/'+model+'?parameters='+param;
    dbpanelProcessed(url);
}

window.other =function(){
    let other = document.getElementById('other-input').value.replace(/\\/gi,'.');
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
window.checkMethod =function(){
    if(dbpanelBeforeProcess()){
        return ;
    }
    let whichMethod = document.getElementById('mySideBarTab').getElementsByClassName('active')[0].innerText.trim().toLowerCase();
    if(whichMethod == 'controller'){
        window.controller();
    }else if(whichMethod == 'model'){
        window.model();
    }else if(whichMethod == 'command'){
        window.command();
    }else{
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