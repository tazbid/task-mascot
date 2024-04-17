<?php

namespace App\Traits;

trait UserTrait {
    //superadmin seeding information
    private $superadminSeedEmail     = "superadmin@office.com";
    private $superadminSeedFirstName = "Superadmin";
    private $superadminSeedLastName  = "Superadmin";
    private $superadminSeedFullName  = "Superadmin";

    //admin seeding information
    private $adminSeedEmail     = "admin@localhost.local";
    private $adminSeedFirstName = "Admin";
    private $adminSeedLastName  = "Admin";
    private $adminSeedFullName  = "Admin";

    //user status boolean
    private $userActive   = 1;
    private $userDeactive = 0;

    //roles
    private $superAdminRole = 'super-admin';
    private $adminRole      = 'admin';
    private $userRole       = 'user';

    //user image collection
    private $userProfileImageCollection = 'user-profile';

    //user id verification image collection
    private $userIdVerificationImageCollection = 'user-id-verification';

    //user file collection
    private $userfileCollection = 'user-files';


}
