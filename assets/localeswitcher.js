var select = document.getElementById('vannut_localeswitcher');

select.addEventListener('change', function (e){
    e.preventDefault();
    var gekozen = select.options[select.selectedIndex];
    var locale = gekozen.value;

    var uri = window.btoa(gekozen.dataset.url);

    console.log(uri);
    window.location.href = '/switch_locale/'+locale+'/'+uri;


}, true)
