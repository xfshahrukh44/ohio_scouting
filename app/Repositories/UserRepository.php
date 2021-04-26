<?php

namespace App\Repositories;

use App\Exceptions\User\AllUserException;
use App\Exceptions\User\CreateUserException;
use App\Exceptions\User\UpdateUserException;
use App\Exceptions\User\DeleteUserException;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Hash;
// use JWTAuth;
// use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

abstract class UserRepository implements RepositoryInterface
{
    private $model;
    
    public function __construct(User $user)
    {
        $this->model = $user;
    }
    
    public function create(array $data)
    {
        try {
            // password hashing
            if($data['password'])
            {
                $data['password'] = Hash::make($data['password']);
            }

            $user = $this->model->create($data);

            // $token = JWTAuth::fromUser($user);
            return response()->json([
                'user' => $user,
                'token' => $token
            ]);
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
                return response()->json([
                    'success' => false,
                    'message' => 'Could`nt find user',
                ]);
            }

            $user = ($this->find($id))['user'];
            $user->save();

            $this->model->destroy($id);
            return response()->json([
                'success' => true,
                'message' => 'Deleted successfully',
                'deletedUser' => $temp,
            ]);
        }
        catch (\Exception $exception) {
            throw new DeleteUserException($exception->getMessage());
        }
    }
    
    public function update(array $data, $id)
    {
        try {
            // dd($data);
            // password hashing
            if(isset($data['password']))
            {
                $data['password'] = Hash::make($data['password']);
            }
            
            if(!$temp = $this->model->find($id))
            {
                return response()->json([
                    'success' => false,
                    'message' => 'Could`nt find user',
                ]);
            }

            $temp->update($data);
            $temp->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Updated successfully!',
                'updated_user' => $temp,
            ]);
        }
        catch (\Exception $exception) {
            throw new UpdateUserException($exception->getMessage());
        }
    }
    
    public function find($id)
    {
        try {
            // return $this->model::findOrFail($id);
            $user = $this->model::find($id);
            if(!$user)
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find user',
                ];
            }
            return [
                'success' => true,
                'user' => $user,
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
            throw new AllUserException($exception->getMessage());
        }
    }

    public function paginate($pagination)
    {
        try {
            return $this->model->orderBy('type', 'ASC')->paginate($pagination);
        }
        catch (\Exception $exception) {
            throw new AllUserException($exception->getMessage());
        }
    }

    public function paginate_realtors($pagination)
    {
        try {
            return $this->model->where('type', 'Realtor')->paginate($pagination);
        }
        catch (\Exception $exception) {
            throw new AllUserException($exception->getMessage());
        }
    }

    public function paginate_cleaners($pagination)
    {
        try {
            return $this->model->where('type', 'Cleaner')->paginate($pagination);
        }
        catch (\Exception $exception) {
            throw new AllUserException($exception->getMessage());
        }
    }

    public function paginate_staff($pagination)
    {
        try {
            return $this->model::where('type', '!=', 'rider')->orderBy('created_at', 'DESC')->paginate($pagination);
        }
        catch (\Exception $exception) {
            throw new AllUserException($exception->getMessage());
        }
    }

    public function paginate_riders($pagination)
    {
        try {
            return $this->model::where('type', '=', 'rider')->orderBy('created_at', 'DESC')->paginate($pagination);
        }
        catch (\Exception $exception) {
            throw new AllUserException($exception->getMessage());
        }
    }

    public function all_staff()
    {
        try {
            return $this->model::where('type', '!=', 'rider')->get();
        }
        catch (\Exception $exception) {
            throw new AllUserException($exception->getMessage());
        }
    }

    public function all_riders()
    {
        try {
            return $this->model::where('type', '=', 'rider')->get();
        }
        catch (\Exception $exception) {
            throw new AllUserException($exception->getMessage());
        }
    }

    public function search_users($query)
    {
        $users = User::where(function($q) use($query){
                            $q->orWhere('name', 'LIKE', '%'.$query.'%');
                            $q->orWhere('email', 'LIKE', '%'.$query.'%');
                            $q->orWhere('type', 'LIKE', '%'.$query.'%');
                        })
                        ->paginate(env('PAGINATION'));

        return $users;
    }
}