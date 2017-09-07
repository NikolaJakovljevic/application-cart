
function ajaxCall(data,url,callback,method, upload)
{
    method = typeof method !== 'undefined' ? method : "POST";
    upload = typeof upload !== 'undefined' ? upload : false;
    if(upload === true){
        var parameters = {
            url : url,//"products/allProductsByCategory/1/1/Exterior",
            type: method,
            data : data,
            processData: false,
            contentType: false,
            success: function(data, textStatus, jqXHR)
            {
                //data - response from server
                callback(data);
            },
            error: function (jqXHR, textStatus, errorThrown)
            {

            }
        }
    }else{
        var parameters = {
            url : url,//"products/allProductsByCategory/1/1/Exterior",
            type: method,
            data : data,
            success: function(data, textStatus, jqXHR)
            {
                //data - response from server
                callback(data);
            },
            error: function (jqXHR, textStatus, errorThrown)
            {

            }
        }
    }
    $.ajax(
        parameters
    );
}

function enableButtons()
{
    $('#categories').removeClass('action-disabled');
    $('#subcategories').removeClass('action-disabled');
    $('#products').removeClass('action-disabled');
    $('.footer-table div').removeClass('action-disabled');
}

function disableButtons()
{
    $('#categories').addClass('action-disabled');
    $('#subcategories').addClass('action-disabled');
    $('#products').addClass('action-disabled');
    $('.footer-table div').addClass('action-disabled');
}

