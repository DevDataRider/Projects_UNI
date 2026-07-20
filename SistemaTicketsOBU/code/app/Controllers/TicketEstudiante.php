<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\HorarioComedor;
use App\Models\TicketModel;

use Dompdf\Dompdf;
use Dompdf\Options;

class TicketEstudiante extends BaseController
{
    public function hoy()
    {
        $id = session()->get('id_estudiante');
        $fecha = date('Y-m-d');
        $tipoComidaId = HorarioComedor::turnoActual();

        $ticket = null;
        if ($tipoComidaId !== null) {
            $modelo = new TicketModel();
            $ticket = $modelo
                ->where('student_id', $id)
                ->where('fecha', $fecha)
                ->where('tipo_comida_id', $tipoComidaId)
                ->first();
        }

        return view('tickets/hoy', [
            'ticket'      => $ticket,
            'turnoNombre' => $tipoComidaId !== null ? HorarioComedor::nombre($tipoComidaId) : null,
        ]);
    }

   public function registrar()
{
    $studentId = session()->get('id_estudiante');

    if (!$studentId) {
        return $this->response->setJSON([
            'status' => 'error',
            'mensaje' => 'Sesión inválida. Debes iniciar sesión nuevamente.'
        ]);
    }

    // 🗓️ Validar que hoy sea lunes a viernes
    if (!HorarioComedor::esDiaHabil()) {
        return $this->response->setJSON([
            'status' => 'error',
            'mensaje' => 'El registro de tickets solo está disponible de lunes a viernes.'
        ]);
    }

    // 🕐 Validar que la hora actual caiga en un turno de atención
    $tipoComidaId = HorarioComedor::turnoActual();
    if ($tipoComidaId === null) {
        return $this->response->setJSON([
            'status' => 'error',
            'mensaje' => 'Fuera de horario de atención. Turnos: Desayuno 7:00–9:30, Almuerzo 12:00–14:00, Cena 17:00–19:00.'
        ]);
    }

    $becado = session()->get('is_scholarship') ? 1 : 0;
    $fecha = date('Y-m-d');

    $ticketModel = new \App\Models\TicketModel();

    if (!$ticketModel->verificarDisponibilidad($studentId, $fecha, $tipoComidaId)) {
        return $this->response->setJSON([
            'status'  => 'error',
            'mensaje' => 'Ya te registraste para este turno hoy.'
        ]);
    }

    $nroOrden = $ticketModel->contarTicketsEmitidos($fecha, $tipoComidaId, $becado) + 1;

    $ticketModel->insert([
        'student_id'     => $studentId,
        'fecha'          => $fecha,
        'tipo_comida_id' => $tipoComidaId,
        'estado'         => 'pendiente'
    ]);

    $ticketId = $ticketModel->getInsertID();

    $qrUrl = base_url('ticket/pdf/' . $ticketId);
    $codigoQR = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' . urlencode($qrUrl);

    return $this->response->setJSON([
        'status'      => 'ok',
        'mensaje'     => 'Registrado con éxito',
        'ticket_id'   => $ticketId,
        'nro_orden'   => $nroOrden,
        'codigo_qr'   => $codigoQR,
        'nombre'      => session()->get('full_name'),
        'codigo'      => session()->get('university_code'),
        'fecha'       => $fecha,
        'tipo'        => $tipoComidaId,
        'tipo_nombre' => HorarioComedor::nombre($tipoComidaId)
    ]);
}


public function historial()
{
    $studentId = session()->get('id_estudiante');
    $ticketModel = new TicketModel();

    $data['tickets'] = $ticketModel
    ->where('student_id', $studentId)
    ->orderBy('fecha', 'DESC')
    ->findAll();


    return view('layout/header')
        . view('layout/aside')
        . view('Tickets/historial', $data)
        . view('layout/footer');
}

