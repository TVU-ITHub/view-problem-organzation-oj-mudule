<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organization;

class OrganizationController extends Controller
{
    public function show(Request $request, $organizationSlug)
    {
        // try {
            //code...
            $organization = Organization::where('slug', $organizationSlug)->firstOrFail();
            $title = $organization->name;
            
            $problems = $organization->problems()->orderBy('id', 'desc')->get();

            $problemSlug = $request->query('problem');

            $isStaff = false;
            $users = $organization->profiles()
                                ->join('auth_user', 'judge_profile.user_id', '=', 'auth_user.id')
                                ->where('auth_user.is_staff', $isStaff)
                                ->where('judge_profile.is_unlisted', false)
                                ->get();

            // dd($users->toArray());
            return view('organization.show', [
                'organization' => $organization->toArray(),
                'problems' => $problems->toArray(),
                'users' => $users->toArray(),
                'title' => $title,
                'problemSlug' => $problemSlug
            ]);

            // return view('organization.show', compact('organization'));
        // } catch (\Throwable $th) {
        //     //throw $th;
        // }
    }
}
