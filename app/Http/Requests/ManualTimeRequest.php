<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

/**
 *
 * @version 1.0.0
 * @author Lucas Cardoso <lucas@straube.co>
 *
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class ManualTimeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'project_id' => [
                'required',
            ],
            'task_id' => [
                'required',
                'exists:tasks,id',
            ],
            'activity_id' => [
                'required',
            ],
            'started' => [
                'required',
                'date_format:Y-m-d H:i:s',
            ],
            'finished' => [
                'required',
                'date_format:Y-m-d H:i:s',
                'after_or_equal:started',
                'before:' . Carbon::now()->format('Y-m-d H:i:s'),
            ],

        ];

        return $rules;
    }
}
