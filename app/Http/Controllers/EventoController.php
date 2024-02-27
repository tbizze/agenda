<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Http\Requests\StoreEventoRequest;
use App\Http\Requests\UpdateEventoRequest;
use App\Models\EventoArea;
use App\Models\EventoGrupo;
use App\Models\EventoLocal;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class EventoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // 1) Valida os dados submetidos
        $request->validate([
            'direction' => ['in:asc,desc'],
            'field'     => ['in:nome,start_date'],
            'dia_mes'     => ['integer'],
            'grupo_id'     => ['array'],
            'local_id'     => ['array'],
            'area_id'     => ['array'],
        ]);

        // 2) Instancia o modelo:
        // Se houver relacionamentos => with('roles') ou então query().
        $eventos = Evento::with(['areas', 'toGrupo', 'toLocal']);

        // 3) Aplica filtros a Query:
        // Se passado dados no campo 'search' ==> Pesquisa na coluna 'description'.
        $eventos->when($request->search, function ($query, $vl) {
            $query->where('nome', 'like', '%' . $vl . '%');
        });
        // Se passado dados no SelectBox 'grupo_id' ==> Pesquisa os ID's passados.
        $eventos->when($request->grupo_id, function ($query, $vl) {
            $query->whereIn('evento_grupo_id', $vl);
        });
        // Se passado dados no SelectBox 'local_id' ==> Pesquisa os ID's passados.
        $eventos->when($request->local_id, function ($query, $vl) {
            $query->whereIn('evento_local_id', $vl);
        });
        // Se passado dados no SelectBox 'area_id' ==> Pesquisa os ID's passados.
        $eventos->when($request->area_id, function ($query, $vl) {
            $query->whereHas('areas', function($q) use($vl){
                $q->whereIn('evento_areas.id', $vl);
            });
        });
        // Se passado dados no SelectBox 'dia_mes' ==> Pesquisa os ID's passados.
        $eventos->when($request->dia_mes, function ($query, $vl) {
            $query->whereMonth('start_date', $vl);
        });

        // 4) Aplica ordem a Query
        // Se acionado alguma coluna de ordenar, realiza o OrderBy.
        $eventos->when(
            $request->field,
            function ($query, $vl) {
                $query->orderBy($vl, request()->direction);
            },
            // Ordenamento padrão: ID ascendente
            function ($query, $vl) {
                $query->orderBy('id', 'desc');
            }
        );

        // 5) Executa a Query montada com paginação.
        $eventos = $eventos->paginate(20);

        // Define o título da página.
        $titulo = 'Eventos';

        // Busca os grupos para passar ao ListBox.
        // Renomeia coluna id=>value | nome=>label
        $grupos = EventoGrupo::orderBy('nome')->get(['id as value', 'nome as label']);
        $areas = EventoArea::orderBy('nome')->get(['id as value', 'nome as label']);
        //$grupos = EventoGrupo::orderBy('nome')->pluck('nome','id')->dd();

        $locais = EventoLocal::get(['id as value', 'nome as label']);
        $meses = get_meses();

        // Renderiza a View Inertia.
        return Inertia::render('Evento/EventoIndex', [
            'titulo' => $titulo,
            'dados' => $eventos,
            'filters' => $request,
            'grupos' => $grupos,
            'locais' => $locais,
            'areas' => $areas,
            'meses' => $meses,
        ]);
    }

    public function view(Request $request)
    {
        $trashed = EventoGrupo::onlyTrashed()->get()->dd();
        dd(Evento::with(['areas','toGrupo'])->get());

        // 1) Valida os dados submetidos
        $request->validate([
            'direction' => ['in:asc,desc'],
            'field'     => ['in:nome,start_date'],
            'dia_mes'     => ['integer'],
            'grupo_id'     => ['array'],
            'local_id'     => ['array'],
            'area_id'     => ['array'],
        ]);

        // 2) Instancia o modelo:
        // Se houver relacionamentos => with('roles') ou então query().
        $eventos = Evento::with(['areas', 'toGrupo', 'toLocal']);


        // 3) Aplica filtros a Query:
        // Se passado dados no campo 'search' ==> Pesquisa na coluna 'description'.
        $eventos->when($request->search, function ($query, $vl) {
            $query->where('nome', 'like', '%' . $vl . '%');
        });
        // Se passado dados no SelectBox 'grupo_id' ==> Pesquisa os ID's passados.
        $eventos->when($request->grupo_id, function ($query, $vl) {
            $query->whereIn('evento_grupo_id', $vl);
        });
        // Se passado dados no SelectBox 'local_id' ==> Pesquisa os ID's passados.
        $eventos->when($request->local_id, function ($query, $vl) {
            $query->whereIn('evento_local_id', $vl);
        });
        // Se passado dados no SelectBox 'area_id' ==> Pesquisa os ID's passados.
        $eventos->when($request->area_id, function ($query, $vl) {
            $query->whereHas('areas', function($q) use($vl){
                $q->whereIn('evento_areas.id', $vl);
            });
        });
        // Se passado dados no SelectBox 'dia_mes' ==> Pesquisa os ID's passados.
        $eventos->when($request->dia_mes, function ($query, $vl) {
            $query->fillDiaMes($vl); // ou dessa maneira => $query->whereMonth('start_date', $vl);
        });

        //$eventos->select(DB::raw('MONTH(start_date) as numero_mes'));
        //$eventos->addSelect(DB::raw('MONTH(start_date) as numero_mes'));

        //$eventos->groupByRaw(DB::raw('MONTH(start_date) as numero_mes'));
        //$eventos->groupBy(DB::raw("MONTH(start_date)"));
        //$eventos->groupBy('evento_grupo_id');


        //$eventos->orderByRaw('MONTH(start_date) desc');

        //dd($eventos->toSql());
        //dd($eventos->get()->toArray());

        // 4) Aplica ordem a Query
        // Se acionado alguma coluna de ordenar, realiza o OrderBy.
        $eventos->orderByRaw('MONTH(start_date) asc');
        $eventos->orderByRaw('DAY(start_date) asc');
        $eventos->orderBy('start_time');

        $eventos->when(
            $request->field,
            function ($query, $vl) {
                $query->orderBy($vl, request()->direction);
            },
            // Ordenamento padrão: ID ascendente
            function ($query, $vl) {
                $query->orderBy('id', 'desc');
            }
        );

        // 5) Executa a Query montada com paginação.
        $eventos = $eventos->paginate(50);

        // Define o título da página.
        $titulo = 'Eventos listar';

        // Busca os grupos para passar ao ListBox.
        // Renomeia coluna id=>value | nome=>label
        $grupos = EventoGrupo::orderBy('nome')->get(['id as value', 'nome as label']);
        $locais = EventoLocal::get(['id as value', 'nome as label']);
        $areas = EventoArea::get(['id as value', 'nome as label']);
        $meses = get_meses();

        //dd($eventos);
        // Renderiza a View Inertia.
        return Inertia::render('Evento/EventoView', [
            'titulo' => $titulo,
            'dados' => $eventos,
            'filters' => $request,
            'grupos' => $grupos,
            'locais' => $locais,
            'areas' => $areas,
            'meses' => $meses,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //$grupos = EventoGrupo::get(['id as value', 'nome as label']);
        $grupos = EventoGrupo::orderBy('nome')->get(['id', 'nome']);
        $locais = EventoLocal::get(['id', 'nome']);
        $areas = EventoArea::get(['id', 'nome']);

        // Define o título da página.
        $titulo = 'Criar Eventos';

        // Renderiza a View Inertia.
        return Inertia::render('Evento/EventoCreate', [
            'titulo' => $titulo,
            'grupos' => $grupos,
            'locais' => $locais,
            'areas' => $areas,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventoRequest $request)
    {
        //dd($request);
        try {
            DB::transaction(function () use ($request) {

                // Cria um model com os dados aprovados nas validações...
                // Persiste o model atualizado no DB.
                $evento = Evento::create($request->validated());

                // Salva as áreas na tabela Pivô
                //$evento->areas()->attach($request->evento_areas);
                $evento->areas()->sync($request->evento_areas);
            });
        } catch (\Exception $ex) {
            //dd($ex->getMessage());
            // Note any method of class PDOException can be called on $ex.

            // Volta para a página do formulário.
            return redirect()->back()->with('danger', 'Não foi possível salvar. Favor, verificar!');
        }

        // Redireciona para index.
        return redirect()->route('eventos.index')->with('success', 'Registro criado com sucesso!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Evento $evento)
    {
        //$grupos = EventoGrupo::get(['id as value', 'nome as label']);
        $grupos = EventoGrupo::orderBy('nome')->get(['id', 'nome']);
        $locais = EventoLocal::get(['id', 'nome']);
        $areas = EventoArea::get(['id', 'nome']);

        // Método pluck('role_id') coloca a coluna definida num array.
        //$permission_roles = DB::table('role_has_permissions')->where('permission_id',$permission->id)->pluck('role_id');
        $evento_areas = $evento->areas->pluck('id');

        // Define o título da página.
        $titulo = 'Editar Evento';

        // Renderiza a View Inertia.
        return Inertia::render('Evento/EventoEdit', [
            'titulo' => $titulo,
            'registro' => $evento,
            'grupos' => $grupos,
            'locais' => $locais,
            'areas' => $areas,
            'evento_areas' => $evento_areas,
        ]);
    }
    public function replicate(Evento $evento)
    {
        //$grupos = EventoGrupo::get(['id as value', 'nome as label']);
        $grupos = EventoGrupo::orderBy('nome')->get(['id', 'nome']);
        $locais = EventoLocal::get(['id', 'nome']);
        $areas = EventoArea::get(['id', 'nome']);

        // Método pluck('role_id') coloca a coluna definida num array.
        //$permission_roles = DB::table('role_has_permissions')->where('permission_id',$permission->id)->pluck('role_id');
        $evento_areas = $evento->areas->pluck('id');

        // O método 'replicate()' faz um clone no modelo carregado, ignorando as colunas: id e timestamp.
        $newEvento = $evento->replicate();

        // Define o título da página.
        $titulo = 'Clonar Evento';

        // Renderiza a View Inertia.
        return Inertia::render('Evento/EventoEdit', [
            'titulo' => $titulo,
            'registro' => $newEvento,
            'grupos' => $grupos,
            'locais' => $locais,
            'areas' => $areas,
            'evento_areas' => $evento_areas,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventoRequest $request, Evento $evento)
    {
        //dd($request->all());
        try {
            DB::transaction(function () use ($request, $evento) {
                // Carrega no model atual os dados aprovados nas validações, para persistir no DB.
                $evento->fill($request->validated());
                // Persiste o model atualizado no DB.
                $evento->save();

                // Salva as áreas na tabela Pivô
                //$evento->areas()->attach($request->evento_areas);
                $evento->areas()->sync($request->evento_areas);
            });
        } catch (\Exception $ex) {
            //dd($ex->getMessage()); 
            // Note any method of class PDOException can be called on $ex.
            // Volta para a página do formulário.
            return redirect()->back()->with('danger', 'Não foi possível salvar. Favor, verificar!');
        }

        // Redireciona para index.
        return redirect()->route('eventos.index')->with('success', 'Registro atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Evento $evento)
    {
        try {
            DB::transaction(function () use ($evento) {
                // Exclui possíveis registros na tabela pivot relacionada a este usuário.
                $evento->areas()->detach();

                // Exclui do DB o registro.
                $evento->delete();
            });
        } catch (\Exception $ex) {
            //dd($ex->getMessage()); 
            // Note any method of class PDOException can be called on $ex.

            // Volta para a página do formulário.
            return redirect()->back()->with('danger', 'Não foi possível salvar. Favor, verificar!');
        }

        // Redireciona para index.
        return redirect()->route('eventos.index')->with('success', 'Registro excluído com sucesso!');
    }

    public function calendar(Request $request)
    {
        $all_eventos = Evento::all();
        $dados = [];

        foreach ($all_eventos as $evento) {

            /* $areas = $evento->areas;
            if ($areas[0]->id == 1) {
                $color_event = '#b434eb'; // diocesano
            } elseif ($areas[0]->id == 2) {
                $color_event = '#099c5a'; // paroquial
            } elseif ($areas[0]->id == 6) {
                $color_event = '#eba834'; // CDP
            } elseif ($areas[0]->id == 7) {
                $color_event = '#d93830'; // CDP 
            } else {
                $color_event = '#3480eb'; // paroquial
            } */

            foreach ($evento->areas as $area) {
                switch ($area->id) {
                    case 1:
                        $color_event = '#b434eb'; // diocesano
                        break;
                    case 2:
                        $color_event = '#099c5a'; // paroquial
                        break;
                    case 6:
                        $color_event = '#eba834'; // CDP
                        break;
                    case 7:
                        $color_event = '#d93830'; // padre 
                        break;
                    default:
                        $color_event = '#3480eb'; // paroquial
                        break;
                }
            }

            $dados[] = [
                'id' => $evento->id,
                'title' => $evento->nome,
                'start' => $evento->startDateFull,
                'end' => $evento->end_date,
                'allDay' => $evento->all_day,
                'color' => $color_event,
                //'area' => $areas[0]->id
            ];
        }

        //dd($dados);
        // Define o título da página.
        $titulo = 'Calendário';

        // Renderiza a View Inertia.
        return Inertia::render('Evento/EventoCalendar', [
            'titulo' => $titulo,
            'dados' => $dados,
            'filters' => $request,
        ]);
    }
    //public function pdf(Request $request)
    public function pdf($mes = 1, $area = null)
    {
        // 1) Valida os dados submetidos
        /* $request->validate([
            'direction' => ['in:asc,desc'],
            'field'     => ['in:nome,start_date'],
            'dia_mes'     => ['integer'],
            'grupo_id'     => ['array'],
            'local_id'     => ['array'],
            'area_id'     => ['array'],
        ]); */

        //dd($area);

        // 2) Instancia o modelo:
        // Se houver relacionamentos => with('roles') ou então query().
        $eventos = Evento::with(['areas', 'toGrupo', 'toLocal']);


        // 3) Aplica filtros a Query:
        // Se passado dados no campo 'search' ==> Pesquisa na coluna 'description'.
        /* $eventos->when($request->search, function ($query, $vl) {
            $query->where('nome', 'like', '%' . $vl . '%');
        });
        // Se passado dados no SelectBox 'grupo_id' ==> Pesquisa os ID's passados.
        $eventos->when($request->grupo_id, function ($query, $vl) {
            $query->whereIn('evento_grupo_id', $vl);
        });
        // Se passado dados no SelectBox 'local_id' ==> Pesquisa os ID's passados.
        $eventos->when($request->local_id, function ($query, $vl) {
            $query->whereIn('evento_local_id', $vl);
        }); */
        //dd($area);
        // Se passado dados no SelectBox 'area_id' ==> Pesquisa os ID's passados.
        $eventos->when($area, function ($query, $vl) {
            $query->whereHas('areas', function($q) use($vl){
                $q->whereIn('evento_areas.id', [$vl]);
            });
        });
        // Se passado dados no SelectBox 'dia_mes' ==> Pesquisa os ID's passados.
        /* $eventos->when($request->dia_mes, function ($query, $vl) {
            $query->fillDiaMes($vl); // ou dessa maneira => $query->whereMonth('start_date', $vl);
        }); */
        $eventos->when($mes, function ($query, $vl) {
            $query->fillDiaMes($vl); // ou dessa maneira => $query->whereMonth('start_date', $vl);
        });

        // 4) Aplica ordem a Query
        // Se acionado alguma coluna de ordenar, realiza o OrderBy.
        $eventos->orderByRaw('MONTH(start_date) asc');
        $eventos->orderByRaw('DAY(start_date) asc');
        $eventos->orderBy('start_time');

        /* $eventos->when(
            $request->field,
            function ($query, $vl) {
                $query->orderBy($vl, request()->direction);
            },
            // Ordenamento padrão: ID ascendente
            function ($query, $vl) {
                $query->orderBy('id', 'desc');
            }
        ); */

        // 5) Executa a Query montada com paginação.
        $eventos = $eventos->get();


        
        //$all_eventos = Evento::all();

        $titulo = 'Eventos';

        $pdf = Pdf::loadView('pdfs.eventos', [
            'titulo' => $titulo,
            'dados' => $eventos,
            //'filters' => $request,
        ]);
     
        //return $pdf->download('recibo.pdf');
        return $pdf->stream('Eventos.pdf');
    }
}
