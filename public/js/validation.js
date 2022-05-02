/*
*   Sección validaciones frontend
*   Use Only JS please
*/


const validarTelefono = (input) => {
    if(input.value.length != 7){
        input.focus()
        // 'Debe ser un numero telefonico debe ser de 7 digitos!'
        return false
    }
    return true
}

function filterFloat(evt,input){
    // Barraespaciadora = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
    var key = window.Event ? evt.which : evt.keyCode;    
    var chark = String.fromCharCode(key);
    var tempValue = input.value+chark;
    if(key >= 48 && key <= 57){
        if(filter(tempValue)=== false){
            return false;
        }else{       
            return true;
        }
    }else{
          if(key == 8 || key == 13 || key == 0) {     
              return true;              
          }else if(key == 46){
                if(filter(tempValue)=== false){
                    return false;
                }else{       
                    return true;
                }
          }else{
              return false;
          }
    }
  }
  
  function filter(__val__){
    var preg = /^([0-9]+\.?[0-9]{0,2})$/; 
    if(preg.test(__val__) === true){
        return true;
    }else{
       return false;
    }
    
  }

const validarCelular = (input) => {
    const primerDigito = input.value.substr(0,1)
    
    if(primerDigito != 0 || input.value.length != 10){
        // El celular debe comenzar en 0 || Debe de ser un numero de 10 digitos
        input.focus()
        return false
    }
    return true;         
}

function soloNumeros (e) {
    key=e.keyCode||e.which;
    teclado=String.fromCharCode(key);
    numero="0123456789";
    especiales="8-37-38-46";
    teclado_especial=false;
    
    for(var i in especiales){
        if(key==especiales[i]){
          teclado_especial=true;
        }
    }
    if (numero.indexOf(teclado)==-1 && !teclado_especial) {
        return false;
    }
} 

function verificarCedula(input){
    const cedula = input.value;
    var numero = 0;
    var suma = 0;
    var digitoVerficador = cedula.substr(9,1);

    for (var j=0;j <= cedula.length-1; j++) {

    }
    if (j==10) {
        suma=0;
        for (var i=0; i<cedula.length-1; i++) {
            numero = cedula.substr(i,1);
            if(i%2==0){
                //digito impar
                numero = numero * 2;
            }else{
                //digito par
                numero = numero * 1;
            }           
            
            if (numero > 9) {numero = numero - 9;}
            suma+=numero;
            delete numero;
        }    
        suma = suma%10;
        if (suma==0) {
            if (suma == digitoVerficador) {
                //cedula valida
                return true
            }else{
                //cedula no valida                        
                return false
            }
        }else{
            suma = 10-suma;
            if (suma == digitoVerficador) {
                //cedula valida
                return true
            }else{
                //cedula no valida
                return false
            }
        }
    }else {
        return false
    }
}