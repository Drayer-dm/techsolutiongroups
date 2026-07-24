document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('atomicContactForm');
    if (form) {
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            //NO EXISTE BACK PA Q VAMOS A ENVIAR EL FORM XD

            const submitBtn = form.querySelector('#submitBtn');
            const successMsg = form.querySelector('#formSuccessMessage');

            if (successMsg) {
                successMsg.classList.add('hidden');
                successMsg.textContent = '';
            }

            form.querySelectorAll('.error-message').forEach(el => {
                el.classList.add('hidden');
                el.innerHTML = ''; // limpiar los nodos para prevenir XSS o DOM-Based
            });

            // Todos los inputs del formulario
            const name = form.elements['nombre']?.value.trim() || '';
            const email = form.elements['email']?.value.trim() || '';
            const asunto = form.elements['asunto']?.value.trim() || '';
            const phone = form.elements['telefono']?.value.trim() || '';
            const message = form.elements['mensaje']?.value.trim() || '';

            let esValido = true;
            const errors = {}; // errores pa los nogringos


            //Validaciones en base a front pq no existe el back :v
            const nameRegex = /^[a-zA-ZÀ-ÿ\s]+$/;
            if (!name) {
                errors.nombre = "El nombre es obligatorio.";
                esValido = false;
            } else if (!nameRegex.test(name)) {
                errors.nombre = "El nombre solo puede contener letras.";
                esValido = false;
            } else if (name.length < 3) {
                errors.nombre = {
                    image: true,
                    src: '/images/ignore/IGNORE.webp',
                    alt: 'Nombre muy corto',
                    text: 'El nombre debe tener al menos 3 caracteres.'
                };
                esValido = false;
            }

            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!email) {
                errors.email = "El correo electronico es obligatorio.";
                esValido = false;
            } else if (!emailRegex.test(email)) {
                errors.email = "Debes ingresar un correo valido.";
                esValido = false;
            }

            if (!asunto) {
                errors.asunto = "Debes seleccionar un asunto.";
                esValido = false;
            }

            const phoneRegex = /^(\+?56)?9\d{8}$/;
            if (!phone) {
                errors.telefono = "El numero de telefono es obligatorio.";
                esValido = false;
            } else if (!phoneRegex.test(phone)) {
                errors.telefono = "Ingrese un numero de telefono valido (formatos aceptados +56912345678, 56912345678, 912345678).";
                esValido = false;
            }

            if (!message) {
                errors.mensaje = "El mensaje no puede estar vacio.";
                esValido = false;
            } else if (message.length < 10) {
                errors.mensaje = "El mensaje debe tener un minimo de 10 caracteres.";
                esValido = false;
            }

            if (!esValido) {
                for (const [field, errorMsg] of Object.entries(errors)) {
                    const errorAtom = form.querySelector(`#error-${field}`);
                    if (errorAtom) {
                        errorAtom.classList.remove('hidden');
                        if (errorMsg && typeof errorMsg === 'object' && errorMsg.image) {
                            errorAtom.innerHTML = `
                                <div class="flex items-center gap-2">
                                    <img src="${errorMsg.src}" alt="${errorMsg.alt}" class="h-10 w-10 object-contain" />
                                    <span>${errorMsg.text}</span>
                                </div>
                            `;
                        } else {
                            errorAtom.textContent = String(errorMsg);
                        }
                    }
                }
                return;
            }

            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.textContent = "Validando...";
            }

            setTimeout(() => {
                form.reset();
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.textContent = "Enviar Mensaje";
                }

                if (successMsg) {
                    successMsg.textContent = "Mensaje enviado correctamente.";
                    successMsg.classList.remove('hidden');
                }
            }, 1000);
        });
    }
})