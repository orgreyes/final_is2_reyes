
<h1 class="text-center">Formulario de ingreso de Medicos</h1>
        <div class="row justify-content-center">
            <form class="col-lg-8 border bg-light p-3">
            <input type="hidden" name="medico_id" id="medico_id">

            <!-- //!Nombre del Medico -->
                <div class="row mb-3">
                    <div class="col">
                    <label for="medico_nombre">Nombre del Medico</label>
                        <input type="text" name="medico_nombre" id="medico_nombre" class="form-control">
                    </div>
                </div>

                <!-- //!Clinica del Medico -->
                <div class="row mb-3">
                    <div class="col-lg-12">
                        <label for="medico_clinica">Clinicas</label>
                        <select class="form-control" name="medico_clinica" id="medico_clinica">
                            <option value="">Seleccione una Clinica...</option>
                                <?php foreach ($clinicas as $key => $clinica) : ?>
                                        <option value="<?= $clinica['clinica_id'] ?>"> <?= $clinica['clinica_nombre'] ?></option>
                                <?php endforeach ?>
                        </select>
                    </div>
                </div>

                <!-- //!Especialidad del Medico -->
                <div class="row mb-3">
                    <div class="col-lg-12">
                        <label for="medico_espec">Especialidades</label>
                        <select class="form-control" name="medico_espec" id="medico_espec">
                            <option value="">Seleccione una Especialidad...</option>
                                <?php foreach ($especialidades as $key => $especialidad) : ?>
                                        <option value="<?= $especialidad['espec_id'] ?>"> <?= $especialidad['espec_nombre'] ?></option>
                                <?php endforeach ?>
                        </select>
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
                <h2>Listado de Medicos</h2>
                <table class="table table-bordered table-hover" id="tablaMedicos">
                    <thead class="table-dark">
                        <tr>
                            <th>NO. </th>
                            <th>NOMBRE</th>
                            <th>ESPECIALIDAD</th>
                            <th>CLINICA</th>
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
<script src="<?= asset('./build/js/medicos/index.js') ?>"></script>