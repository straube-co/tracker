<?php

namespace App\Http\Requests;

use App\Point;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

/**
 *
 * @version 1.0.0
 * @author Lucas Cardoso <lucas@straube.co>
 *
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class PointRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $finished = Point::select('finished')->where('user_id', Auth::id())->orderBy('finished', 'desc')->first();

        $rules = [
            'started' => [
                'required',
                'date_format:Y-m-d H:i:s',
            ],
        ];

        if ($finished) {
            $rules['started'][] = 'after_or_equal:' . $finished->finished->format('Y-m-d H:i:s');
        }

        return $rules;
    }
}
