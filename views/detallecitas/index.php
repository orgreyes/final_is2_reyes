<div class="row justify-content-center">
    <div class="col-lg-10">
        <?php foreach ($citasPorFechas as $fecha => $citasPorClinica) : ?>
            <?php $formattedDate = date('d/M/Y', strtotime($fecha)); ?>
            <?php $isToday = date('Y-m-d') === $fecha; ?>
            <h2><?= $isToday ? 'Fecha de hoy' : 'Fecha de la cita (' . $formattedDate . ')' ?></h2>
            <?php foreach ($citasPorClinica as $clinica => $citasPorMedico) : ?>
                <?php $medicoNombre = key($citasPorMedico); ?>
                <h3><?= $clinica ?> (Medico <?= $medicoNombre ?>)</h3>
                <?php $citas = current($citasPorMedico); ?>
                <?php if (!empty($citas)) : ?>
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>NO</th>
                                <th>PACIENTE</th>
                                <th>DPI</th>
                                <th>TELEFONO</th>
                                <th>HORA DE LA CITA</th>
                                <th>REFERIDO</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($citas as $indice => $cita) : ?>
                                <?php if ($cita['cita_situacion'] == '1') : ?>
                                    <tr>
                                        <td><?= $indice + 1 ?></td>
                                        <td><?= $cita['paciente_nombre'] ?></td>
                                        <td><?= $cita['paciente_dpi'] ?></td>
                                        <td><?= $cita['paciente_telefono'] ?></td>
                                        <td><?= $cita['cita_hora'] ?></td>
                                        <td><?= strtolower($cita['cita_referencia']) === 'si' ? 'SI' : 'NO' ?></td>
                                    </tr>
                                <?php endif ?>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    <p>Sin Citas</p>
                <?php endif ?>
            <?php endforeach ?>
        <?php endforeach ?>
    </div>
</div>
