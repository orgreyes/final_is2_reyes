<!-- Aca ira el formulario de ingreso y busqueda de pacientes -->
        <h1 class="text-center">Formulario de ingreso de pacientes</h1>
        <div class="row justify-content-center">
            <form class="col-lg-8 border bg-light p-3">
            <input type="hidden" name="paciente_id" id="paciente_id">

            <!-- //!Nombre del Paciente -->
                <div class="row mb-3">
                    <div class="col">
                    <label for="paciente_nombre">Nombre del paciente</label>
                        <input type="text" name="paciente_nombre" id="paciente_nombre" class="form-control">
                    </div>
                </div>

                <!-- //!DPI del Paciente -->
                <div class="row mb-3">
                    <div class="col">
                        <label for="paciente_dpi">DPI del paciente</label>
                        <input type="number" name="paciente_dpi" id="paciente_dpi" class="form-control">
                    </div>
                </div>

                <!-- //!Telefono del Paciente -->
                <div class="row mb-3">
                    <div class="col">
                        <label for="paciente_telefono">Telefono del paciente</label>
                        <input type="number" name="paciente_telefono" id="paciente_telefono" class="form-control">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-lg-2">
                        <button type="submit" id="btnGuardar" class="btn btn-primary w-100">Guardar</button>
                    </div>
                    <div class="col-lg-2">
                        <button type="button" id="btnModificar" class="btn btn-warning w-100">Modificar</button>
                    </div>
                    <div class="col-lg-2">
                        <button type="button" id="btnBuscar" class="btn btn-info w-100">Buscar</button>
                    </div>
                    <div class="col-lg-2">
                        <button type="button" id="btnCancelar" class="btn btn-danger w-100">Cancelar</button>
                    </div>

                </div>
            </form>
        </div>
        <div class="row justify-content-center" id="divTabla">
            <div class="col-lg-8">
                <h2>Listado de Pacientes</h2>
                <table class="table table-bordered table-hover" id="tablaPacientes">
                    <thead class="table-dark">
                        <tr>
                            <th>NO. </th>
                            <th>NOMBRE</th>
                            <th>DPI</th>
                            <th>TELEFONO</th>
                            <th>MODIFICAR</th>
                            <th>ELIMINAR</th>
                        </tr>
                    </thead>
                        <tbody>
                        </tbody>
                </table>
            </div>
        </div>
        </div>
<script src="<?= asset('./build/js/pacientes/index.js') ?>"></script>