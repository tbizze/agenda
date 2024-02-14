<?php

namespace App\Http\Controllers;

use App\Models\EventoArea;
use App\Http\Requests\StoreEventoAreaRequest;
use App\Http\Requests\UpdateEventoAreaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class EventoAreaController extends Controller
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
        $event_areas = EventoArea::query();
        
        
        // 3) Aplica filtros a Query:
        // Se passado dados no campo 'search' ==> Pesquisa na coluna 'description'.
        $event_areas->when($request->search, function ($query, $vl){
            $query->where('nome', 'like', '%' . $vl . '%');
        });
        // Se passado dados no SelectBox 'grupo_id' ==> Pesquisa os ID's passados.
        /* $pessoas->when($request->grupo_id, function ($query, $vl){
            $query->whereIn('lcto_grupo_id', $vl);
        }); */
        
        // 4) Aplica ordem a Query
        // Se acionado alguma coluna de ordenar, realiza o OrderBy.
        $event_areas->when($request->field, 
            function ($query, $vl){
                $query->orderBy($vl, request()->direction);
            }, 
            // Ordenamento padrão: ID ascendente
            function ($query, $vl){
                $query->orderBy('id', 'desc');
            });
        
        // 5) Executa a Query montada com paginação.
        $event_areas = $event_areas->paginate(10);

        // Define o título da página.
        $titulo = 'Áreas de Eventos';

        // Renderiza a View Inertia.
        return Inertia::render('Evento/EventoAreaIndex',[
            'titulo' => $titulo,
            'dados' => $event_areas,
            'filters' => $request,
            //'grupos' => $grupos,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Define o título da página.
        $titulo = 'Criar Área de Eventos';

        // Renderiza a View Inertia.
        return Inertia::render('Evento/EventoAreaCreate',[
            'titulo' => $titulo,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventoAreaRequest $request)
    {
        try {
            DB::transaction(function () use($request) {
                
                // Cria um model com os dados aprovados nas validações...
                // Persiste o model atualizado no DB.
                EventoArea::create($request->validated());
            });
            } catch (\Exception $ex) {
                //dd($ex->getMessage());
                // Note any method of class PDOException can be called on $ex.
    
                // Volta para a página do formulário.
                return redirect()->back()->with('danger', 'Não foi possível salvar. Favor, verificar!');
            }
    
            // Redireciona para index.
            return redirect()->route('evento-areas.index')->with('success', 'Registro criado com sucesso!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EventoArea $eventoArea)
    {
        // Define o título da página.
        $titulo = 'Editar Área de Evento';

        // Renderiza a View Inertia.
        return Inertia::render('Evento/EventoAreaEdit',[
            'titulo' => $titulo,
            'registro' => $eventoArea,
            //'campanha' => $campanha,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventoAreaRequest $request, EventoArea $eventoArea)
    {
        
        try { 
            DB::transaction(function () use($request, $eventoArea) {
                // Carrega no model atual os dados aprovados nas validações, para persistir no DB.
                //dd($request);
                $eventoArea->fill($request->validated());
                // Persiste o model atualizado no DB.
                $eventoArea->save();
            });
          } catch(\Exception $ex){ 
            //dd($ex->getMessage()); 
            // Note any method of class PDOException can be called on $ex.
            // Volta para a página do formulário.
            return redirect()->back()->with('danger', 'Não foi possível salvar. Favor, verificar!');
          }
        
        // Redireciona para index.
        return redirect()->route('evento-areas.index')->with('success', 'Registro atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventoArea $eventoArea)
    {
        try { 
            DB::transaction(function () use($eventoArea) {
                // Exclui do DB o registro.
                $eventoArea->delete();
            });
          } catch(\Exception $ex){ 
            //dd($ex->getMessage()); 
            // Note any method of class PDOException can be called on $ex.
            
            // Volta para a página do formulário.
            return redirect()->back()->with('danger', 'Não foi possível salvar. Favor, verificar!');
          }
        
        // Redireciona para index.
        return redirect()->route('evento-areas.index')->with('success', 'Registro excluído com sucesso!');
    }
}
