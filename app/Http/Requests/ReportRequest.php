<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

/**
 * Report request.
 *
 * @version 2.0.0
 * @author  Gustavo Straube <gustavo@straube.co>
 */
class ReportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'max:100',
            ],
            'filter' => [
                'required',
                'array',
                'min:1',
            ],
            'filter.started' => [
                'nullable',
                'string',
                'date_format:Y-m-d',
            ],
            'filter.finished' => [
                'nullable',
                'string',
                'date_format:Y-m-d',
                'after:filter.started',
            ],
            'filter.user_id' => [
                'nullable',
                'integer',
                'exists:users,id',
            ],
            'filter.project_id' => [
                'nullable',
                'integer',
                'exists:projects,id',
            ],
            'filter.activity_id' => [
                'nullable',
                'integer',
                'exists:activities,id',
            ],
        ];
    }

    /**
     * Get the validated data from the request.
     *
     * @return array
     */
    public function validated()
    {
        $data = parent::validated();
        $data['code'] = Str::random(20);

        return $data;
    }
}
