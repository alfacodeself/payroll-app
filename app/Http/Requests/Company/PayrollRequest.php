<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\PayrollType;

class PayrollRequest extends FormRequest
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
            'employee' => 'required',
            'description' => 'required',
            'proof' => 'nullable|image|max:4096',
            'paid_at' => 'required',
            'attendance_employee_id' => 'required|array',

            'additional' => 'nullable|array|size:4',
            'additional.note' => 'required_with:additional|array',
            'additional.note.*' => 'required_with:additional|string',
            'additional.qty' => 'required_with:additional|array',
            'additional.qty.*' => 'required_with:additional|numeric|min:1',
            'additional.base_price' => 'required_with:additional|array',
            'additional.base_price.*' => 'required_with:additional|numeric|min:0',
            'additional.payroll_type' => 'required_with:additional|array',
            'additional.payroll_type.*' => 'required_with:additional|in:additional,deduction',

            // Format additional request
            // "additional" => array:4 [
            //     "note" => [
            //         0 => "Fee"
            //         1 => "Tax"
            //     ],
            //     "qty" => [
            //         0 => "4"
            //         1 => "1"
            //     ],
            //     "base_price" => [
            //         0 => "4000"
            //         1 => "15000"
            //     ],
            //     "payroll_type" => [
            //         0 => "additional"
            //         1 => "deduction"
            //     ]
            // ];
        ];
    }
}
