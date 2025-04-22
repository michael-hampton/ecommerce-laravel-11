<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAttributeRequest;
use App\Http\Requests\UpdateAttributeRequest;
use App\Http\Resources\AttributeResource;
use App\Repositories\Interfaces\IAttributeRepository;
use App\Services\Interfaces\IAttributeService;
use Illuminate\Http\Request;
use Psy\Util\Str;
use Yajra\DataTables\Facades\DataTables;

class AttributeController extends Controller
{
    public function __construct(private IAttributeService $attributeService, private IAttributeRepository $attributeRepository) {

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Http\JsonResponse|object
     * @throws \Exception
     */
    public function index(Request $request)
    {
        $attributes = $this->attributeRepository->getAll(null, 'id', 'desc');
        $collection = AttributeResource::collection($attributes)->resolve();

        if ($request->ajax()) {
            return DataTables::of($collection)->filter(function ($instance) use ($request) {
                if (!empty($request->get('search'))) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        if (\Illuminate\Support\Str::contains(Str::lower($row['name']), Str::lower($request->get('search')))) {
                            return true;
                        }
                        return false;

                    });

                };
            })->make(true);
        }

        return view('admin.attributes.index', compact('attributes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.attributes.create');
    }

    /**
     * @param StoreAttributeRequest $request
     * @return void
     */
    public function store(StoreAttributeRequest $request)
    {
        $result = $this->attributeService->createAttribute($request->all());

        return redirect()->route('admin.attributes')->with('success', 'Attribute created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $attribute = $this->attributeRepository->getById($id);
        return view('admin.attributes.edit', compact('attribute'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAttributeRequest $request, $id)
    {
        $result = $this->attributeService->updateAttribute($request->except(['_token', '_method']), $id);

        return redirect()->route('admin.attributes')->with('success', 'Attribute updated successfully.');
    }

    /**
     * @param int $id
     * @return void
     */
    public function destroy(int $id)
    {
        $result = $this->attributeService->deleteAttribute($id);

        return redirect()->route('admin.attributes')->with('success', 'Attribute deleted successfully.');
    }
}
