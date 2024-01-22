<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\JobType;

class JobRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'logo' => 'nullable|image|max:4096',
            'name' => 'required',
            'departement_id' => 'required',
            'description' => 'required',
            'base_salary' => 'required|integer',
            'job_type' => ['required', Rule::in([JobType::DAILY->value, JobType::PIECEWORK->value])],
        ];
    }
}
