<?php

namespace App\Http\Controllers;

use App\Models\EventoLocal;
use App\Http\Requests\StoreEventoLocalRequest;
use App\Http\Requests\UpdateEventoLocalRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class EventoLocalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // dd($request->grupo_id);
        // Verifica se o campo 'grupo_id' tem dados. Se tiver irá limpar.
        /* if ($request->grupo_id){
            $request->grupo_id = preg_replace('/[^\d\-]/','', $request->grupo_id); // limpa permitindo somente números.
            $request->grupo_id = array_map('intval', $request->grupo_id); // transforma o array string em array number.
        } */

        // 1) Valida os dados submetidos
        $request->validate([
            'direction' => ['in:asc,desc'],
            'field'     => ['in:nome'],
        ]);

        // 2) Instancia o modelo:
        // Se houver relacionamentos => with('roles') ou então query().
        $event_locais = EventoLocal::query();
        
        
        // 3) Aplica filtros a Query:
        // Se passado dados no campo 'search' ==> Pesquisa na coluna 'description'.
        $event_locais->when($request->search, function ($query, $vl){
            $query->where('nome', 'like', '%' . $vl . '%');
        });
        // Se passado dados no SelectBox 'grupo_id' ==> Pesquisa os ID's passados.
        /* $pessoas->when($request->grupo_id, function ($query, $vl){
            $query->whereIn('lcto_grupo_id', $vl);
        }); */
        
        // 4) Aplica ordem a Query
        // Se acionado alguma coluna de ordenar, realiza o OrderBy.
        $event_locais->when($request->field, 
            function ($query, $vl){
                $query->orderBy($vl, request()->direction);
            }, 
            // Ordenamento padrão: ID ascendente
            function ($query, $vl){
                $query->orderBy('id', 'desc');
            });
        
        // 5) Executa a Query montada com paginação.
        $event_locais = $event_locais->paginate(10);

        // Define o título da página.
        $titulo = 'Locais de Eventos';

        // Renderiza a View Inertia.
        return Inertia::render('Evento/EventoLocalIndex',[
            'titulo' => $titulo,
            'dados' => $event_locais,
            'filters' => $request,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Define o título da página.
        $titulo = 'Criar Local de Eventos';

        // Renderiza a View Inertia.
        return Inertia::render('Evento/EventoLocalCreate',[
            'titulo' => $titulo,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventoLocalRequest $request)
    {
        try {
            DB::transaction(function () use($request) {
                
                // Cria um model com os dados aprovados nas validações...
                // Persiste o model atualizado no DB.
                EventoLocal::create($request->validated());
            });
            } catch (\Exception $ex) {
                //dd($ex->getMessage());
                // Note any method of class PDOException can be called on $ex.
    
                // Volta para a página do formulário.
                return redirect()->back()->with('danger', 'Não foi possível salvar. Favor, verificar!');
            }
    
            // Redireciona para index.
            return redirect()->route('evento-locals.index')->with('success', 'Registro criado com sucesso!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EventoLocal $eventoLocal)
    {
        //dd($eventoLocal);
        // Define o título da página.
        $titulo = 'Editar Local de Eventos';

        // Renderiza a View Inertia.
        return Inertia::render('Evento/EventoLocalEdit',[
            'titulo' => $titulo,
            'registro' => $eventoLocal,
            //'campanha' => $campanha,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventoLocalRequest $request, EventoLocal $eventoLocal)
    {
        try { 
            DB::transaction(function () use($request, $eventoLocal) {
                // Carrega no model atual os dados aprovados nas validações, para persistir no DB.
                //dd($request);
                $eventoLocal->fill($request->validated());
                // Persiste o model atualizado no DB.
                $eventoLocal->save();
            });
          } catch(\Exception $ex){ 
            //dd($ex->getMessage()); 
            // Note any method of class PDOException can be called on $ex.
            // Volta para a página do formulário.
            return redirect()->back()->with('danger', 'Não foi possível salvar. Favor, verificar!');
          }
        
        // Redireciona para index.
        return redirect()->route('evento-locals.index')->with('success', 'Registro atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventoLocal $eventoLocal)
    {
        try { 
            DB::transaction(function () use($eventoLocal) {
                // Exclui do DB o registro.
                $eventoLocal->delete();
            });
          } catch(\Exception $ex){ 
            //dd($ex->getMessage()); 
            // Note any method of class PDOException can be called on $ex.
            
            // Volta para a página do formulário.
            return redirect()->back()->with('danger', 'Não foi possível salvar. Favor, verificar!');
          }
        
        // Redireciona para index.
        return redirect()->route('evento-locals.index')->with('success', 'Registro excluído com sucesso!');
    }
}
