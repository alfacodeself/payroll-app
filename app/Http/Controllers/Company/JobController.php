<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Job;
use App\Models\EmployeeJob;
use App\Models\Departement;
use App\Services\FileService;
use App\Http\Requests\Company\JobRequest;
use App\Enums\Status;
use App\Enums\JobType;

class JobController extends Controller
{
    protected $fileService;

    public function __construct(FileService $fileService)
    {
        $this->middleware('company.auth');
        $this->fileService = $fileService;
    }

    public function index(Company $company)
    {
        $jobs = Job::byCompany($company->id)->paginate(10);
        return view('companies.jobs.index', [
            'company' => $company->slug,
            'jobs' => $jobs
        ]);
    }
    public function create(Company $company)
    {
        return view('companies.jobs.create', [
            'url' => route('company.jobs.store', $company->slug),
            'departements' => $company->departements
        ]);
    }
    public function store(JobRequest $request, Company $company)
    {
        try {
            $departement = Departement::where('company_id', $company->id)->where('slug', $request->departement_id)->first();
            if (!$departement) {
                return back()->withErrors(['company_id' => 'Unknown company!'])->withInput();
            }
            Job::create([
                'departement_id' => $departement->id,
                'name' => $request->name,
                'logo' => $this->processLogo($request->logo, $request->name),
                'base_salary' => $request->base_salary,
                'description' => $request->description,
                'job_type' => JobType::tryFrom($request->job_type),
                'status' => Status::ACTIVE,
            ]);
            return back()->with('success', 'New job created!');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
    public function show(Company $company, Job $job)
    {
        return view('companies.jobs.show', [
            'company' => $company->slug,
            'job' => $job,
            'employees' => EmployeeJob::where('job_id', $job->id)->with('employee')->paginate(10)
        ]);
    }
    public function edit(Company $company, Job $job)
    {
        return view('companies.jobs.edit', [
            'url' => route('company.jobs.update', [$company->slug, $job->slug]),
            'job' => $job,
        ]);
    }
    public function update(Request $request, Company $company, Job $job)
    {
        try {
            // dd(str_replace(url('storage'), 'public', $job->logo));
            $job->updateOrFail([
                'name' => $request->name,
                'logo' => $this->processLogo($request->logo, $request->name, $job->logo),
                'base_salary' => $request->base_salary,
                'description' => $request->description,
                'job_type' => JobType::tryFrom($request->job_type),
            ]);
            return redirect()->route('company.jobs.index', $company->slug)->with('success', 'Your job updated!');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
    public function destroy(Company $company, Job $job)
    {
        try {
            $status = Status::INACTIVE;
            $message = 'Success deactivated your job!';
            if ($job->status == Status::INACTIVE) {
                $status = Status::ACTIVE;
                $message = 'Success activated your job!';
            }
            $job->updateOrFail([
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
            return $this->fileService->upload($logo, $name, 'public/img/company/job/image');
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
