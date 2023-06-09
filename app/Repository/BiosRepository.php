<?php

namespace App\Repository;

use App\Models\Bio;
use Illuminate\Support\Facades\Auth;

class BiosRepository extends Repository
{
    public function __construct(Bio $model)
    {
        $this->model = $model;
    }

    public function updateUserBioById($data, $id) 
    {
        $this->findUserBio($id)->update($data);
    }

    public function deleteUserBioById($id)
    {
        $this->findUserBio($id)->delete();
    }

    public function findUserBio($id)
    {
        return $this->getUserBioEloquent()->findOrFail($id);
    }

    public function createUserBio($data) 
    {
        return $this->getUserBioEloquent()->create($data);
    }
    
    public function getUserBio() 
    {
        return $this->getUserBioEloquent()->get();
    }

    private function getUserBioEloquent()
    {
        $user = Auth::user();
        return $user->bios();
    }

    public function getModel()
    {
        return $this->model;
    }
}