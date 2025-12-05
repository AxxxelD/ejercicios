<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::all();
        return response()->json($reports);
    }

    public function export(string $report_type)
    {
        $datos = [
            ['ID' => 1, 'Metric' => 'Total Users', 'Value' => 1500, 'Date' => '2023-12-01'],
            ['ID' => 2, 'Metric' => 'New Signups', 'Value' => 50, 'Date' => '2023-12-01'],
            ['ID' => 3, 'Metric' => 'Monthly Revenue', 'Value' => 12500.50, 'Date' => '2023-11-30'],
        ];

        if ($report_type == 'general_metrics') {
            $data = $datos;
            $fileName = 'metrics_report_' . now()->format('Ymd_His') . '.csv';
            $headers = array_keys($dummyData[0] ?? []);
        } else {
            return response()->json(['error' => 'Tipo de reporte no válido'], 404);
        }

        $callback = function () use ($data, $headers) {
            $file = fopen('php://output', 'w');

            // 1. Escribir los encabezados
            if (!empty($headers)) {
                fputcsv($file, $headers);
            }

            // 2. Escribir los datos
            foreach ($data as $row) {
                $exportRow = [];
                foreach ($headers as $header) {
                    $exportRow[] = $row[$header] ?? '';
                }
                fputcsv($file, $exportRow);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '";',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'report_name' => 'required|string|max:255',
            'report_type' => 'required|string|max:50',
        ]);
        $report = Report::create($request->all());
        return response()->json($report, 201);
    }

    public function show(Report $report)
    {
        return response()->json($report);
    }

    public function update(Request $request, Report $report)
    {
        $request->validate([
            'report_name' => 'string|max:255',
            'report_type' => 'string|max:50',
        ]);
        $report->update($request->all());
        return response()->json($report);
    }

    public function destroy(Report $report)
    {
        $report->delete();
        return response()->json(null, 204);
    }
}
