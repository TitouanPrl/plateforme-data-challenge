
function selectType() {
    var xhr = getXHR();

    var type = document.getElementById("type");

    xhr.onreadystatechange = function() {

       if (xhr.readyState == 4 && xhr.status == 200){
        var stockAct = document.getElementById(maskName+"st").value -= maskNumber;

        var trElement = document.getElementById("fl"); 
        if (trElement) {
          trElement.parentNode.removeChild(trElement);
        }
       }
    }

    
    xhr.open("POST","newStock.php",true) ;
    xhr.setRequestHeader('Content-Type',
           'application/x-www-form-urlencoded;charset=utf-8');
    xhr.send("val1="+maskName+"&val2="+maskNumber);
    
  }