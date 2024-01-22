<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{Company, Departement, Job, Employee, EmployeeJob};
use App\Enums\{Status, JobType};

class DummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // First Dummy Company
        $firstCompany = Company::create([
            'name' => 'Delisa Company',
            'username' => 'delisa@payroll.app',
            'password' => bcrypt('password'),
            'phone' => '083918293333',
            'status' => Status::ACTIVE
        ]);
        $firstDepartement = Departement::create([
            'company_id' => $firstCompany->id,
            'name' => 'Warung Sayur Delisa',
            'status' => Status::ACTIVE
        ]);
        $secondDepartement = Departement::create([
            'company_id' => $firstCompany->id,
            'name' => 'Peternakan',
            'status' => Status::ACTIVE
        ]);
        $firstJob = Job::create([
            'departement_id' => $firstDepartement->id,
            'name' => 'Kasir',
            'base_salary' => 35000,
            'job_type' => JobType::DAILY,
            'status' => Status::ACTIVE
        ]);
        $seondJob = Job::create([
            'departement_id' => $firstDepartement->id,
            'name' => 'Distributor',
            'base_salary' => 200000,
            'job_type' => JobType::PIECEWORK,
            'status' => Status::ACTIVE
        ]);
        $thirdJob = Job::create([
            'departement_id' => $secondDepartement->id,
            'name' => 'Ternak Ayam',
            'base_salary' => 3500,
            'job_type' => JobType::PIECEWORK,
            'status' => Status::ACTIVE
        ]);
        $fourthJob = Job::create([
            'departement_id' => $secondDepartement->id,
            'name' => 'Potong Ayam',
            'base_salary' => 2000,
            'job_type' => JobType::PIECEWORK,
            'status' => Status::ACTIVE
        ]);

        // Second Dummy Company
        $secondCompany = Company::create([
            'name' => 'Second Company Example',
            'username' => 'secondcompany@payroll.app',
            'password' => bcrypt('password'),
            'phone' => '083918294444',
            'status' => Status::ACTIVE
        ]);
        $thirdDepartement = Departement::create([
            'company_id' => $secondCompany->id,
            'name' => 'Departement Second Company',
            'status' => Status::ACTIVE
        ]);
        $fifthJob = Job::create([
            'departement_id' => $thirdDepartement->id,
            'name' => 'Job Second Company',
            'base_salary' => 300,
            'job_type' => JobType::PIECEWORK,
            'status' => Status::ACTIVE
        ]);

        // Employee
        $employee = Employee::create([
            'name' => 'Pegawai 1',
            'phone' => '083918291111',
            'password' => bcrypt('password'),
            'status' => Status::ACCEPTED,
        ]);
        EmployeeJob::create([
            'employee_id' => $employee->id,
            'job_id' => $firstJob->id,
            'status' => Status::ACTIVE,
        ]);
    }
}
