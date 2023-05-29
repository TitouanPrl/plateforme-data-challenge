
let selected;
    document.getElementById('valider').onclick = function() {
        var radios = document.getElementsByName('type');
        for (var radio of radios)
        {
            if (radio.checked) {
                selected = radio.value;
                var selectedRadio = '<?php echo $variable_php; ?>';
            }
        }
    }
 