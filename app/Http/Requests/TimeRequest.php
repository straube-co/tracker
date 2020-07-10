<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Time request.
 *
 * @version 2.0.0
 * @author  Gustavo Straube <gustavo@straube.co>
 */
class TimeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->time) {
            return $this->time->user_id === $this->user()->id;
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $edit = $this->time !== null;

        return [
            'project_id' => [
                'required',
                'integer',
                'exists:projects,id',
            ],
            'activity_id' => [
                'required',
                'integer',
                'exists:activities,id',
            ],
            'description' => [
                'required',
                'string',
                'max:255',
            ],
            'previous' => [
                'nullable',
                'boolean',
            ],
            'date' => [
                $edit ? 'required' : 'required_if:previous,true',
                'string',
                'date_format:Y-m-d',
            ],
            'started' => [
                $edit ? 'required' : 'required_if:previous,true',
                'string',
                'date_format:H:i',
            ],
            'finished' => [
                $edit ? 'required' : 'required_if:previous,true',
                'string',
                'date_format:H:i',
                'after:started',
            ],
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator $validator
     * @return void
     */
    public function withValidator($validator)
    {
        if ($this->time) {
            return;
        }

        $validator->after(function ($validator) {
            if (!$this->previous && $this->user()->hasTimerRunning()) {
                $validator->errors()->add('error', 'It seems you already have a timer running.');
            }
        });
    }

    /**
     * Get the validated data from the request.
     *
     * @return array
     */
    public function validated()
    {
        $user = $this->user();
        $data = parent::validated();

        if (!$this->time) {
            $data['user_id'] = $user->id;
        }

        // Convert started/finished into date with time
        if (empty($data['started'])) {
            $data['started'] = Carbon::now();
        } else {
            $timezone = $user->timezone;
            $data['started'] = Carbon::createFromFormat('Y-m-d H:i', $data['date'] . ' ' . $data['started'], $timezone)->tz('UTC');
            $data['finished'] = Carbon::createFromFormat('Y-m-d H:i', $data['date'] . ' ' . $data['finished'], $timezone)->tz('UTC');
        }
        unset($data['date']);

        return $data;
    }
}
