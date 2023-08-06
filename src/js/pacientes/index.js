import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import { validarFormulario, Toast } from "../funciones";

// !mandamos a llamar todos los botones, formulario y del archivo de vistas
const formulario = document.querySelector('form');
const btnBuscar = document.getElementById('btnBuscar');
const tablaPacientes = document.getElementById('tablaPacientes');
const btnGuardar = document.getElementById('btnGuardar');
const btnModificar = document.getElementById('btnModificar');
const btnCancelar = document.getElementById('btnCancelar');
const divTabla = document.getElementById('divTabla');

//!Esto es para ocultar el bootn de modificar, cancelar y la tabla
btnModificar.disabled = true
btnModificar.parentElement.style.display = 'none'
btnCancelar.disabled = true
btnCancelar.parentElement.style.display = 'none'





//!Aca mandamos a llamar la funcion para validar que todos los campos esten llenos al momento de guardar.
const guardar = async (evento) => {
    evento.preventDefault();

    if (!validarFormulario(formulario,['paciente_id'])){
        Swal.fire({
            title: 'Campos incompletos',
            text: 'Debe llenar todos los campos del formulario',
            icon: 'warning',
            showCancelButton: false,
            confirmCancelButtonColor: '#d33',
            confirmButtonText: 'OK',
        });

        return;
    }

    const body = new FormData(formulario)
    body.delete('paciente_id')
    const url ='/final_is2_reyes/API/pacientes/guardar';
    const config = {
        method : 'POST',
        body
    }

    try {
        const respuesta = await fetch(url,config);
        const data = await respuesta.json();

         console.log(data);

        const {codigo, mensaje, detalle} = data;
        
        switch (codigo) {
            case 1:
                formulario.reset();
                buscar();
                break;

            case 0:
                console.log(detalle);
                break;

            default:
                break;
        }

        Swal.fire({
            title:'Guardando Exitoso',
            text: 'Los datos se han guardado correctamente',
            icon: 'success',
            showCancelButton: false,
            confirmCancelButtonColor: '#3085d6',
            confirmButtonText: 'OK',
        });

    } catch (error) {
        console.log(error);
    }

};









//!Aca esta la funcion de Buscar.
const buscar = async () => {
    let paciente_nombre = formulario.paciente_nombre.value;
    let paciente_dpi = formulario.paciente_dpi.value;
    let paciente_telefono = formulario.paciente_telefono.value;
    const url =`/final_is2_reyes/API/pacientes/buscar?paciente_nombre=${paciente_nombre}&paciente_dpi=${paciente_dpi}&paciente_telefono=${paciente_telefono}`;
    const config = {
        method : 'GET',
    }

    try{
        const respuesta = await fetch(url,config)
        const data = await respuesta.json();

        console.log(console.log(tablaPacientes.tBodies[0].innerHTML = ''));
        console.log(data);
        

        //!Para crear tablas de forma automatica.
        const fragment=document.createDocumentFragment();

        if(data.length > 0){
            let contador = 1;
            data.forEach(paciente => {

                //!Aca se crean los elementos
                const tr = document.createElement('tr');
                const td1 = document.createElement('td');
                const td2 = document.createElement('td');
                const td3 = document.createElement('td');
                const td4 = document.createElement('td');
                const td5 = document.createElement('td');
                const td6= document.createElement('td');
                const buttonModificar = document.createElement('button');
                const buttonEliminar = document.createElement('button');

                //!Aca se agrega estilos usando Boostrap
                buttonModificar.classList.add('btn', 'btn-warning');
                buttonEliminar.classList.add('btn', 'btn-danger');
                buttonModificar.textContent = 'Modificar';
                buttonEliminar.textContent = 'Eliminar';

                //!Aca se agrega interactividad a los botnes de modificar y eliminar.
                buttonModificar.addEventListener('click', () =>  colocarDatos(paciente))
                buttonEliminar.addEventListener('click', () => eliminar(paciente.paciente_id))
                
                td1.innerText = contador;
                td2.innerText = paciente.paciente_nombre
                td3.innerText = paciente.paciente_dpi
                td4.innerText = paciente.paciente_telefono
                

                //!DOM
                td5.appendChild(buttonModificar);
                td6.appendChild(buttonEliminar);
                tr.appendChild(td1)
                tr.appendChild(td2)
                tr.appendChild(td3)
                tr.appendChild(td4)
                tr.appendChild(td5)
                tr.appendChild(td6)

                fragment.appendChild(tr);
                contador++;

            })
        }else{
            const tr = document.createElement('tr');
            const td = document.createElement('td');
            td.innerText = 'No existe Registros';
            td.colSpan = 5
            tr.appendChild(td)
            fragment.appendChild(tr);

        };

        tablaPacientes.tBodies[0].appendChild(fragment)

    }catch (error){
        console.log(error)
    }
};


