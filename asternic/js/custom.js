// Format for ajax extra columns in DataTables search
// COLUMN_SEARCH_FORMAT

var columnFormat = {
    json: function(data,type,full,meta) {
        if(type=='display') {
           if(typeof(full.DATA)=='string') {
              content = '<table>';
              obj = JSON.parse(full.DATA);
              for(const key in obj) {
                 if(obj[key]!='') {
                     content+='<tr><td>'+key+'</td><td>'+obj[key]+'</td></tr>';
                 }
              }
              content+='</table>';
              return "<a class='dopopover' data-container='body' data-toggle='popover' data-content='"+content+"'>Notes <i class='fa fa-info-circle' style='font-size:1.4em'></i></a>";
           } else {
              return '';
           }
        } else {
           return full;
        }
    }
}

function ratecall(uni,file) {
   alert(uni);
}

function DivCreate(uni,file){
if($("#dialograte").length == 0){
var objeto="<div id='grabacrate'><object type='application/x-shockwave-flash' data='mp3player.swf' width='390' height='24'><param name='movie' value='mp3player.swf' /><param name='FlashVars' value='playerID=1&autostart=yes&soundFile=download.php?file="+file+"'></object></div>";
$("#xdistribution_detail").append("<div id='dialograte' title='Call Rating'>"+objeto+"<br>/usr/src/asternic-stats-pro-1.5-gtel/html/recordings/"+file+"</div>");
$("#dialograte").dialog({height:500,width:500,modal:true,buttons:{Ok:function(){$( this ).dialog("close"); }}});
}else{$("#dialograte").dialog("open");}
if(file.length == 0){$("#grabacrate").hide();}else{$("#grabacrate").show();}
}

function hola(cola,agente,canal,bridge,spycanal) {
  cola = atob(cola);
  agente = atob(agente);
  canal = atob(canal);
  bridge = atob(bridge);
  spycanal = atob(spycanal);

  console.log(cola);
  console.log(agente);
  console.log(canal);
  console.log(bridge);
  console.log(spycanal);
}
