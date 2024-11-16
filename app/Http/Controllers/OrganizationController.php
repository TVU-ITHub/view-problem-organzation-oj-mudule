<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organization;
use App\Models\Submission;


class OrganizationController extends Controller
{
    public function show(Request $request, $organizationSlug)
    {
        // try {
            //code...
            $organization = Organization::where('slug', $organizationSlug)->firstOrFail();
            $title = $organization->name;
            
            $problemSlug = $request->query('problem');
            // dd($problemSlug);
            $problems = $organization->problems()->orderBy('id', 'desc')->get();

            $problemIds = $problems->when(isset($problemSlug), function ($query) use ($problemSlug) {
                return $query->where('code', $problemSlug);
            })->pluck('id')->toArray();


            $isStaff = false;
            $users = $organization->profiles()
                                ->join('auth_user', 'judge_profile.user_id', '=', 'auth_user.id')
                                ->where('auth_user.is_staff', $isStaff)
                                ->where('judge_profile.is_unlisted', false)
                                ->get();
            $userIds = $users->pluck('user_id')->toArray();

            // dd($userIds);

            $submissions = Submission::whereIn('problem_id', $problemIds)
                                    ->whereIn('user_id', $userIds)
                                    ->orderBy('id', 'desc')
                                    ->get();

            // dd($users->toArray());

            // dd($users);
            // dd($submissions->where('user_id', 12)->where('result', 'AC')->groupBy('problem_id')->toArray());

            $users = $users->toArray();

            foreach ($users as $key => $user) {
                $users[$key]['total_submissions'] = count($submissions->where('user_id', $user['user_id']));
                $users[$key]['total_problems'] = count($submissions->where('user_id', $user['user_id'])->groupBy('problem_id'));
                $users[$key]['total_ac'] = count($submissions->where('user_id', $user['user_id'])->where('result', 'AC')->groupBy('problem_id'));
                if ($users[$key]['total_ac'] == 0 && $users[$key]['total_submissions'] == 0) {
                    $users[$key]['total_ac'] = -1;
                }
            }
            // dd($users);
            // usort($users, function ($a, $b) {
            //     return $a['total_ac'] <=> $b['total_submissions'];
            // });

            usort($users, function ($a, $b) {
                if ($a['total_ac'] == $b['total_ac']) {
                    return $a['total_submissions'] <=> $b['total_submissions'];
                }
                return $b['total_ac'] <=> $a['total_ac'];
            });
            // dd($users);
            
            // dd($users->toArray());
            return view('organization.show', [
                'organization' => $organization->toArray(),
                'problems' => $problems->toArray(),
                'users' => $users,
                'title' => $title,
                'problemSlug' => $problemSlug
            ]);

            // return view('organization.show', compact('organization'));
        // } catch (\Throwable $th) {
        //     //throw $th;
        // }
    }
}
