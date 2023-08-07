import Swal from "sweetalert2";
import { validarFormulario } from "../funciones";

const formulario = document.querySelector('form');
const btnBuscar = document.getElementById('btnBuscar');
const tablaMedicos = document.getElementById('tablaMedicos');
const btnGuardar = document.getElementById('btnGuardar');
const btnModificar = document.getElementById('btnModificar');
const btnCancelar = document.getElementById('btnCancelar');
const divTabla = document.getElementById('divTabla');

btnModificar.disabled = true;
btnModificar.parentElement.style.display = 'none';
btnCancelar.disabled = true;
btnCancelar.parentElement.style.display = 'none';



const guardar = async (evento) => {
    evento.preventDefault();

    if (!validarFormulario(formulario, ['medico_id'])) {
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
    body.delete('medico_id')
    const url = '/final_is2_reyes/API/medicos/guardar';
    const config = {
        method: 'POST',
        body
    }

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();

        console.log(data);

        const { codigo, mensaje, detalle } = data;

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
            title: 'Guardando Exitoso',
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

const buscar = async () => {
    let medico_nombre = formulario.medico_nombre.value;
    let medico_espec = formulario.medico_espec.value;
    let medico_clinica = formulario.medico_clinica.value;
    const url = `/final_is2_reyes/API/medicos/buscar?medico_nombre=${medico_nombre}&medico_espec=${medico_espec}&medico_clinica=${medico_clinica}`;
    const config = {
        method: 'GET',
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();

        console.log(console.log(tablaMedicos.tBodies[0].innerHTML = ''));
        console.log(data);

        const fragment = document.createDocumentFragment();

        if (data.length > 0) {
            let contador = 1;
            data.forEach(medico => {
                const tr = document.createElement('tr');
                const td1 = document.createElement('td');
                const td2 = document.createElement('td');
                const td3 = document.createElement('td');
                const td4 = document.createElement('td');
                const td5 = document.createElement('td');
                const td6 = document.createElement('td');
                const buttonModificar = document.createElement('button');
                const buttonEliminar = document.createElement('button');

                buttonModificar.classList.add('btn', 'btn-warning', 'btn-fill');
                buttonEliminar.classList.add('btn', 'btn-danger', 'btn-fill');
                buttonModificar.textContent = 'Modificar';
                buttonEliminar.textContent = 'Eliminar';

                buttonModificar.addEventListener('click', () => colocarDatos(medico));
                buttonEliminar.addEventListener('click', () => eliminar(medico.medico_id));

                td1.innerText = contador;
                td2.innerText = medico.medico_nombre;
                td3.innerText = medico.medico_espec_nombre;
                td4.innerText = medico.medico_clinica_nombre;

                td5.appendChild(buttonModificar);
                td6.appendChild(buttonEliminar);
                tr.appendChild(td1);
                tr.appendChild(td2);
                tr.appendChild(td3);
                tr.appendChild(td4);
                tr.appendChild(td5);
                tr.appendChild(td6);

                fragment.appendChild(tr);
                contador++;
            });
        } else {
            const tr = document.createElement('tr');
            const td = document.createElement('td');
            td.innerText = 'No existe Registros';
            td.colSpan = 5;
            tr.appendChild(td);
            fragment.appendChild(tr);
        }

        tablaMedicos.tBodies[0].appendChild(fragment);
    } catch (error) {
        console.log(error);
    }
};

const colocarDatos = (datos) => {
    formulario.medico_nombre.value = datos.medico_nombre
    formulario.medico_espec.value = datos.medico_espec
    formulario.medico_clinica.value = datos.medico_clinica
    formulario.medico_id.value = datos.medico_id

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
};

const modificar = async () => {
    const medico_id = formulario.medico_id.value;
    const body = new FormData(formulario);
    body.append('medico_id', medico_id);

    const url = `/final_is2_reyes/API/medicos/modificar`;
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
        title: 'Eliminar medico',
        text: '¿Desea eliminar este medico?',
        showCancelButton: true,
        confirmButtonText: 'Eliminar',
        cancelButtonText: 'Cancelar'
    });

    if (result.isConfirmed) {
        const body = new FormData();
        body.append('medico_id', id);

        const url = `/final_is2_reyes/API/medicos/eliminar`;
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
