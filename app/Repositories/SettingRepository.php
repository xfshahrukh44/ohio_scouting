<?php

namespace App\Repositories;

use App\Exceptions\Setting\AllSettingException;
use App\Exceptions\Setting\CreateSettingException;
use App\Exceptions\Setting\UpdateSettingException;
use App\Exceptions\Setting\DeleteSettingException;
use App\Models\Setting;

abstract class SettingRepository implements RepositoryInterface
{
    private $model;
    
    public function __construct(Setting $setting)
    {
        $this->model = $setting;
    }
    
    public function create(array $data)
    {
        try 
        {    
            $setting = $this->model->create($data);
            
            return [
                'setting' => $this->find($setting->id)
            ];
        }
        catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }
    
    public function delete($id)
    {
        try {
            if(!$temp = $this->model->find($id))
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find setting',
                ];
            }

            $this->model->destroy($id);

            return [
                'success' => true,
                'message' => 'Deleted successfully',
                'setting' => $temp,
            ];
        }
        catch (\Exception $exception) {
            throw new DeleteSettingException($exception->getMessage());
        }
    }
    
    public function update(array $data, $id)
    {
        try {
            if(!$temp = $this->model->find($id))
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find setting',
                ];
            }

            $temp->update($data);
            $temp->save();
            
            return [
                'success' => true,
                'message' => 'Updated successfully!',
                'setting' => $this->find($temp->id),
            ];
        }
        catch (\Exception $exception) {
            throw new UpdateSettingException($exception->getMessage());
        }
    }
    
    public function find($id)
    {
        try 
        {
            $setting = $this->model::find($id);
            if(!$setting)
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find setting',
                ];
            }
            return [
                'success' => true,
                'setting' => $setting,
            ];
        }
        catch (\Exception $exception) {

        }
    }
    
    public function all()
    {
        try {
            return $this->model::all();
        }
        catch (\Exception $exception) {
            throw new AllSettingException($exception->getMessage());
        }
    }

    public function paginate($pagination)
    {
        try {
            return $this->model::orderBy('created_at', 'DESC')->paginate($pagination);
        }
        catch (\Exception $exception) {
            throw new AllSettingException($exception->getMessage());
        }
    }
}