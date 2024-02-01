<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Departement;
use App\Services\FileService;
use App\Http\Requests\Company\DepartementRequest;
use App\Enums\Status;

class DepartementController extends Controller
{
    protected $fileService;

    public function __construct(FileService $fileService)
    {
        $this->middleware('company.auth');
        $this->fileService = $fileService;
    }

    public function index(Company $company)
    {
        $departements = Departement::where('company_id', $company->id)
            ->select('logo', 'name', 'status', 'slug')
            ->paginate(10);
        return view('companies.departements.index', [
            'company' => $company->slug,
            'departements' => $departements
        ]);
    }
    public function create(Company $company)
    {
        return view('companies.departements.create', [
            'url' => route('company.departements.store', $company->slug)
        ]);
    }
    public function store(DepartementRequest $request, Company $company)
    {
        try {
            Departement::create([
                'name' => $request->name,
                'logo' => $this->processLogo($request->logo, $request->name),
                'status' => Status::ACTIVE,
                'company_id' => $company->id
            ]);
            return back()->with('success', 'New departement created!');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
    public function show(Company $company, Departement $departement)
    {
        return view('companies.departements.show', [
            'company' => $company->slug,
            'departement' => $departement,
            'jobs' => $departement->jobs
        ]);
    }
    public function edit(Company $company, Departement $departement)
    {
        return view('companies.departements.edit', [
            'url' => route('company.departements.update', [$company->slug, $departement->slug]),
            'name' => $departement->name,
        ]);
    }
    public function update(DepartementRequest $request, Company $company, Departement $departement)
    {
        try {
            // dd(str_replace(url('storage'), 'public', $departement->logo));
            $departement->updateOrFail([
                'name' => $request->name,
                'logo' => $this->processLogo($request->logo, $request->name, $departement->logo)
            ]);
            return back()->with('success', 'Your departement updated!');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
    public function destroy(Company $company, Departement $departement)
    {
        try {
            $status = Status::INACTIVE;
            $message = 'Success deactivated your departement!';
            if ($departement->status == Status::INACTIVE) {
                $status = Status::ACTIVE;
                $message = 'Success activated your departement!';
            }
            $departement->updateOrFail([
                'status' => $status,
            ]);
            return back()->with('success', $message);
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    protected function processLogo($logo, $name, $oldLogo = null)
    {
        // Kalau ada request logo
        if ($logo && $logo != null) {
            // Jika sudah ada logo sebelumnya
            if ($oldLogo != null) {
                // Maka hapus logo
                $this->fileService->remove($oldLogo);
            }
            // Upload logo
            return $this->fileService->upload($logo, $name, 'public/img/company/departement/');
        }
        // Kalau sebelumnya ada logo dan tidak ada request logo
        elseif ($oldLogo != null) {
            return $oldLogo;
        }
        else {
            return null;
        }
    }

}
