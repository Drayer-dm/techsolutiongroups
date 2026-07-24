document.addEventListener('DOMContentLoaded', () =>{
    const form = document.getElementById('atomicContactForm');

    form.addEventListener('submit',(e)=>{
        e.preventDefault();
    })//NO EXISTE BACK PA Q VAMOS A ENVIAR EL FORM XD

    const submitBtn = document.getElementById('submitBtn'); //boton de enviar
    const successMsg = document.getElementById('formSuccessMessage'); //mensaje de que el formulario salio bien

    successMsg.classList.add('hidden');
    document.querySelectorAll('.error-message').forEach(el => {
        el.classList.add('hidden');
        el.textContent= ''; //llimpiar los nodos para prevenir XSS o DOM-Based
    });


    //ignore
    const imagenImportante = document.createElement("img");

    imagenImportante.src = 

    //Todos los imputs del formulario
    const name = form.elements['name'].value.trim();
    const email =  form.elements['email'].value.trim();
    const phone = form.elements['phone'].value.trim();
    const message = form.elements['message'].value.trim();

    let esValido = true;
    const errors = {}; //errores pa los nogringos


    //Validaciones en base a front pq no existe el back :v
    const nameRegex = /^[a-zA-ZÀ-ÿ\s]+$/;
        if(!name){
            errors.name = "El nombre es obligatorio.";
            esValido = false;
        }else if(!nameRegex.test(name)){
            errors.name = "El nombre solo puede contener letras."
            isValid = false;
        }

        if(name.lenght()< 3 ){
            errors.name = 
        }




})