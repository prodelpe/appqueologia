<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mpdf\Mpdf;
use App\Models\Excavacio;
use App\Models\TipusRelacio;
use App\Models\UE;
use Illuminate\Support\Str;

class PdfUeController extends Controller {

    public function index($excavacio_id, $ue_id) {

        $ue = UE::findOrFail($ue_id);
        $excavacio = Excavacio::findOrFail($excavacio_id);
        $tipus_relacions = TipusRelacio::all();

        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'P',
            'margin_left' => 0,
            'margin_right' => 0,
            'margin_top' => 0,
            'margin_bottom' => 0,
            'margin_header' => 0,
            'margin_footer' => 0
        ]);

        $template_path = resource_path('pdf/blank.pdf');
        $pagecount = $mpdf->SetSourceFile($template_path);
        $tplIdx = $mpdf->ImportPage($pagecount);
        $mpdf->UseTemplate($tplIdx);

        $mpdf->SetFontSize(10);
        $mpdf->SetFont('FreeSans');

        //Població
        $mpdf->writeText(25, 48.5, strval($excavacio->poblacio));

        //Lloc
        $mpdf->writeText(93, 48.5, strval($excavacio->nom));

        //Codi
        $mpdf->writeText(164, 48.5, strval($excavacio->codi));

        //Ue
        $mpdf->writeText(25, 61, strval($ue->codi));

        //Sector
        $mpdf->writeText(42, 61, strval($ue->sector));

        //Definició
        $mpdf->writeText(93, 61, strval($ue->definicio));

        //Descripció
        $mpdf->WriteFixedPosHTML(strval($ue->descripcio), 25, 76, 162, 15, 'auto');

        //WriteFixedPosHTML sembla que desconfigura el format... el tornem a posar
        $mpdf->SetFontSize(10);
        $mpdf->SetFont('FreeSans');

        //Relacions
        foreach ($tipus_relacions as $key => $tipus_relacio) {
            $relacions = \App\Models\Relacio::join('ues', 'ues.id', '=', 'relacions.ue_desti_id')
                    ->where('relacions.excavacio_id', $excavacio->id)
                    ->where('relacions.ue_origen_id', $ue->id)
                    ->where('relacions.tipus_relacio_id', $key + 1)
                    ->get('ues.codi')
                    ->pluck('codi')
                    ->implode(', ');
            $mpdf->writeText(45, 110 + ($key * 8.45), strval($relacions));
        }

        //Interpretació
        $mpdf->WriteFixedPosHTML(strval($ue->interpretacio), 25, 214.5, 162, 15, 'auto');
        $mpdf->SetFontSize(10);
        $mpdf->SetFont('FreeSans');

        //Cronologia
        $mpdf->writeText(45, 237, strval($ue->cronologia));

        //Criteris datació
        $mpdf->writeText(45, 246, strval($ue->criteris_datacio));

        //Observacions
        $mpdf->WriteFixedPosHTML(strval($ue->observacions), 25, 260, 162, 15, 'auto');
       
        //WATERMARK
        if (config('app.demo')) {
            $mpdf->SetWatermarkText('DEMO');
            $mpdf->showWatermarkText = true;
        }

        //METADATA
        $mpdf->SetTitle(Str::slug($excavacio->nom . ' - ' . $ue->codi));
        $mpdf->SetAuthor('appQueologia');
        $mpdf->SetCreator('appQueologia');

        $mpdf->Output();
        exit;
    }

}
