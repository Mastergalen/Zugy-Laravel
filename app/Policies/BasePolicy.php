<?php

namespace App\Policies;

use App\User;

class BasePolicy
{
    private $superAdminGroupId = 1;
    private $adminGroupId = 2;
    private $driverGroupId = 3;

    private $adminGroups;

    public function __construct()
    {
        $this->adminGroups = [$this->superAdminGroupId, $this->adminGroupId, $this->driverGroupId];
    }

    protected function isSuperAdmin(User $user)
    {
        return $user->group_id === $this->superAdminGroupId;
    }

    protected function isAdmin(User $user)
    {
        return in_array($user->group_id, $this->adminGroups);
    }

    protected function hasWriteAccess(User $user)
    {
        return in_array($user->group_id, [
            $this->superAdminGroupId,
            $this->adminGroupId
        ]);
    }
}