   public function pdf($id = null)
{
    require_once(APPPATH.'ThirdParty/tcpdf/tcpdf.php');

    $ticketModel = new TicketModel();

    $query = $ticketModel
        ->join('students', 'students.id = tickets.student_id')
        ->select('tickets.*, students.full_name, students.university_code, students.is_scholarship')
        ->where('tickets.id', $id);

    // Solo un administrador puede ver el ticket de otro estudiante.
    if (session()->get('perfil') !== 'Administrador') {
        $query->where('tickets.student_id', session()->get('id_estudiante'));
    }

    $ticket = $query->first();

    if (!$ticket) {
        return redirect()->back()->with('error', 'Ticket no encontrado.');
    }

    $nroOrden = $ticketModel->contarTicketsEmitidos(
        $ticket['fecha'],
        $ticket['tipo_comida_id'],
        $ticket['is_scholarship']
    );

    $qr = 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=' . base_url('verificar_ticket/' . $ticket['id']);

    $pdf = new \App\Libraries\Pdflibrary(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->AddPage();

    $html = '
        <style>
            .contenedor {
                text-align: center;
                font-family: Helvetica, Arial, sans-serif;
            }
            .titulo {
                font-size: 16px;
                font-weight: bold;
                margin-bottom: 15px;
            }
            .dato {
                font-size: 12px;
                margin-bottom: 5px;
            }
            .qr {
                margin-top: 20px;
            }
        </style>

        <div class="contenedor">
            <div class="titulo"> Ticket Comedor OBU</div>
            <div class="dato"><strong>Nombre:</strong> ' . esc($ticket['full_name']) . '</div>
            <div class="dato"><strong>Código Univ.:</strong> ' . esc($ticket['university_code']) . '</div>
            <div class="dato"><strong>Tipo de comida:</strong> ' . esc(HorarioComedor::nombre((int) $ticket['tipo_comida_id']) ?? 'Desconocido') . '</div>
            <div class="dato"><strong>Fecha:</strong> ' . $ticket['fecha'] . '</div>
            <div class="dato"><strong>N° Orden:</strong> ' . $nroOrden . '</div>
            <div class="dato"><strong>Becado:</strong> ' . ($ticket['is_scholarship'] ? 'Sí' : 'No') . '</div>
            <div class="qr"><img src="' . $qr . '" width="130" height="130" /></div>
        </div>
    ';

    $pdf->writeHTML($html, true, false, true, false, '');

    $becadoLabel = $ticket['is_scholarship'] ? 'Becado' : 'No';
    $nombreLegible = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $ticket['full_name']) ?: $ticket['full_name'];
    $nombreArchivo = "Ticket_{$nroOrden}_{$becadoLabel}_{$ticket['university_code']}_{$nombreLegible}";
    $nombreArchivo = preg_replace('/[^A-Za-z0-9_-]+/', '_', $nombreArchivo);
    $nombreArchivo = trim(preg_replace('/_+/', '_', $nombreArchivo), '_') . '.pdf';

    $pdfContent = $pdf->Output($nombreArchivo, 'S');

    return $this->response
        ->setHeader('Content-Type', 'application/pdf')
        ->setHeader('Content-Disposition', 'attachment; filename="' . $nombreArchivo . '"')
        ->setBody($pdfContent);
}

    // Pantalla que ve el personal del comedor al escanear el QR del ticket.
    public function verificar($id = null)
    {
        $ticketModel = new TicketModel();

        $ticket = $ticketModel
            ->join('students', 'students.id = tickets.student_id')
            ->select('tickets.*, students.full_name, students.facultad, students.is_scholarship')
            ->where('tickets.id', $id)
            ->first();

        if (!$ticket) {
            return redirect()->back()->with('error', 'Ticket no encontrado.');
        }

        $nroOrden = $ticketModel->contarTicketsEmitidos(
            $ticket['fecha'],
            $ticket['tipo_comida_id'],
            $ticket['is_scholarship']
        );

        return view('layout/header')
            . view('layout/aside_admin')
            . view('tickets/verificar', [
                'ticket'      => $ticket,
                'nroOrden'    => $nroOrden,
                'turnoNombre' => HorarioComedor::nombre((int) $ticket['tipo_comida_id']) ?? 'Desconocido',
            ])
            . view('layout/footer');
    }

}
