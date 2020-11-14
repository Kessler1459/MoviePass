function validarContraseña(){
    pass1 = document.getElementById('pass1');
    pass2 = document.getElementById('pass2');

    if (pass1.value != pass2.value) {
        document.getElementById("error").classList.add("mostrar");

        return false;
    } else {
        document.getElementById("error").classList.add("ocultar");
        document.getElementById("ok").classList.add("mostrar");
        document.getElementById("ok").disabled = true;

        $("#signIn").submit();

    }
}
    


    
