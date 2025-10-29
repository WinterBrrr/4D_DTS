<?php

namespace App\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
use App\Models\User;
use App\Models\UserProfile;

class UserComposer
{
    protected static $cachedUser = null;
    protected static $cachedProfile = null;
    
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $userEmail = Session::get('user_email');
        
        if ($userEmail) {
            // Use static property to cache user data across view renders in same request
            if (self::$cachedUser === null) {
                self::$cachedUser = User::where('email', $userEmail)->first();
                
                if (self::$cachedUser) {
                    self::$cachedProfile = UserProfile::where('user_id', self::$cachedUser->id)->first();
                }
            }
            
            $photoPath = session('profile_photo_path') ?: (self::$cachedProfile?->profile_photo_path);
            
            $view->with([
                'currentUser' => self::$cachedUser,
                'currentProfile' => self::$cachedProfile,
                'currentUserPhoto' => $photoPath,
            ]);
        }
    }
}
