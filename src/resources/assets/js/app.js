import JSONFormatter from 'json-formatter-js'

function setPagination(pageNo,total){
    let ulOfPagination = document.getElementsByClassName('pagination')[0];  
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
        }else{

            for(var i=1;i < total+1;i++){
                let activeClass = i==pageNo ? ' active' : '';
                ulOfPagination.innerHTML += '<li class="page-item'+activeClass+'"><a class="page-link" onclick="getData('+i+')">'+i+'</a></li>';
            }
        }
    }  
}
window.getData = function(pageNo=1){
    let url= document.getElementById('uri').value+"?"+document.getElementById('query').value+"&per_page="+document.getElementById('per_page').value+"&page="+pageNo;
    let dataDom = document.getElementById('data');
    let tableDom = document.getElementById('table');
    let totalDom = document.getElementById('total');
    dataDom.innerHTML=null;
    tableDom.innerHTML=null;
    totalDom.innerHTML='processing....';
    totalDom.classList.remove('badge-success');
    totalDom.classList.remove('badge-danger');
    totalDom.classList.add('badge-primary');
    axios.post('/dbpanel/database/'+url).then( 
        function(response){
          dataDom.innerHTML=null;
          let formatter = new JSONFormatter(response.data.result.data,1,{
            hoverPreviewEnabled: true});

          dataDom.appendChild(formatter.render());
           
            // dataDom.innerHTML=JSON.stringify(response.data.result.data, undefined, 4).replace(/</g,'&lt');
            // tableDom.innerHTML=JSON.stringify(response.data.filter_status, undefined, 4);
            // totalDom.innerHTML=response.data.total;
            let tbleaFormatter = new JSONFormatter(response.data.filter_status,1,{
              hoverPreviewEnabled: true});
  
              tableDom.appendChild(tbleaFormatter.render());
            // hljs.highlightBlock(dataDom);
            // hljs.highlightBlock(tableDom);
            totalDom.innerHTML='Success';
            totalDom.classList.remove('badge-primary');
            totalDom.classList.add('badge-success');
            setPagination(response.data.result.current_page,response.data.result.last_page);
        })
        .catch(
        function(error){

            dataDom.innerHTML=JSON.stringify(error.response.data, undefined, 4).replace(/\/\//g,'/');
            totalDom.innerHTML='Error';
            totalDom.classList.remove('badge-primary');
            totalDom.classList.add('badge-danger');    
        });

};
window.controller =function(){
    let controller = document.getElementById('controller-input').value;
    let request = document.getElementById('request-parameter').value.replace(/\n/gi,':');
    let param = document.getElementById('controller-parameter').value;
    let dbpanel_auth_id = document.getElementById('dbpanel_auth_id').value;
     param = document.getElementById('hadRequest').checked?param+'&hadRequest='+request:param;
    param = dbpanel_auth_id?param+'&dbpanel_auth_id='+dbpanel_auth_id:param;
    let dataDom = document.getElementById('data');
    let tableDom = document.getElementById('table');
    let totalDom = document.getElementById('total');
    let ulOfPagination = document.getElementsByClassName('pagination')[0];  
    ulOfPagination.innerHTML= null ;
    dataDom.innerHTML=null;
    tableDom.innerHTML=null;
    totalDom.innerHTML='processing....';
    totalDom.classList.remove('badge-success');
    totalDom.classList.remove('badge-danger');
    totalDom.classList.add('badge-primary');
    axios.get('/dbpanel/controller/'+controller+'?parameters='+param).then( 
        function(response){ 
            dataDom.innerHTML=null;
            let formatter = new JSONFormatter(response.data,2,{
              hoverPreviewEnabled: true});
              dataDom.appendChild(formatter.render());
            // dataDom.innerHTML=JSON.stringify(response.data, undefined, 4).replace(/</g,'&lt');
            // hljs.highlightBlock(dataDom);
            totalDom.innerHTML='Success';
            totalDom.classList.remove('badge-primary');
            totalDom.classList.add('badge-success');
        })
        .catch(
        function(exception){
            dataDom.innerHTML=JSON.stringify(exception.response.data, undefined, 4).replace(/\\\\/g,'\\');      
            totalDom.innerHTML='Error';
            totalDom.classList.remove('badge-primary');
            totalDom.classList.add('badge-danger');
        });
}

window.model =function(){
    let model = document.getElementById('model-input').value;
    let request = document.getElementById('request-parameter').value.replace(/\n/gi,':');
    let param = document.getElementById('model-parameter').value;
    let dbpanel_auth_id = document.getElementById('dbpanel_auth_id').value;
     param = document.getElementById('hadRequest').checked?param+'&hadRequest='+request:param;
    param = dbpanel_auth_id?param+'&dbpanel_auth_id='+dbpanel_auth_id:param;
    
    let dataDom = document.getElementById('data');
    let tableDom = document.getElementById('table');
    let totalDom = document.getElementById('total');
    let ulOfPagination = document.getElementsByClassName('pagination')[0];  
    ulOfPagination.innerHTML= null ;
    dataDom.innerHTML=null;
    tableDom.innerHTML=null;
    totalDom.innerHTML='processing....';
    totalDom.classList.remove('badge-success');
    totalDom.classList.remove('badge-danger');
    totalDom.classList.add('badge-primary');
    axios.get('/dbpanel/model/'+model+'?parameters='+param).then( 
        function(response){ 
          dataDom.innerHTML=null;
            let formatter = new JSONFormatter(response.data,4,{
              hoverPreviewEnabled: true});
              dataDom.appendChild(formatter.render());
            // dataDom.innerHTML=JSON.stringify(response.data, undefined, 4).replace(/</g,'&lt');
            // hljs.highlightBlock(dataDom);
            totalDom.innerHTML='Success';
            totalDom.classList.remove('badge-primary');
            totalDom.classList.add('badge-success');
        })
        .catch(
        function(exception){
            dataDom.innerHTML=JSON.stringify(exception.response.data, undefined, 4).replace(/\\\\/g,'\\');      
            totalDom.innerHTML='Error';
            totalDom.classList.remove('badge-primary');
            totalDom.classList.add('badge-danger');
        });
}
window.other =function(){
    let other = document.getElementById('other-input').value;
    let request = document.getElementById('request-parameter').value.replace(/\n/g,':');
    let param = document.getElementById('other-parameter').value;
    let dbpanel_auth_id = document.getElementById('dbpanel_auth_id').value;
     param = document.getElementById('hadRequest').checked?param+'&hadRequest='+request:param;
    param = dbpanel_auth_id?param+'&dbpanel_auth_id='+dbpanel_auth_id:param;
    let dataDom = document.getElementById('data');
    let tableDom = document.getElementById('table');
    let totalDom = document.getElementById('total');
    let ulOfPagination = document.getElementsByClassName('pagination')[0];  
    ulOfPagination.innerHTML= null ;
    dataDom.innerHTML=null;
    tableDom.innerHTML=null;
    totalDom.innerHTML='processing....';
    totalDom.classList.remove('badge-success');
    totalDom.classList.remove('badge-danger');
            totalDom.classList.add('badge-primary');
    axios.get('/dbpanel/other/'+other+'?parameters='+param).then( 
        function(response){ 
          dataDom.innerHTML=null;
          let formatter = new JSONFormatter(response.data,2,{
            hoverPreviewEnabled: true});
            dataDom.appendChild(formatter.render());
            // dataDom.innerHTML=JSON.stringify(response.data, undefined, 4).replace(/</g,'&lt');
            // hljs.highlightBlock(dataDom);
            totalDom.innerHTML='Success';
            totalDom.classList.remove('badge-primary');
            totalDom.classList.add('badge-success');
        })
        .catch(
        function(exception){
            dataDom.innerHTML=JSON.stringify(exception.response.data, undefined, 4).replace(/\\\\/g,'\\');      
            totalDom.innerHTML='Error';
            totalDom.classList.remove('badge-primary');
            totalDom.classList.add('badge-danger');
        });
}

window.command =function(){
    let command = document.getElementById('command-input').value;
    let dbpanel_auth_id = document.getElementById('dbpanel_auth_id').value;
    let param = dbpanel_auth_id?'?dbpanel_auth_id='+dbpanel_auth_id:'';
    let dataDom = document.getElementById('data');
    let tableDom = document.getElementById('table');
    let totalDom = document.getElementById('total');
    let ulOfPagination = document.getElementsByClassName('pagination')[0];  
    ulOfPagination.innerHTML= null ;
    dataDom.innerHTML=null;
    tableDom.innerHTML=null;
    totalDom.innerHTML='processing....';
    totalDom.classList.remove('badge-success');
    totalDom.classList.remove('badge-danger');
            totalDom.classList.add('badge-primary');
    axios.get('/dbpanel/command/'+command+param).then( 
        function(response){ 
          dataDom.innerHTML=null;
          let formatter = new JSONFormatter(response.data,2,{
            hoverPreviewEnabled: true});
            dataDom.appendChild(formatter.render());
            // dataDom.innerHTML=JSON.stringify(response.data, undefined, 4).replace(/</g,'&lt');
            // hljs.highlightBlock(dataDom);
            totalDom.innerHTML='Success';
            totalDom.classList.remove('badge-primary');
            totalDom.classList.add('badge-success');
        })
        .catch(
        function(exception){
            dataDom.innerHTML=JSON.stringify(exception.response.data, undefined, 4).replace(/\\\\/g,'\\');      
            totalDom.innerHTML='Error';
            totalDom.classList.remove('badge-primary');
            totalDom.classList.add('badge-danger');
        });
}
window.checkMethod =function(){
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