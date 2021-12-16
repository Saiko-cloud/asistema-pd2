<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Lesson;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    public function newLesson( Request $request ){
        $lesson = new Lesson;
        $lesson->name = $request->name;
        $lesson->save();
    }
    public function newUser( Request $request ){
        $fullname = $request->name;
        $name = explode(" ", $fullname);
        return User::create([
            'name' => $name[0],
            'surname' => $name[1],
            'role' => $request->role,
            'email' => $name[0].$name[1].'@asistema.lt',
            'password' => Hash::make($name[1]),
        ]);
    }

    public function getAdminData(Request $request)
    {
        if($request->type == "users")
        {
            return User::all();
        }
        else if($request->type == "lessons")
        {
            return Lesson::all();
        }
        
    }

    public function changeData(Request $request)
    {
        if($request->dataType == 'users')
        {
            $user = User::findOrFail($request->id);
            $type = $request->type;

            if( $type == 'group')
            {
                if($user->role == 'student')
                {
                    $user->lessons()->detach();

                    $lessons = Lesson::where('group',$request->data)->get();

                    foreach ($lessons as $l) 
                    {
                        $user->lessons()->attach($l->id);
                    }
                }

            }
            $user->$type = $request->data;
            $user->save();

        }
        else if($request->dataType == 'lessons')
        {
            $lesson = Lesson::findOrFail($request->id);
            $type = $request->type;
            $lesson->$type = $request->data;
            $lesson->save();

            if( $type == 'group')
            {
                $lesson->users()->detach();
                
                $users = User::where('group',$request->data)->get();

                foreach ($users as $u) 
                {
                    if($u->role == 'student')
                    {
                        $lesson->users()->attach($u->id);
                    }
                }
                

            }
        }
        
    }

    public function deleteData(Request $request)
    {
        if($request->dataType == 'users')
        {
            $user = User::findOrFail($request->id);
            $user->delete();
        }
        else if($request->dataType == 'lessons')
        {
            $lesson = Lesson::findOrFail($request->id);
            $lesson->delete();
        }

    }

    public function getStudents(Request $request)
    {
        $teacher = Auth::user();
        if($teacher->role == 'teacher')
        {
            $students = array();

            $lessons = Lesson::where('name', $teacher->group)->get();
            foreach($lessons as $lesson)
            {
                $coll = Lesson::findOrFail($lesson->id)->users;

                foreach($coll as $c)
                {
                    array_push($students,$c);
                    
                }
            }

            return $students; 
        }

    }

    public function changeNote(Request $request)
    {
        $student = User::findOrFail($request->studentID);

        $note = $student->lessons->find($request->lessonID);
        $note->pivot->note = $request->note;
        $note->pivot->save();

    }

    public function getNotes()
    {
        $student = User::findOrFail(Auth::user()->id);

        return $student->lessons;
    }

}
