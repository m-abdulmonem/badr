<?php

namespace App\Traits;
use App\Models\Permission;



/**
 *
 */
trait HasPermission
{


    public function permission()
    {
        return $this->hasOne(Permission::class);
    }

    public function canDisplay()
    {
        return $this->perm('display');
    }

    public function canCreate()
    {
        return $this->perm('create');
    }

    public function canEdit()
    {
        return $this->perm('edit');
    }
    public function canDelete()
    {
        return $this->perm('delete');
    }
    public function canUserStatus()
    {
        return $this->perm('user_status');
    }

    private function perm($property)
    {
        if ($perm = $this->permission){

            return $perm->$property == 1;
        }

        return false;
    }





}
