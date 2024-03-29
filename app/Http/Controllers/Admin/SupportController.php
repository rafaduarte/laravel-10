<?php

namespace App\Http\Controllers\Admin;

use App\DTO\CreateSupportDTO;
use App\DTO\UpdateSupportDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateSupport;
use App\Models\Support;
use App\Services\SupportService;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function __construct(
        protected SupportService $service
    )
    {

    }

    public function index(Request $request)
    {
        //$support = new Support(); com parâmetro não precisa aula 9 - 10m

        //$supports = $this->service->getAll($request->filter); deixou de usar na aula 25
        $supports = $this->service->paginate(
            page: $request->get('page', 1),
            totalPerPage: $request->get('per_page', 15),
            filter: $request->filter,
        );
       // dd($supports->items());

        //$supports = Support::all();
        //dd($supports);
        //return view('admin/supports/index', ['supports' => $supports]);
        //dd($supports);
        $filters = ['filter' => $request->get('filter', '')]; // aula 27
        return view('admin/supports/index', compact('supports', 'filters'));
    }
    /*
    public function index(Support $support)
    {
        //$support = new Support(); com parâmetro não precisa aula 9 - 10m
        $supports = $support->all();
        //$supports = Support::all();
        //dd($supports);
        //return view('admin/supports/index', ['supports' => $supports]);
        return view('admin/supports/index', compact('supports'));
    }
    */

    public function show(string $id)
    {
        //$support = Support::find($id);
        //dd($support);
        // Support::where('id', $id)->first();
        // Support::where('id','!=', $id)->first();
        if(!$support = $this->service->findOne($id)) {
            return redirect()->back();
        }
        return view('admin/supports/show', compact('support'));
    }

    /*
    public function show(string|int $id)
    {
        //$support = Support::find($id);
        //dd($support);
        // Support::where('id', $id)->first();
        // Support::where('id','!=', $id)->first();
        if(!$support = Support::find($id)) {
            return redirect()->back();
        }
        return view('admin/supports/show', compact('support'));
    }
    */

    public function create()
    {
        return view('admin/supports/create');
        //return redirect()->route('supports.index');
    }

    public function store(StoreUpdateSupport $request, Support $support)
    {
        //$this->service->new(new CreateSupportDTO()); sem o makeFromRequest no dto

        $this->service->new(
            CreateSupportDTO::makeFromRequest($request)
        );

        return redirect()->route('supports.index');
    }

    /*
    public function store(StoreUpdateSupport $request, Support $support)
    {
        //dd($request->all());
        //dd($request->only(['subject', 'body'])); //dd($request->body)
        //dd($request->get('xpto', 'default'));

        $data = $request->validated();
       // $data = $request->all();
        $data['status'] = 'a';
         // Support::create($data); // forma estática não precisa de parâmetros
        $support->create($data);
        //dd($support);
        return redirect()->route('supports.index');
    }
    */
    public function edit(string $id)
    {
        if(!$support = $this->service->findOne($id)) {
            return back();
        }

        return view('admin/supports.edit', compact('support'));
    }
    /*
    public function edit(Support $support, string|int $id)
    {
        if(!$support = $support->where('id', $id)->first()) {
            return back();
        }

        return view('admin/supports.edit', compact('support'));
    }
    */
    public function update(StoreUpdateSupport $request, Support $support, string $id)
    {

       $support = $this->service->update(
            UpdateSupportDTO::makeFromRequest($request)
        );

        if(!$support) {
            return redirect()->back();
        }

        return redirect()->route('supports.index');
    }


  /*
    public function update(StoreUpdateSupport $request, Support $support, string $id)
    {
        if(!$support = Support::find($id)) {
            return redirect()->back();
        }

        $support->update($request->Validated());
        /*
        $support->update($request->only([
            'subject', 'body'
        ]));
        /*

        return redirect()->route('supports.index');
    }
    */

    public function destroy(string $id)
    {
        $this->service->delete($id);

        return redirect()->route('supports.index');
    }

    /*
    public function destroy(string|int $id)
    {
        if(!$support = Support::find($id))
        {
            return back();
        }
        $support->delete();

        return redirect()->route('supports.index');

    }
    */
}
