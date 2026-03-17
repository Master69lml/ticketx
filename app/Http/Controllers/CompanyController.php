<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Log::info('📋 Listando empresas');
        $companies = Company::paginate(10);
        return view('admin.companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Log::info('📝 Abriendo formulario para crear empresa');
        return view('admin.companies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            Log::info('💾 Iniciando creación de empresa');
            
            $this->validate($request, [
                'name' => 'required|unique:companies',
            ]);

            Log::info('✅ Validación pasada para nueva empresa');

            $company = Company::create([
                'name'   => $request->input('name'),
                'active' => $request->has('active') ? true : false,
            ]);

            Log::info('✅ Empresa creada exitosamente: ' . $company->name . ' (ID: ' . $company->id . ')');

            return redirect()->route('companies.index')->with('success', 'Empresa creada exitosamente: ' . $company->name);
        } catch (\Exception $e) {
            Log::error('❌ Error al crear empresa: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al crear la empresa: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     $company = Company::findOrFail($id);
    //     return view('admin.companies.show', compact('company'));
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Log::info('📝 Abriendo formulario para editar empresa ID: ' . $id);
        $company = Company::findOrFail($id);
        return view('admin.companies.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            Log::info('🔄 Actualizando empresa ID: ' . $id);
            Log::info('Datos recibidos: ' . json_encode($request->all()));
            
            $company = Company::findOrFail($id);
            Log::info('Empresa encontrada: ' . $company->name);

            $validator = \Validator::make($request->all(), [
                'name' => 'required|unique:companies,name,' . $company->id,
            ]);

            if ($validator->fails()) {
                Log::error('Validación fallida: ' . json_encode($validator->errors()->all()));
                return redirect()->back()->withErrors($validator)->withInput();
            }

            Log::info('✅ Validación pasada');
            
            $updateData = [
                'name'   => $request->input('name'),
                'active' => $request->has('active') ? true : false,
            ];
            
            Log::info('Actualizando con: ' . json_encode($updateData));

            $result = $company->update($updateData);

            Log::info('Resultado de update: ' . ($result ? 'true' : 'false'));
            Log::info('Empresa después de actualizar: ' . json_encode($company->fresh()->toArray()));

            return redirect()->route('companies.index')->with('success', 'Empresa actualizada exitosamente: ' . $company->name);
        } catch (\Exception $e) {
            Log::error('❌ Error al actualizar empresa: ' . $e->getMessage());
            Log::error('Stack: ' . $e->getTraceAsString());
            return redirect()->back()->with('error', 'Error al actualizar la empresa: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Log::info('🗑️ Eliminando empresa ID: ' . $id);
            
            $company = Company::findOrFail($id);
            $companyName = $company->name;
            
            $company->delete();

            Log::info('✅ Empresa eliminada: ' . $companyName);

            return redirect()->route('companies.index')->with('success', 'Empresa eliminada exitosamente: ' . $companyName);
        } catch (\Exception $e) {
            Log::error('❌ Error al eliminar empresa: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al eliminar la empresa: ' . $e->getMessage());
        }
    }
}
