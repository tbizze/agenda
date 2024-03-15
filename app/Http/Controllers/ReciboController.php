<?php

namespace App\Http\Controllers;

use App\Models\Recibo;
use App\Http\Requests\StoreReciboRequest;
use App\Http\Requests\UpdateReciboRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ReciboController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // 1) Valida os dados submetidos
        $request->validate([
            'direction' => ['in:asc,desc'],
            'field'     => ['in:pagador,recebedor'],
        ]);

        // 2) Instancia o modelo:
        // Se houver relacionamentos => with('roles') ou então query().
        $recibos = Recibo::query();
        
        
        // 3) Aplica filtros a Query:
        // Se passado dados no campo 'search' ==> Pesquisa na coluna 'description'.
        $recibos->when($request->search, function ($query, $vl){
            $query->where('nome', 'like', '%' . $vl . '%');
        });
        // Se passado dados no SelectBox 'grupo_id' ==> Pesquisa os ID's passados.
        /* $pessoas->when($request->grupo_id, function ($query, $vl){
            $query->whereIn('lcto_grupo_id', $vl);
        }); */
        
        // 4) Aplica ordem a Query
        // Se acionado alguma coluna de ordenar, realiza o OrderBy.
        $recibos->when($request->field, 
            function ($query, $vl){
                $query->orderBy($vl, request()->direction);
            }, 
            // Ordenamento padrão: ID ascendente
            function ($query, $vl){
                $query->orderBy('id', 'desc');
            });
        
        // 5) Executa a Query montada com paginação.
        $recibos = $recibos->paginate(10);
//dd($recibos);
        // Define o título da página.
        $titulo = 'Recibos';

        // Renderiza a View Inertia.
        return Inertia::render('Recibo/ReciboIndex',[
            'titulo' => $titulo,
            'dados' => $recibos,
            'filters' => $request,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Define o título da página.
        $titulo = 'Criar Recibos';

        // Renderiza a View Inertia.
        return Inertia::render('Recibo/ReciboCreate',[
            'titulo' => $titulo,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReciboRequest $request)
    {
        try {
            DB::transaction(function () use($request) {
                
                // Cria um model com os dados aprovados nas validações...
                // Persiste o model atualizado no DB.
                Recibo::create($request->validated());
            });
            } catch (\Exception $ex) {
                //dd($ex->getMessage());
                // Note any method of class PDOException can be called on $ex.
    
                // Volta para a página do formulário.
                return redirect()->back()->with('danger', 'Não foi possível salvar. Favor, verificar!');
            }
    
            // Redireciona para index.
            return redirect()->route('recibos.index')->with('success', 'Registro criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Recibo $recibo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Recibo $recibo)
    {
        //dd($eventoLocal);
        // Define o título da página.
        $titulo = 'Editar Recibo';

        // Renderiza a View Inertia.
        return Inertia::render('Recibo/ReciboEdit',[
            'titulo' => $titulo,
            'registro' => $recibo,
        ]);
    }

    public function replicate(Recibo $recibo)
    {
        // O método 'replicate()' faz um clone no modelo carregado, ignorando as colunas: id e timestamp.
        $newEvento = $recibo->replicate();

        // Define o título da página.
        $titulo = 'Clonar Recibo';

        // Renderiza a View Inertia.
        return Inertia::render('Recibo/ReciboEdit', [
            'titulo' => $titulo,
            'registro' => $newEvento,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReciboRequest $request, Recibo $recibo)
    {
        //dd($request);
        try { 
            DB::transaction(function () use($request, $recibo) {
                // Carrega no model atual os dados aprovados nas validações, para persistir no DB.
                //dd($request);
                $recibo->fill($request->validated());
                // Persiste o model atualizado no DB.
                $recibo->save();
            });
          } catch(\Exception $ex){ 
            //dd($ex->getMessage()); 
            // Note any method of class PDOException can be called on $ex.
            // Volta para a página do formulário.
            return redirect()->back()->with('danger', 'Não foi possível salvar. Favor, verificar!');
          }
        
        // Redireciona para index.
        return redirect()->route('recibos.index')->with('success', 'Registro atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recibo $recibo)
    {
        //
    }

    public function pdf(Recibo $recibo)
    {
        //dd($recibo,$recibo->valor_extenso);

        $titulo = 'Recibo de Pagamento';

        $pdf = Pdf::loadView('pdfs.recibo', [
            'titulo' => $titulo,
            'dados' => $recibo,
            'segunda_via' => true,
        ]);
     
        //return $pdf->download('recibo.pdf');
        return $pdf->stream('Recibo.pdf');

    }
}
