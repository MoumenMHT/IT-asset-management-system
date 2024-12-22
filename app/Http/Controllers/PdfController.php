<?php

namespace App\Http\Controllers;

use App\Models\Hostory; 
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;


class PdfController extends Controller
{
    public function generatePdf($affectationId)
    {
        $affectation = Hostory::findOrFail($affectationId);
        $currentDate = Carbon::now()->format('Y-m-d'); // Outputs: 2024-12-19

        
        // Use PDF instead of Facade
        $pdf = PDF::loadView('pdf.affectation', compact('affectation','currentDate'));

        // Return the PDF as a download
        return $pdf->download('affectation-details.pdf');
    }
}
