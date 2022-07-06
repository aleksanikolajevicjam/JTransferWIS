function showTheTable(page)
{

    if (page == 'next') {iPage += 1;}
    else if (page == 'prev') {iPage -= 1;}
    else {iPage = parseInt(page,10);}
    
    
    
    var srch = $("#searchFld").val();

    iDisplayLength = $("#pageLength").val();
   
    if (iPage <= 0) {iPage=0;}
    
    if (iPage > parseInt(iMaxPages,10)) {iPage=parseInt(iMaxPages,10);}
    
    var begin = parseFloat(iDisplayLength) * parseFloat(iPage);
    iStartRecord = parseFloat(iDisplayLength) * parseFloat(iPage);
 
    
    $("#t tbody").html('');
    $("#tableShow").html('');
    $.ajax({
        url: server + '?sSearch=' + srch +
        "&iDisplayStart=" + begin +
        "&iDisplayLength=" + iDisplayLength + sortingParams ,
        dataType: 'json',
        success: function(data){
            
                
            var htmlOut = '';
            $.each(data.aaData, function(index,value) {
                htmlOut +='<tr>';
                
                $.each(value, function(ind, val){
                    
                    if (ind == parseInt(hideField,10)) {htmlOut += '<td style="display:none">' + val + '</td>';}
                    else {htmlOut += '<td>' + val + '</td>';}
                });
                
                htmlOut += '</tr>';
            });
            
            $("#t tbody").append(htmlOut);
            
            $("#pagination").html(''+
            '<div class="btn-group">' +
            '<button id="prevButton" class="btn" onclick="showTheTable(\'prev\');">'+
            '<i class="icon icon-backward"></i></button>'+
            '&nbsp;' + '<div id="pageSelect" style="display:inline" xclass="btn"></div>' + '&nbsp;' +
            '<button id="nextButton" class="btn" onclick="showTheTable(\'next\');">'+
            '<i class="icon icon-forward"></i></button>' +
            '</div>'
            );
       

            iMaxPages = parseInt(data.iTotalDisplayRecords,10) / parseInt(iDisplayLength,10);
            
            $("#infoShow").html('<i class="icon icon-folder-open"></i> ' + data.iTotalDisplayRecords + ' | ' + 
            '<i class="icon icon-list"></i> ' +
            parseInt(begin+1,10) + '-' + parseInt(parseInt(begin,10)+parseInt(iDisplayLength,10),10) + 
            ' | <i class="icon icon-list-alt"></i> ' + parseInt(iPage+1,10) + '/' + parseInt(iMaxPages+1,10));
            
            var selHtml = '<select id="pageSelector" class="btn input-mini" onchange="showTheTable(this.value);">';
            for (var i=0;i<iMaxPages;i++)
            { 
                selHtml += '<option value="'+i+'"';
                if (i==iPage) {selHtml += ' selected="selected" ';}
                selHtml += '>'+parseInt(i+1,10)+'</option>';
            }
            
            selHtml += '</select>';
            $("#pageSelect").html(selHtml);

        }
             
    });
} 


    $("#searchFld").keyup(function(){
        showTheTable(0);
    });

    $("#pageLength").change(function(){
        showTheTable(0);
    });

showTheTable(0);
