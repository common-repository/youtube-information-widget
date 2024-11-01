function helpToggle( elem ) {
    if ( elem.innerHTML == "Show help" )
        elem.innerHTML = "Hide help";
    else
        elem.innerHTML = "Show help";
    var elem2 = document.getElementsByClassName('yiw-help');
    elem2 = [].slice.call(elem2, 0);
    for (var i = 0; i < elem2.length; ++i)
      elem2[i].classList.toggle('yiw-help-vis');
}