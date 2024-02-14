<?php

namespace App\Http\Controllers;

use App\Models\EventoGrupo;
use App\Http\Requests\StoreEventoGrupoRequest;
use App\Http\Requests\UpdateEventoGrupoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class EventoGrupoController extends Controller
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
        $event_grupos = EventoGrupo::query();
        
        
        // 3) Aplica filtros a Query:
        // Se passado dados no campo 'search' ==> Pesquisa na coluna 'description'.
        $event_grupos->when($request->search, function ($query, $vl){
            $query->where('nome', 'like', '%' . $vl . '%');
        });
        // Se passado dados no SelectBox 'grupo_id' ==> Pesquisa os ID's passados.
        /* $pessoas->when($request->grupo_id, function ($query, $vl){
            $query->whereIn('lcto_grupo_id', $vl);
        }); */
        
        // 4) Aplica ordem a Query
        // Se acionado alguma coluna de ordenar, realiza o OrderBy.
        $event_grupos->when($request->field, 
            function ($query, $vl){
                $query->orderBy($vl, request()->direction);
            }, 
            // Ordenamento padrão: ID ascendente
            function ($query, $vl){
                $query->orderBy('id', 'desc');
            });
        
        // 5) Executa a Query montada com paginação.
        $event_grupos = $event_grupos->paginate(10);

        // Define o título da página.
        $titulo = 'Grupos de Eventos';

        // Busca os grupos para passar ao ListBox.
        // Renomeia coluna id=>value | nome=>label
        //$grupos = PessGpo::get(['id as value', 'nome as label']);
        //$grupos = PessGpo::pluck('nome','id');
//dd($event_grupos);
        // Renderiza a View Inertia.
        return Inertia::render('Evento/EventoGrupoIndex',[
            'titulo' => $titulo,
            'dados' => $event_grupos,
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
        $titulo = 'Criar Grupo de Eventos';

        // Renderiza a View Inertia.
        return Inertia::render('Evento/EventoGrupoCreate',[
            'titulo' => $titulo,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventoGrupoRequest $request)
    {
        //dd($request);
        try {
            DB::transaction(function () use($request) {
                
                // Cria um model com os dados aprovados nas validações...
                // Persiste o model atualizado no DB.
                $pessoa = EventoGrupo::create($request->validated());
            });
            } catch (\Exception $ex) {
                //dd($ex->getMessage());
                // Note any method of class PDOException can be called on $ex.
    
                // Volta para a página do formulário.
                return redirect()->back()->with('danger', 'Não foi possível salvar. Favor, verificar!');
            }
    
            // Redireciona para index.
            return redirect()->route('evento-grupos.index')->with('success', 'Registro criado com sucesso!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EventoGrupo $eventoGrupo)
    {
        // Define o título da página.
        $titulo = 'Editar Grupo de Evento';

        // Renderiza a View Inertia.
        return Inertia::render('Evento/EventoGrupoEdit',[
            'titulo' => $titulo,
            'registro' => $eventoGrupo,
            //'campanha' => $campanha,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventoGrupoRequest $request, EventoGrupo $eventoGrupo)
    {
        try { 
            DB::transaction(function () use($request, $eventoGrupo) {
                // Carrega no model atual os dados aprovados nas validações, para persistir no DB.
                $eventoGrupo->fill($request->validated());
                // Persiste o model atualizado no DB.
                $eventoGrupo->save();
            });
          } catch(\Exception $ex){ 
            //dd($ex->getMessage()); 
            // Note any method of class PDOException can be called on $ex.
            // Volta para a página do formulário.
            return redirect()->back()->with('danger', 'Não foi possível salvar. Favor, verificar!');
          }
        
        // Redireciona para index.
        return redirect()->route('evento-grupos.index')->with('success', 'Registro atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventoGrupo $eventoGrupo)
    {
        try { 
            DB::transaction(function () use($eventoGrupo) {
                // Exclui do DB o registro.
                $eventoGrupo->delete();
            });
          } catch(\Exception $ex){ 
            //dd($ex->getMessage()); 
            // Note any method of class PDOException can be called on $ex.
            
            // Volta para a página do formulário.
            return redirect()->back()->with('danger', 'Não foi possível salvar. Favor, verificar!');
          }
        
        // Redireciona para index.
        return redirect()->route('evento-grupos.index')->with('success', 'Registro excluído com sucesso!');
    }
}
