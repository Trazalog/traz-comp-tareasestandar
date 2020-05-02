function conexion() {
    return true;
}

function existFunction(nombre) {
    var fn = window[nombre];
    if(typeof fn === 'function')
    fn();
}