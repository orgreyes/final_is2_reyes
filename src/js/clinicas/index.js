import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import { validarFormulario, Toast } from "../funciones";

// !mandamos a llamar todos los botones, formulario y del archivo de vistas
const formulario = document.querySelector('form');
const btnBuscar = document.getElementById('btnBuscar');
const tablaMedicos = document.getElementById('tablaMedicos');
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

    if (!validarFormulario(formulario,['clinica_id'])){
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
    body.delete('clinica_id')
    const url ='/final_is2_reyes/API/clinicas/guardar';
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
    let clinica_nombre = formulario.clinica_nombre.value;
    const url =`/final_is2_reyes/API/clinicas/buscar?clinica_nombre=${clinica_nombre}`;
    const config = {
        method : 'GET',
    }

    try{
        const respuesta = await fetch(url,config)
        const data = await respuesta.json();

        console.log(console.log(tablaClinicas.tBodies[0].innerHTML = ''));
        console.log(data);
        

        //!Para crear tablas de forma automatica.
        const fragment=document.createDocumentFragment();

        if(data.length > 0){
            let contador = 1;
            data.forEach(clinica => {

                //!Aca se crean los elementos
                const tr = document.createElement('tr');
                const td1 = document.createElement('td');
                const td2 = document.createElement('td');
                const td3 = document.createElement('td');
                const td4 = document.createElement('td');
                const buttonModificar = document.createElement('button');
                const buttonEliminar = document.createElement('button');

                //!Aca se agrega estilos usando Boostrap
                buttonModificar.classList.add('btn', 'btn-warning');
                buttonEliminar.classList.add('btn', 'btn-danger');
                buttonModificar.textContent = 'Modificar';
                buttonEliminar.textContent = 'Eliminar';

                //!Aca se agrega interactividad a los botnes de modificar y eliminar.
                buttonModificar.addEventListener('click', () =>  colocarDatos(clinica))
                buttonEliminar.addEventListener('click', () => eliminar(clinica.clinica_id))
                
                td1.innerText = contador;
                td2.innerText = clinica.clinica_nombre

                //!DOM
                td3.appendChild(buttonModificar);
                td4.appendChild(buttonEliminar);
                tr.appendChild(td1)
                tr.appendChild(td2)
                tr.appendChild(td3)
                tr.appendChild(td4)

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

        tablaClinicas.tBodies[0].appendChild(fragment)

    }catch (error){
        console.log(error)
    }
};


//!Aca esta la funcion para que al pulsar el bonton de modificar
//!se agregen los datos en automatico a el formulario.
const colocarDatos = (datos) => {
    formulario.clinica_nombre.value = datos.clinica_nombre
    formulario.clinica_id.value = datos.clinica_id

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
    const clinica_id = formulario.clinica_id.value;
    const body = new FormData(formulario);
    body.append('clinica_id', clinica_id);

    const url = `/final_is2_reyes/API/clinicas/modificar`;
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
        title: 'Eliminar clinica',
        text: '¿Desea eliminar este clinica?',
        showCancelButton: true,
        confirmButtonText: 'Eliminar',
        cancelButtonText: 'Cancelar'
    });

    if (result.isConfirmed) {
        const body = new FormData();
        body.append('clinica_id', id);

        const url = `/final_is2_reyes/API/clinicas/eliminar`;
        const config = {
            method: 'POST',
            body,
        };

        try {
            const respuesta = await fetch(url, config);
            const data = await respuesta.json();
            console.log(data);
            const { codigo, mensaje, detalle } = data;

            let icon='info'
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
