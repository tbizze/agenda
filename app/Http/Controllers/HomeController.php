<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Number;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function test(Request $request)
    {
        $eventos = Evento::all();
        //dd($eventos->toArray());

        echo Number::format(1234567.89) . "<br><br>"; // 100,000
        echo Number::format(1234567.89,locale: 'pt-br') . "<br><br>"; // 100,000
        echo Number::percentage(25) . "<br>"; // 25%
        echo Number::percentage((1/3) * 100, precision: 2) . "<br><br>"; // 33.33%

        echo Number::currency(10) . "<br>"; // $10.00
        echo Number::currency(25, 'EUR') . "<br>"; // €25.00
        echo Number::currency(25, 'BRL') . "<br>"; // R$25.00
        echo Number::currency(5.49, 'EUR', locale: 'de') . "<br><br>"; // 5.49 €

        echo Number::forHumans(1000) . "<br>"; // 1 thousand
        echo Number::spell(457.50) . "<br>";
        echo Number::ordinal(156) . "<br>";

        //dd($var);

    }

    public function clone($id){
        $post = Evento::find($id);
        $newPost = $post->replicate();
        $newPost->created_at = Carbon::now();
        //$newPost->save();

        dd($post,$newPost);

    }

    public function pdf() {
        $data = [
            [
                'quantity' => 1,
                'description' => '1 Year Subscription',
                'price' => '129.00'
            ]
        ];
        
        $pdf = Pdf::loadView('pdfs.exemplo', ['data' => $data]);
        //dd($pdf);

        //$pdf = Pdf::loadView('pdfs.exemplo');
     
        //return $pdf->download('recibo.pdf');
        return $pdf->stream('recibo.pdf');
    }
}