//!Aca esta la funcion para que al pulsar el bonton de modificar
//!se agregen los datos en automatico a el formulario.
const colocarDatos = (datos) => {
    formulario.paciente_nombre.value = datos.paciente_nombre
    formulario.paciente_dpi.value = datos.paciente_dpi
    formulario.paciente_telefono.value = datos.paciente_telefono
    formulario.paciente_id.value = datos.paciente_id

    btnGuardar.disabled = true
    btnGuardar.parentElement.style.display = 'none'
    btnBuscar.disabled = true
    btnBuscar.parentElement.style.display = 'none'
    btnModificar.disabled = false
    btnModificar.parentElement.style.display = ''
    btnCancelar.disabled = false
    btnCancelar.parentElement.style.display = ''
    divTabla.style.display = 'none'
};


//!Aca esta la funcino de cancelar la accion de modificar un registro.
const cancelarAccion = () => {
    btnGuardar.disabled = false
    btnGuardar.parentElement.style.display = ''
    btnBuscar.disabled = false
    btnBuscar.parentElement.style.display = ''
    btnModificar.disabled = true
    btnModificar.parentElement.style.display = 'none'
    btnCancelar.disabled = true
    btnCancelar.parentElement.style.display = 'none'
    divTabla.style.display = ''
}

// ...

//!Aca esta la funcion de modificar un registro
const modificar = async () => {
    const cliente_id = formulario.cliente_id.value;


    const body = new FormData(formulario);
    body.append('tipo', 2);
    body.append('cliente_id', cliente_id);

    const url = `/CRUD_JS/CRUD_JS_REYES/controladores/clientes/index.php`;
    const config = {
        method: 'POST',
        body,
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        console.log(data);
        const { codigo, mensaje, detalle } = data;

        switch (codigo) {
            case 1:
                formulario.reset();
                cancelarAccion();
                buscar();

                Swal.fire({
                    icon: 'success',
                    title: 'Actualizado',
                    text: mensaje,
                    confirmButtonText: 'OK'
                });
                break;
            case 0:
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Verifique sus datos: ' + mensaje,
                    confirmButtonText: 'OK'
                });
                break;
            default:
                break;
        }

    } catch (error) {
        console.log(error);
    }
};




const eliminar = async (id) => {
    const result = await Swal.fire({
        icon: 'question',
        title: 'Eliminar Cliente',
        text: '¿Desea eliminar este Cliente?',
        showCancelButton: true,
        confirmButtonText: 'Eliminar',
        cancelButtonText: 'Cancelar'
    });

    if (result.isConfirmed) {
        const body = new FormData();
        body.append('tipo', 3);
        body.append('cliente_id', id);

        const url = `/CRUD_JS/CRUD_JS_REYES/controladores/clientes/index.php`;
        const config = {
            method: 'POST',
            body,
        };

        try {
            const respuesta = await fetch(url, config);
            const data = await respuesta.json();

            const { codigo, mensaje, detalle } = data;

            switch (codigo) {
                case 1:
                    buscar();
                    Swal.fire({
                        icon: 'success',
                        title: 'Eliminado Exitosamente',
                        text: mensaje,
                        confirmButtonText: 'OK'
                    });
                    break;
                case 0:
                    console.log(detalle);
                    break;
                default:
                    break;
            }

        } catch (error) {
            console.log(error);
        }
    }
};


formulario.addEventListener('submit', guardar);
btnBuscar.addEventListener('click', buscar);
btnCancelar.addEventListener('click', cancelarAccion);
btnModificar.addEventListener('click', modificar);
