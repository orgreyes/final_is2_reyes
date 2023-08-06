
<h1 class="text-center">Formulario de ingreso de Especialidades</h1>
        <div class="row justify-content-center">
            <form class="col-lg-8 border bg-light p-3">
            <input type="hidden" name="espec_id" id="espec_id">

            <!-- //!Nombre de la Especialidad -->
                <div class="row mb-3">
                    <div class="col">
                    <label for="espec_nombre">Nombre de la Especialidad</label>
                        <input type="text" name="espec_nombre" id="espec_nombre" class="form-control">
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
                <h2>Listado de Especialidades</h2>
                <table class="table table-bordered table-hover" id="tablaEspecialidades">
                    <thead class="table-dark">
                        <tr>
                            <th>NO. </th>
                            <th>NOMBRE DE LA ESPECIALIDAD</th>
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
<script src="<?= asset('./build/js/especialidades/index.js') ?>"></script>