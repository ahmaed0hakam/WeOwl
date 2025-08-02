<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\ClassRoom;
use App\Models\Notification;
use App\Models\Grade;
use App\Models\Attendance;

class TeacherController extends Controller
{
    public function dashboard()
    {
        $teacherId = session('teacher_id');
        $teacher = Teacher::find($teacherId);
        
        // Get teacher's classes
        $classes = ClassRoom::where('teacher_id', $teacherId)->with(['students', 'teacher'])->get();
        
        // Calculate stats
        $totalClasses = $classes->count();
        $totalStudents = $classes->sum(function($class) {
            return $class->students->count();
        });
        $unreadMessages = Notification::where('recipient_id', $teacherId)
            ->where('recipient_type', 'teacher')
            ->where('is_read', false)
            ->count();
        
        return view('teacher.dashboard', compact('teacher', 'classes', 'totalClasses', 'totalStudents', 'unreadMessages'));
    }

    public function classes()
    {
        $teacherId = session('teacher_id');
        $classes = ClassRoom::where('teacher_id', $teacherId)->with(['students', 'teacher'])->get();
        
        return view('teacher.classes', compact('classes'));
    }

    public function viewClass($id)
    {
        $teacherId = session('teacher_id');
        $class = ClassRoom::where('teacher_id', $teacherId)
            ->where('id', $id)
            ->with(['students', 'teacher'])
            ->firstOrFail();
        
        return view('teacher.view-class', compact('class'));
    }

    public function studentDetails($id)
    {
        $teacherId = session('teacher_id');
        
        // Get student with related data, ensuring teacher has access to this student
        $student = Student::whereHas('classRoom', function($query) use ($teacherId) {
            $query->where('teacher_id', $teacherId);
        })->with(['parent', 'classRoom', 'grades' => function($query) use ($teacherId) {
            $query->where('teacher_id', $teacherId);
        }, 'attendance' => function($query) use ($teacherId) {
            $query->where('teacher_id', $teacherId);
        }])->findOrFail($id);
        
        // Get recent grades
        $recentGrades = $student->grades()
            ->where('teacher_id', $teacherId)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        
        // Get attendance summary
        $attendanceSummary = $student->attendance()
            ->where('teacher_id', $teacherId)
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();
        
        // Calculate attendance percentage
        $totalAttendance = $student->attendance()->where('teacher_id', $teacherId)->count();
        $presentCount = $student->attendance()->where('teacher_id', $teacherId)->where('status', 'present')->count();
        $attendancePercentage = $totalAttendance > 0 ? round(($presentCount / $totalAttendance) * 100, 1) : 0;
        
        // Get average grade
        $averageGrade = $student->grades()
            ->where('teacher_id', $teacherId)
            ->avg('percentage');
        
        return view('teacher.student-details', compact('student', 'recentGrades', 'attendanceSummary', 'attendancePercentage', 'averageGrade'));
    }

    public function grades()
    {
        $teacherId = session('teacher_id');
        $classes = ClassRoom::where('teacher_id', $teacherId)->with(['students'])->get();
        
        return view('teacher.grades', compact('classes'));
    }

