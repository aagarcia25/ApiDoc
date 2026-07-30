<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Correos;
use Barryvdh\DomPDF\Facade\Pdf;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

class ForoController extends Controller
{
    public function acceso($id)
    {
        $registro = Correos::find($id);

        if (!$registro) {
            return response()->json([
                'ok' => false,
                'message' => 'Registro no encontrado'
            ],404);
        }

        $hoy = now();

        if ($hoy->isSameDay(\Carbon\Carbon::create(2026, 7, 3))) {

            if (!$registro->acceso_jueves) {
                $registro->acceso_jueves = $hoy;
            }

        }
        // Viernes 25 de septiembre de 2026
        elseif ($hoy->isSameDay(\Carbon\Carbon::create(2026, 9, 25))) {

            if (!$registro->acceso_viernes) {
                $registro->acceso_viernes = $hoy;
            }

        } else {

            return response()->json([
                'ok' => false,
                'message' => 'Hoy no es un día válido para registrar asistencia.'
            ], 400);

        }

        return response()->json([
            'ok'=>true,
            'message'=>'Asistencia registrada'
        ]);
    }

    public function certificadoPdf($id)
    {
        $registro = Correos::find($id);

        if (!$registro) {
            abort(404);
        }

        if (!$registro->acceso_jueves || !$registro->acceso_viernes) {
            abort(403, 'El participante no cumple con la asistencia requerida.');
        }

        $pdf = Pdf::loadView(
            'pdf.forocontabilidad',
            compact('registro')
        );

        $pdf->setPaper('letter', 'landscape');

        $result = Builder::create()
            ->writer(new PngWriter())
            ->data('https://tesoreriavirtual.nl.gob.mx/jornada-auditoria-contabilidad-gubernamental/constancia/' . $id)
            ->size(220)
            ->margin(1)
            ->build();

        $qr = $result->getString();

        $pdf = Pdf::loadView(
            'pdf.forocontabilidad',
            compact('registro', 'qr')
        );

        $pdf->setPaper('letter', 'landscape');

        return $pdf->download(
            'Constancia-'.$registro->nombre.'.pdf'
        );
    }
    public function dashboard()
    {
        $registros = Correos::orderBy('created_at', 'desc')->get();

        return response()->json([
            'ok' => true,
            'total' => $registros->count(),
            'data' => $registros,
        ]);
    }
    public function participante($id)
    {
        $registro = Correos::find($id);

        if (!$registro) {
            return response()->json([
                'ok' => false,
                'message' => 'Registro no encontrado'
            ], 404);
        }

        return response()->json([
            'ok' => true,
            'registro' => [
                'id' => $registro->id,
                'nombre_completo' => trim(
                    $registro->nombre . ' ' .
                    $registro->apellido_paterno . ' ' .
                    $registro->apellido_materno
                ),
                'acceso_jueves' => $registro->acceso_jueves,
                'acceso_viernes' => $registro->acceso_viernes,
                'puede_descargar_constancia' =>
                    !is_null($registro->acceso_jueves) &&
                    !is_null($registro->acceso_viernes)
            ]
        ]);
    }
}
