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
            for(i=st;i < la;i++){
                let activeClass = i== pageNo ? ' active' : '';
                ulOfPagination.innerHTML += '<li class="page-item'+activeClass+'"><a class="page-link" onclick="getData('+i+')">'+i+'</a></li>';
            }
            if(la<total){
                ulOfPagination.innerHTML += '<li class="page-item"><a class="page-link" >...</a></li>';
                ulOfPagination.innerHTML += '<li class="page-item"><a class="page-link" onclick="getData('+total+')">'+total+'</a></li>';
            }
        }else{

            for(i=1;i < total+1;i++){
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
    axios.post('/dbpanel/database/'+url).then( 
        function(response){ 
            dataDom.innerHTML=JSON.stringify(response.data.result.data, undefined, 4).replace(/</g,'&lt');
            tableDom.innerHTML=JSON.stringify(response.data.filter_status, undefined, 4);
            totalDom.innerHTML=response.data.total;
            hljs.highlightBlock(dataDom);
            hljs.highlightBlock(tableDom);
            setPagination(response.data.result.current_page,response.data.result.last_page);
        })
        .catch(
        function(error){
            dataDom.innerHTML=JSON.stringify(error.response.data, undefined, 4).replace(/\/\//g,'/');
            totalDom.innerHTML='';       
        });

};
window.controller =function(){
    let controller = document.getElementById('controller-input').value;
    let param = document.getElementById('controller-parameter').value;
    let dataDom = document.getElementById('data');
    axios.get('/dbpanel/controller/'+controller+'?parameters='+param).then( 
        function(response){ 
            dataDom.innerHTML=JSON.stringify(response.data, undefined, 4).replace(/</g,'&lt');
            hljs.highlightBlock(dataDom);
        })
        .catch(
        function(exception){
            dataDom.innerHTML=JSON.stringify(exception.response.data, undefined, 4).replace(/\\\\/g,'\\');      
        });
}
function viewInfo(){
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