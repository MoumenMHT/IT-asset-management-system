<?php

namespace App\Http\Controllers;

use App\Models\Hostory; 
use Barryvdh\DomPDF\Facade as PDF;

class PdfController extends Controller
{
    public function generatePdf($affectationId)
    {
        $affectation = Hostory::findOrFail($affectationId);
        
        // Use PDF instead of Facade
        $pdf = PDF::loadView('pdf.affectation', compact('affectation'));

        // Return the PDF as a download
        return $pdf->download('affectation-details.pdf');
    }
}
