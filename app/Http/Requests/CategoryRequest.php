<?php
namespace Corp\Http\Requests;

use Corp\Http\Requests\Request;

class CategoryRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::user()->canDo('ADD_CATEGORIES');
       
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function getValidatorInstance()
    {
        $validator = parent::getValidatorInstance();

            $validator->sometimes('alias','unique:categories|max:255', function($input) {

                if ($this->route()->hasParameter('categories')) {
                    $model = $this->route()->parameter('categories');

                    
                    return ($model->alias !== $input->alias) && !empty($input->alias);
                }

                return !empty($input->alias);

            });

            return $validator;
    }

    public function rules()
    {
        return [
            //
        'title' => 'required|max:255',
        // 'alias' => 'required|max:255'
        ];
    }
}