    public function addGrade(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject' => 'required|string|max:255',
            'grade' => 'required|string|max:10',
            'percentage' => 'required|numeric|min:0|max:100',
            'comments' => 'nullable|string|max:500',
        ]);
        
        Grade::create([
            'student_id' => $request->student_id,
            'subject' => $request->subject,
            'grade' => $request->grade,
            'percentage' => $request->percentage,
            'comments' => $request->comments,
            'teacher_id' => session('teacher_id'),
        ]);
        
        return redirect()->back()->with('success', 'Grade added successfully!');
    }

    public function attendance()
    {
        $teacherId = session('teacher_id');
        $classes = ClassRoom::where('teacher_id', $teacherId)->with(['students'])->get();
        
        return view('teacher.attendance', compact('classes'));
    }

    public function markAttendance(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'date' => 'required|date',
            'status' => 'required|in:present,absent,late',
            'time_in' => 'nullable|date_format:H:i',
            'time_out' => 'nullable|date_format:H:i',
            'notes' => 'nullable|string|max:500',
        ]);
        
        Attendance::updateOrCreate(
            [
                'student_id' => $request->student_id,
                'date' => $request->date,
            ],
            [
                'status' => $request->status,
                'time_in' => $request->time_in,
                'time_out' => $request->time_out,
                'notes' => $request->notes,
                'teacher_id' => session('teacher_id'),
            ]
        );
        
        return redirect()->back()->with('success', 'Attendance marked successfully!');
    }

    public function chats()
    {
        $teacherId = session('teacher_id');
        $teacher = Teacher::find($teacherId);
        
        // Get messages for this teacher
        $messages = Notification::where('recipient_id', $teacherId)
            ->where('recipient_type', 'teacher')
            ->orWhere(function($query) use ($teacherId) {
                $query->where('recipient_type', 'parent')
                      ->where('metadata->to_teacher', $teacherId);
            })
            ->orderBy('created_at', 'asc')
            ->get();
        
        return view('teacher.chats', compact('teacher', 'messages'));
    }

    public function getChatMessages($parentId)
    {
        $teacherId = session('teacher_id');
        
        $messages = Notification::where(function($query) use ($parentId, $teacherId) {
            // Messages received by teacher from this parent
            $query->where('recipient_id', $teacherId)
                  ->where('recipient_type', 'teacher')
                  ->where('metadata->from_parent', $parentId);
        })->orWhere(function($query) use ($parentId, $teacherId) {
            // Messages sent by teacher to this parent
            $query->where('recipient_id', $parentId)
                  ->where('recipient_type', 'parent')
                  ->where('metadata->from_teacher', $teacherId);
        })->orderBy('created_at', 'asc')->get();
        
        return response()->json($messages);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'parent_id' => 'required|exists:parents,id',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000'
        ]);
        
        $teacherId = session('teacher_id');
        $teacher = Teacher::find($teacherId);
        $parent = \App\Models\ParentUser::find($request->parent_id);
        
        Notification::create([
            'title' => $request->subject,
            'message' => $request->message,
            'type' => 'message',
            'recipient_type' => 'parent',
            'recipient_id' => $parent->id,
            'recipient_email' => $parent->email,
            'is_read' => false,
            'metadata' => json_encode([
                'from_teacher' => $teacher->id,
                'from_teacher_name' => $teacher->name,
                'to_parent' => $parent->id,
                'to_parent_name' => $parent->name,
                'conversation_id' => 'teacher_' . $teacher->id . '_parent_' . $parent->id
            ])
        ]);
        
        return redirect()->back()->with('success', 'Message sent successfully!');
    }

    public function markMessageAsRead($id)
    {
        $teacherId = session('teacher_id');
        $message = Notification::where('id', $id)
            ->where('recipient_id', $teacherId)
            ->where('recipient_type', 'teacher')
            ->first();
        
        if ($message) {
            $message->update([
                'is_read' => true,
                'read_at' => now()
            ]);
            
            return response()->json(['success' => true]);
        }
        
        return response()->json(['success' => false], 404);
    }

    public function profile()
    {
        $teacherId = session('teacher_id');
        $teacher = Teacher::find($teacherId);
        
        return view('teacher.profile', compact('teacher'));
    }

    public function updateProfile(Request $request)
    {
        $teacherId = session('teacher_id');
        $teacher = Teacher::find($teacherId);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers,email,' . $teacherId,
            'subject' => 'required|string|max:255',
            'current_password' => 'nullable|string',
            'new_password' => 'nullable|string|min:6|confirmed',
        ]);
        
        if ($request->filled('current_password')) {
            if ($teacher->password !== $request->current_password) {
                return back()->withErrors(['current_password' => 'Current password is incorrect']);
            }
        }
        
        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
        ];
        
        if ($request->filled('new_password')) {
            $updateData['password'] = $request->new_password;
        }
        
        $teacher->update($updateData);
        
        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
}
