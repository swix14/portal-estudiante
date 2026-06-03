function validacion(){
    if(document.getElementById('rut').value==''){
        alert('Por favor ingrese un RUT');
        document.getElementById('rut').focus();
        return false;
    }

    if(document.getElementById('pass').value==''){
        alert('La contraseña no puede quedar vacia');
        document.getElementById('pass').focus(); // actualizar para apuntar al campo 'pass'
        return false;
    }

    numero=document.getElementById("rut").value;
    valida=parseInt(numero);

    if(isNaN(valida)){
        alert("el campo Rut es incorrecto.");
        document.getElementById("rut").focus(); 
        return false;
    }



}


function validacionCorreo(){
    if(document.getElementById('correo').value==''){
        alert('Por favor ingrese un correo ');
        document.getElementById('rut').focus();
        return false;
    }

    if(document.getElementById('pass').value==''){
        alert('La contraseña no puede quedar vacia');
        document.getElementById('pass').focus(); // actualizar para apuntar al campo 'pass'
        return false;
    }


}

