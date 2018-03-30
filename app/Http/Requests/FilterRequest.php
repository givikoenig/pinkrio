<?php

namespace Corp\Http\Requests;

use Corp\Http\Requests\Request;

class FilterRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::user()->canDo('ADD_FILTERS');
    }

    protected function getValidatorInstance()
    {
        $validator = parent::getValidatorInstance();

            $validator->sometimes('alias','unique:filters|max:255', function($input) {

                if ($this->route()->hasParameter('filters')) {
                    $model = $this->route()->parameter('filters');

                    return ($model->alias !== $input->alias) && !empty($input->alias);
                }

                return !empty($input->alias);

            });

            return $validator;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        'title' => 'required|max:255',
        ];
    }
}
