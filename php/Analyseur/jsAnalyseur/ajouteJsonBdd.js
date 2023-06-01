function getXHR() {
    var xhr = null;
    if (window.XMLHttpRequest) {
        xhr = new XMLHttpRequest();
    } else if (window.ActiveXObject) { // IE < 7
        try {
            xhr = new ActiveXObject('Msxml2.XMLHTTP');
        } catch (e) {
            xhr = new ActiveXObject('Microsoft.XMLHTTP');
        }
    } else {
        alert('Votre navigateur ne supporte pas les objets XMLHttpRequest');
        xhr = false;
    }
    return xhr;
}
function ajouterDonnee() {
    var xhr = getXHR();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success) {
                location.reload();
            } else {
                console.error(response.message);
            }
        }
    };

    xhr.open('POST', 'ajoutAnalyse.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send();
}