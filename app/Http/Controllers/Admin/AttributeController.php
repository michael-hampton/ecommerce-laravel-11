<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAttributeRequest;
use App\Models\ProductAttribute;

class AttributeController extends Controller
{
    public function index()
    {
        $pattributes = ProductAttribute::paginate(10);
        return view('admin.attributes.attributes',['pattributes'=>$pattributes]);
    }

    public function create()
    {
        return view('admin.attributes.create');
    }

    public function store(CreateAttributeRequest $request)
    {
        $pattribute = new ProductAttribute();
        $pattribute->name = $request->input('name');
        $pattribute->save();
        return back()->with('message', 'Attribute added successfully');
    }

    public function destroy($id)
    {
        $pattribute = ProductAttribute::find($id);
        $pattribute->delete();
        return back()->with('message', 'Attribute added successfully');
    }

    public function show($id)
    {

    }

    public function edit($id)
    {

    }
}
