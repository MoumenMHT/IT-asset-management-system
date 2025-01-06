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
        $currentDate = Carbon::now()->format('Y-m-d');

        if($affectation->type === 'affectation'){
            $tittle = "DÉCHARGE AFFECTATION";   
            $description = "Il a été remis ce jours,à Mr,";
        }else{
            $tittle = "RESTITUTION D'EQUIPEMENT INFORMATIQUE ";
            $description = "Il a été restitué ce jours,de la part de monsieur ";
        }

        
        // Use PDF instead of Facade
        $pdf = PDF::loadView('pdf.affectation', compact('affectation','currentDate', 'tittle', 'description'));

        // Return the PDF as a download
        return $pdf->download('affectation-details.pdf');
    }
}
