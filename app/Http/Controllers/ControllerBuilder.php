<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MyUtility as MyUt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ControllerBuilder
{
    public $view_folder;

    private $route;

    private $model;

    private $created_by;

    public function __construct($view_folder, $route, $model, $created_by = 1)
    {
        $this->view_folder = $view_folder;
        $this->route = $route;
        $this->model = $model;
    }

    public function index($result = null, $data = null, $view = null)
    {
        $results = $result == null ? $this->model::paginate(20) : $result;
        $data = [
            'results' => $results,
            'data' => $data,
        ];
        if ($view == null) {
            return view($this->view_folder.'.index')->with($data);
        } else {
            return view($view)->with($data);
        }
    }

    public function create($data = null)
    {
        return view($this->view_folder.'.create')->with($data);
    }

    public function checkIfExist($request, $column)
    {
        $where = [];
        $rst = new $this->model;
        foreach ($column as $value) {
            if (is_array($request[$value])) {
                $rst = $rst->where($value, $request[$value][0], $request[$value][1]);
            } else {
                $rst = $rst->where($value, $request[$value]);
            }
        }

        return $rst->orWhere($where)->first();
    }

    public function store($request, $except = null, $redirect = true, $files_field = null, $created_by = 1)
    {
        try {
            $except = $except == null ? '_token' : $except;
            $data = $request->except($except);

            if ($files_field != null) {
                if (! empty($request[$files_field])) {
                    $files_value = MyUt::laravelUploadImg($request, $files_field, 'uploading/files', false);
                    $data[$files_field] = $files_value;
                }
            }

            $data['created_by'] = Auth::user()->id ? Auth::user()->id : $created_by;
            if ($request->password) {
                $data['password'] = Hash::make($request->password);
            }

            $result = new $this->model($data);
            if ($result->save()) {
                if ($redirect) {
                    if ($redirect === true) {
                        return redirect(route($this->route.'.index'));
                    } else {
                        return redirect($redirect);
                    }
                } else {
                    return $result;
                }
            } else {
                return 'update data fails';
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withInput()->withErrors([$e->errorInfo]);
        }
    }

    public function show($model)
    {
        $data = [
            'results' => $model,
        ];

        return view($this->view_folder.'.show')->with($data);

    }

    public function getDataStore($id, $valueId, $arrayDataFill, $key)
    {

        $data = [];
        if ($arrayDataFill) {
            foreach ($arrayDataFill as $aKey => $aValue) {
                if ($aValue) {
                    $db = [[$id => $valueId, $key => $aValue]];
                    $data = array_merge($data, $db);
                }
            }
        }

        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\QuestionType  $question_type
     * @return \Illuminate\Http\Response
     */
    public function edit($model, $resl = null)
    {
        $data = $resl ? [
            'result' => $model,
        ] + $resl : [
            'result' => $model,
        ];

        return view($this->view_folder.'.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateQuestionTypeRequest  $request
     * @param  \App\Models\QuestionType  $question_type
     * @return \Illuminate\Http\Response
     */
    public function update($request, $model, $except = null, $redirect = true, $files_field = null, $created_by = 1)
    {
        try {

            $except = $except == null ? '_token' : $except;
            $data = $request->except($except);

            if ($files_field != null) {
                if (! empty($request[$files_field])) {
                    $files_value = MyUt::laravelUploadImg($request, $files_field, 'uploading/files', false);
                    $data[$files_field] = $files_value;
                }
            }

            $data['created_by'] = $created_by;
            if ($request->password) {
                $data['password'] = Hash::make($request->password);
            }
            $model->fill($data);

            if ($model->save()) {

                if ($redirect) {
                    if ($redirect === true) {
                        if ($request->page) {
                            return redirect(route($this->route.'.index', ['page' => $request->page]));
                        } else {
                            return redirect(route($this->route.'.index'));
                        }
                    } else {
                        return redirect($redirect);
                    }
                } else {
                    return $model;
                }
            } else {
                return 'update data fails';
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withInput()->withErrors([$e->errorInfo]);
        }
    }

    public function destroy($model, $redirect = null)
    {
        $result = $model->delete();
        if ($result) {
            if ($redirect != null) {
                return redirect($redirect);
            } else {
                return redirect(route($this->route.'.index'));
            }
        } else {
            return 'Destroy to table false.';
        }
    }
}
