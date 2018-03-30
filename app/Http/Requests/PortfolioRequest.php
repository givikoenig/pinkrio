<?php
namespace Corp\Http\Requests;

use Corp\Http\Requests\Request;

class PortfolioRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::user()->canDo('ADD_PORTFOLIOS');
    }

    protected function getValidatorInstance()
    {
        $validator = parent::getValidatorInstance();

            $validator->sometimes('alias','unique:portfolios|max:255', function($input) {



                if ($this->route()->hasParameter('portfolios')) {
                    $model = $this->route()->parameter('portfolios');
                   
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
        'text' => 'required',
        'filter_id' => 'required|integer'
        ];
    }
}
