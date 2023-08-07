
<h1 class="text-center">Formulario de ingreso de Citas</h1>
        <div class="row justify-content-center">
            <form class="col-lg-8 border bg-light p-3">
            <input type="hidden" name="cita_id" id="cita_id">

            <!-- //!Nombre del Paciente -->
            <div class="row mb-3">
                    <div class="col-lg-12">
                        <label for="cita_paciente">Pacientes</label>
                        <select class="form-control" name="cita_paciente" id="cita_paciente">
                            <option value="">Seleccione un Paciente...</option>
                                <?php foreach ($pacientes as $key => $paciente) : ?>
                                        <option value="<?= $paciente['paciente_id'] ?>"> <?= $paciente['paciente_nombre'] ?></option>
                                <?php endforeach ?>
                        </select>
                    </div>
                </div>

                <!-- //!Medico Asignado-->
                <div class="row mb-3">
                    <div class="col-lg-12">
                        <label for="cita_medico">Medicos</label>
                        <select class="form-control" name="cita_medico" id="cita_medico">
                            <option value="">Seleccione un Medico...</option>
                                <?php foreach ($medicos as $key => $medico) : ?>
                                        <option value="<?= $medico['medico_id'] ?>"> <?= $medico['medico_nombre'] ?></option>
                                <?php endforeach ?>
                        </select>
                    </div>
                </div>

                <!-- //!Fecha de la Cita -->
                <div class="row mb-3">
                    <div class="col">
                    <label for="cita_fecha">Fecha de la Cita</label>
                        <input type="date" value="<?= date('Y-m-d') ?>" name="cita_fecha" id="cita_fecha" class="form-control">
                    </div>
                </div>

                <!-- //!Hora de La Cita -->
                <div class="row mb-3">
                    <div class="col">
                    <label for="cita_hora">Horario de la Cita</label>
                        <input type="time" value="<?= date('H:i') ?>" name="cita_hora" id="cita_hora" class="form-control">
                    </div>
                </div>


                <!-- //!Referencias de la Cita -->
                <div class="row mb-3">
                    <div class="col">
                    <label for="cita_referencia">Tiene Referencia?</label>
                    <select name="cita_referencia" id="cita_referencia" class='form-control'>
                        <option value="si">Si</option>
                        <option value="no">No</option>
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
                <h2>Listado de Citas</h2>
                <table class="table table-bordered table-hover" id="tablaCitas">
                    <thead class="table-dark">
                        <tr>
                            <th>NO. DE CITA</th>
                            <th>PACIENTE</th>
                            <th>MEDICO</th>
                            <th>FECHA</th>
                            <th>HORA</th>
                            <th>REFERENCIA</th>
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
<script src="<?= asset('./build/js/citas/index.js') ?>"></script>