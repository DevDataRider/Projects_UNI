<?php

namespace App\Controllers;

use App\Libraries\HorarioComedor;
use App\Libraries\Pdflibrary;
use App\Models\EstudiantesModel;
use App\Models\PlatoModel;
use App\Models\TicketModel;
use App\Models\AsistenciasModel;
use App\Models\IncidenciasModel;
use App\Models\ActividadEstudiantesModel;

class Reportes extends BaseController
{
    protected $estudiantesModel;
    protected $platoModel;
    protected $ticketsModel;
    protected $asistenciasModel;
    protected $incidenciasModel;
    protected $actividadModel;

    public function __construct()
    {
        $this->estudiantesModel = new EstudiantesModel();
        $this->platoModel = new PlatoModel();
        $this->ticketsModel = new TicketModel();
        $this->asistenciasModel = new AsistenciasModel();
        $this->incidenciasModel = new IncidenciasModel();
        $this->actividadModel = new ActividadEstudiantesModel();
    }

    public function ExcelEstudiantes()
    {
        $estudiantes = $this->estudiantesModel->findAll();
        $name = "Estudiantes_" . date('Ymd') . ".xls";

        header('Expires: 0');
        header('Cache-Control: private');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="'.$name.'"');
        header('Content-Transfer-Encoding: binary');

        echo utf8_decode("<table>
            <tr>
                <td style='text-align:center; font-weight:bold; border:1px solid #eee;'>#</td>
                <td style='text-align:center; font-weight:bold; border:1px solid #eee;'>Código Universitario</td>
                <td style='text-align:center; font-weight:bold; border:1px solid #eee;'>Nombre Completo</td>
                <td style='text-align:center; font-weight:bold; border:1px solid #eee;'>Correo Institucional</td>
                <td style='text-align:center; font-weight:bold; border:1px solid #eee;'>Beca</td>
            </tr>");

        foreach($estudiantes as $index => $estudiante){
            echo utf8_decode("<tr>
                <td style='text-align:center; border:1px solid #eee;'>".($index+1)."</td>
                <td style='text-align:center; border:1px solid #eee;'>".$estudiante['university_code']."</td>
                <td style='text-align:center; border:1px solid #eee;'>".$estudiante['full_name']."</td>
                <td style='text-align:center; border:1px solid #eee;'>".$estudiante['email_institutional']."</td>
                <td style='text-align:center; border:1px solid #eee;'>".($estudiante['is_scholarship'] ? 'Becado' : 'No Becado')."</td>
            </tr>");
        }

        echo "</table>";
    }

    public function ExcelAsistencias()
    {
        $asistencias = $this->asistenciasModel->obtenerAsistenciasConTickets();
        $name = "Asistencias_" . date('Ymd') . ".xls";

        header('Expires: 0');
        header('Cache-Control: private');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="'.$name.'"');
        header('Content-Transfer-Encoding: binary');

        echo utf8_decode("<table>
            <tr>
                <td style='text-align:center; font-weight:bold; border:1px solid #eee;'>#</td>
                <td style='text-align:center; font-weight:bold; border:1px solid #eee;'>Estudiante</td>
                <td style='text-align:center; font-weight:bold; border:1px solid #eee;'>Fecha Ticket</td>
                <td style='text-align:center; font-weight:bold; border:1px solid #eee;'>Tipo Comida</td>
                <td style='text-align:center; font-weight:bold; border:1px solid #eee;'>Estado Ticket</td>
                <td style='text-align:center; font-weight:bold; border:1px solid #eee;'>Fecha Ingreso</td>
            </tr>");

        foreach ($asistencias as $index => $a) {
            $tipoComida = HorarioComedor::nombre((int) $a['tipo_comida_id']) ?? 'Desconocido';
            echo utf8_decode("<tr>
                <td style='text-align:center; border:1px solid #eee;'>".($index+1)."</td>
                <td style='text-align:center; border:1px solid #eee;'>".$a['full_name']."</td>
                <td style='text-align:center; border:1px solid #eee;'>".date('d-m-Y', strtotime($a['fecha']))."</td>
                <td style='text-align:center; border:1px solid #eee;'>".$tipoComida."</td>
                <td style='text-align:center; border:1px solid #eee;'>".$a['estado_ticket']."</td>
                <td style='text-align:center; border:1px solid #eee;'>".date('d-m-Y h:i A', strtotime($a['fecha_ingreso']))."</td>
            </tr>");
        }

        echo "</table>";
    }

    public function ExcelIncidencias()
    {
        $incidencias = $this->incidenciasModel->obtenerIncidenciasConEstudiantes();
        $name = "Incidencias_" . date('Ymd') . ".xls";

        header('Expires: 0');
        header('Cache-Control: private');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="'.$name.'"');
        header('Content-Transfer-Encoding: binary');

        echo utf8_decode("<table>
            <tr>
                <td style='text-align:center; font-weight:bold; border:1px solid #eee;'>#</td>
                <td style='text-align:center; font-weight:bold; border:1px solid #eee;'>Código Universitario</td>
                <td style='text-align:center; font-weight:bold; border:1px solid #eee;'>Nombre Completo</td>
                <td style='text-align:center; font-weight:bold; border:1px solid #eee;'>Descripción</td>
                <td style='text-align:center; font-weight:bold; border:1px solid #eee;'>Fecha</td>
            </tr>");

        foreach ($incidencias as $index => $i) {
            echo utf8_decode("<tr>
                <td style='text-align:center; border:1px solid #eee;'>".($index+1)."</td>
                <td style='text-align:center; border:1px solid #eee;'>".$i['university_code']."</td>
                <td style='text-align:center; border:1px solid #eee;'>".$i['full_name']."</td>
                <td style='text-align:center; border:1px solid #eee;'>".$i['descripcion']."</td>
                <td style='text-align:center; border:1px solid #eee;'>".date('d-m-Y h:i A', strtotime($i['fecha']))."</td>
            </tr>");
        }

        echo "</table>";
    }

    public function ExcelActividades()
    {
        $actividades = $this->actividadModel->obtenerActividadesConEstudiantes();
        $name = "Actividades_" . date('Ymd') . ".xls";

        header('Expires: 0');
        header('Cache-Control: private');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="'.$name.'"');
        header('Content-Transfer-Encoding: binary');

        echo utf8_decode("<table>
            <tr>
                <td style='text-align:center; font-weight:bold; border:1px solid #eee;'>#</td>
                <td style='text-align:center; font-weight:bold; border:1px solid #eee;'>Código Universitario</td>
                <td style='text-align:center; font-weight:bold; border:1px solid #eee;'>Nombre Completo</td>
                <td style='text-align:center; font-weight:bold; border:1px solid #eee;'>Acción</td>
                <td style='text-align:center; font-weight:bold; border:1px solid #eee;'>Fecha</td>
            </tr>");

        foreach ($actividades as $index => $a) {
            echo utf8_decode("<tr>
                <td style='text-align:center; border:1px solid #eee;'>".($index+1)."</td>
                <td style='text-align:center; border:1px solid #eee;'>".$a['university_code']."</td>
                <td style='text-align:center; border:1px solid #eee;'>".$a['full_name']."</td>
                <td style='text-align:center; border:1px solid #eee;'>".$a['accion']."</td>
                <td style='text-align:center; border:1px solid #eee;'>".date('d-m-Y h:i A', strtotime($a['fecha']))."</td>
            </tr>");
        }

        echo "</table>";
    }

  public function PDFEstudiantes()
    {
        require_once(APPPATH.'ThirdParty/tcpdf/tcpdf.php');
        $pdf = new \App\Libraries\Pdflibrary(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetTitle('Listado de Estudiantes');

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->startPageGroup();
        $pdf->AddPage();
        $fecha = date("d-m-Y");

        $estudiantes = $this->estudiantesModel->findAll();

        // Ajuste de tabla de encabezado
        $html = '
            <table align="center">
                <tr>
                    <td style="width:150px;"></td>
                    <td style="font-size:9px; text-align:center;">
                        <br>
                        Sistema de Comedor Universitario<br>
                        Universidad Nacional del Callao<br>
                        Fecha: '.$fecha.'
                    </td>
                    <td style="width:150px;"></td>
                </tr>
            </table>

            <br><br>

            <h3 style="text-align:center;">Listado de Estudiantes</h3>

            <table align="center" style="font-size:10px; padding:5px 10px; border-collapse: collapse;" border="1">
                <thead>
                    <tr style="background-color:#f2f2f2;">
                        <th style="width:40px; text-align:center;">#</th>
                        <th style="width:110px; text-align:center;">Código Univ.</th>
                        <th style="width:180px; text-align:center;">Nombre Completo</th>
                        <th style="width:160px; text-align:center;">Correo Institucional</th>
                        <th style="width:80px; text-align:center;">Beca</th>
                    </tr>
                </thead>
            </table>';

        $pdf->writeHTML($html, false, false, false, false, '');

        foreach ($estudiantes as $key => $e) {
            $htmlRow = '
                <table align="center" style="font-size:9px; padding:3px 5px;" border="1">
                    <tr>
                        <td style="width:40px; text-align:center;">'.($key + 1).'</td>
                        <td style="width:110px; text-align:center;">'.$e['university_code'].'</td>
                        <td style="width:180px;">'.$e['full_name'].'</td>
                        <td style="width:160px;">'.$e['email_institutional'].'</td>
                        <td style="width:80px; text-align:center;">'.($e['is_scholarship'] ? 'Becado' : 'No Becado').'</td>
                    </tr>
                </table>';
            $pdf->writeHTML($htmlRow, false, false, false, false, '');
        }

        $pdfContent = $pdf->Output('Estudiantes_'.date('Ymd_His').'.pdf', 'S');

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'attachment; filename="Estudiantes_'.date('Ymd_His').'.pdf"')
            ->setBody($pdfContent);
    }

    public function PDFAsistencias()
{
    require_once(APPPATH.'ThirdParty/tcpdf/tcpdf.php');
    $pdf = new \App\Libraries\Pdflibrary(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetTitle('Listado de Asistencias');

    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->startPageGroup();
    $pdf->AddPage();
    $fecha = date("d-m-Y");

    $asistencias = $this->asistenciasModel->obtenerAsistenciasConTickets();

    $html = '
        <table align="center">
            <tr>
                <td style="width:150px;"></td>
                <td style="font-size:9px; text-align:center;">
                    <br>
                    Sistema de Comedor Universitario<br>
                    Universidad Nacional del Callao<br>
                    Fecha: '.$fecha.'
                </td>
                <td style="width:150px;"></td>
            </tr>
        </table>

        <br><br>

        <h3 style="text-align:center;">Listado de Asistencias</h3>

        <table align="center" style="font-size:10px; padding:5px 10px;" border="1">
            <thead>
                <tr style="background-color:#f2f2f2;">
                    <th style="width:40px; text-align:center;">#</th>
                    <th style="width:180px; text-align:center;">Nombre Estudiante</th>
                    <th style="width:110px; text-align:center;">Código Univ.</th>
                    <th style="width:100px; text-align:center;">Fecha Ticket</th>
                    <th style="width:80px; text-align:center;">Estado</th>
                </tr>
            </thead>
        </table>';

    $pdf->writeHTML($html, false, false, false, false, '');

    foreach ($asistencias as $key => $a) {
        $htmlRow = '
            <table align="center" style="font-size:9px; padding:3px 5px;" border="1">
                <tr>
                    <td style="width:40px; text-align:center;">'.($key+1).'</td>
                    <td style="width:180px;">'.$a['full_name'].'</td>
                    <td style="width:110px; text-align:center;">'.$a['student_id'].'</td>
                    <td style="width:100px; text-align:center;">'.date('d-m-Y', strtotime($a['fecha'])).'</td>
                    <td style="width:80px; text-align:center;">'.$a['estado_ticket'].'</td>
                </tr>
            </table>';
        $pdf->writeHTML($htmlRow, false, false, false, false, '');
    }

    $pdfContent = $pdf->Output('Asistencias_'.date('Ymd_His').'.pdf', 'S');

    return $this->response
        ->setHeader('Content-Type', 'application/pdf')
        ->setHeader('Content-Disposition', 'attachment; filename="Asistencias_'.date('Ymd_His').'.pdf"')
        ->setBody($pdfContent);
}

public function PDFIncidencias()
{
    require_once(APPPATH.'ThirdParty/tcpdf/tcpdf.php');
    $pdf = new \App\Libraries\Pdflibrary(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetTitle('Listado de Incidencias');

    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->startPageGroup();
    $pdf->AddPage();
    $fecha = date("d-m-Y");

    $incidencias = $this->incidenciasModel->obtenerIncidenciasConEstudiantes();

    $html = '
        <table align="center">
            <tr>
                <td style="width:150px;"></td>
                <td style="font-size:9px; text-align:center;">
                    <br>
                    Sistema de Comedor Universitario<br>
                    Universidad Nacional del Callao<br>
                    Fecha: '.$fecha.'
                </td>
                <td style="width:150px;"></td>
            </tr>
        </table>

        <br><br>

        <h3 style="text-align:center;">Listado de Incidencias</h3>

        <table align="center" style="font-size:9px; padding:4px 6px;" border="1">
            <thead>
                <tr style="background-color:#f2f2f2;">
                    <th style="width:20px; text-align:center;">#</th>
                    <th style="width:130px; text-align:center;">Nombre Estudiante</th>
                    <th style="width:75px; text-align:center;">Código Univ.</th>
                    <th style="width:170px; text-align:center;">Descripción</th>
                    <th style="width:60px; text-align:center;">Fecha</th>
                    <th style="width:45px; text-align:center;">Hora</th>
                </tr>
            </thead>
        </table>';

    $pdf->writeHTML($html, false, false, false, false, '');

    foreach ($incidencias as $key => $i) {
        $htmlRow = '
            <table align="center" style="font-size:8px; padding:3px 4px;" border="1">
                <tr>
                    <td style="width:20px; text-align:center;">'.($key+1).'</td>
                    <td style="width:130px;">'.$i['full_name'].'</td>
                    <td style="width:75px; text-align:center;">'.$i['university_code'].'</td>
                    <td style="width:170px;">'.$i['descripcion'].'</td>
                    <td style="width:60px; text-align:center;">'.date('d-m-Y', strtotime($i['fecha'])).'</td>
                    <td style="width:45px; text-align:center;">'.date('h:i A', strtotime($i['fecha'])).'</td>
                </tr>
            </table>';
        $pdf->writeHTML($htmlRow, false, false, false, false, '');
    }

    $pdfContent = $pdf->Output('Incidencias_'.date('Ymd_His').'.pdf', 'S');

    return $this->response
        ->setHeader('Content-Type', 'application/pdf')
        ->setHeader('Content-Disposition', 'attachment; filename="Incidencias_'.date('Ymd_His').'.pdf"')
        ->setBody($pdfContent);
}

public function PDFActividades()
{
    require_once(APPPATH.'ThirdParty/tcpdf/tcpdf.php');
    $pdf = new \App\Libraries\Pdflibrary(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetTitle('Listado de Actividades Estudiantiles');

    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->startPageGroup();
    $pdf->AddPage();
    $fecha = date("d-m-Y");

    $actividades = $this->actividadModel->obtenerActividadesConEstudiantes();

    $html = '
        <table align="center">
            <tr>
                <td style="width:150px;"></td>
                <td style="font-size:9px; text-align:center;">
                    <br>
                    Sistema de Comedor Universitario<br>
                    Universidad Nacional del Callao<br>
                    Fecha: '.$fecha.'
                </td>
                <td style="width:150px;"></td>
            </tr>
        </table>

        <br><br>

        <h3 style="text-align:center;">Listado de Actividades Estudiantiles</h3>

        <table align="center" style="font-size:9px; padding:4px 6px;" border="1">
            <thead>
                <tr style="background-color:#f2f2f2;">
                    <th style="width:20px; text-align:center;">#</th>
                    <th style="width:130px; text-align:center;">Nombre Estudiante</th>
                    <th style="width:75px; text-align:center;">Código Univ.</th>
                    <th style="width:170px; text-align:center;">Acción</th>
                    <th style="width:60px; text-align:center;">Fecha</th>
                    <th style="width:45px; text-align:center;">Hora</th>
                </tr>
            </thead>
        </table>';

    $pdf->writeHTML($html, false, false, false, false, '');

    foreach ($actividades as $key => $a) {
        $htmlRow = '
            <table align="center" style="font-size:8px; padding:3px 4px;" border="1">
                <tr>
                    <td style="width:20px; text-align:center;">'.($key+1).'</td>
                    <td style="width:130px;">'.$a['full_name'].'</td>
                    <td style="width:75px; text-align:center;">'.$a['university_code'].'</td>
                    <td style="width:170px;">'.$a['accion'].'</td>
                    <td style="width:60px; text-align:center;">'.date('d-m-Y', strtotime($a['fecha'])).'</td>
                    <td style="width:45px; text-align:center;">'.date('h:i A', strtotime($a['fecha'])).'</td>
                </tr>
            </table>';
        $pdf->writeHTML($htmlRow, false, false, false, false, '');
    }

    $pdfContent = $pdf->Output('Actividad_'.date('Ymd_His').'.pdf', 'S');

    return $this->response
        ->setHeader('Content-Type', 'application/pdf')
        ->setHeader('Content-Disposition', 'attachment; filename="Actividad_'.date('Ymd_His').'.pdf"')
        ->setBody($pdfContent);
}

  }