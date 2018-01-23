<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Este es el primero que se ejecuta , y sirve para determinar si un usuario
        // esta autorizado para ejecutar esta acción.
        // Si esto vuelve falso la peticion termina inmediatamente.
        // Para nuestro ejemplo forzaremos a que nos devulva verdadero, para que pase y vaya hacia las reglas.
        // return false;
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // Aqui retornamos un array con las reglas de validación
        // validacion
        // validate se encuentra de la clase controller a la cual accedemos
        // de la siguiente manera
        return [
            'title'     => 'required',
            'body'      => 'required',
            'category_id'  => 'required',
            'excerpt'  => 'required',
            'tags'  => 'required'
        ];
    }
}
