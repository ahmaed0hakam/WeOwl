<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParentUser;
use App\Models\Student;
use App\Models\Notification;
use App\Models\Teacher;

class ParentController extends Controller
{
    public function dashboard()
    {
        $parentId = session('parent_id');
        $parent = ParentUser::find($parentId);
        
        // Get parent's children
        $children = Student::where('parent_id', $parentId)->with(['classRoom', 'section'])->get();
        
        // Calculate stats
        $childrenCount = $children->count(); // Changed from totalChildren to childrenCount
        $attendanceRate = $children->count() > 0 ? '85%' : '0%';
        $averageGrade = $children->count() > 0 ? 'A-' : 'N/A';
        $unreadMessages = Notification::where('recipient_id', $parentId)
            ->where('recipient_type', 'parent')
            ->where('is_read', false)
            ->count();
        
        return view('parent.dashboard', compact('children', 'childrenCount', 'attendanceRate', 'averageGrade', 'unreadMessages'));
    }

    public function children()
    {
        $parentId = session('parent_id');
        $children = Student::where('parent_id', $parentId)->with(['classRoom', 'section'])->get();
        
        return view('parent.children', compact('children'));
    }

    public function childDetails($id)
    {
        $parentId = session('parent_id');
        $child = Student::where('parent_id', $parentId)
            ->where('id', $id)
            ->with(['classRoom', 'section'])
            ->firstOrFail();
        
        return view('parent.child-details', compact('child'));
    }

    public function grades()
    {
        $parentId = session('parent_id');
        $children = Student::where('parent_id', $parentId)->with(['classRoom', 'section'])->get();
        
        // Sample grades data - in real app, this would come from database
        $grades = [
            [
                'child_name' => 'John Doe Jr.',
                'subject' => 'Mathematics',
                'grade' => 'A',
                'percentage' => '92%',
                'comments' => 'Excellent work!'
            ],
            [
                'child_name' => 'John Doe Jr.',
                'subject' => 'Science',
                'grade' => 'B+',
                'percentage' => '87%',
                'comments' => 'Good progress'
            ],
            [
                'child_name' => 'John Doe Jr.',
                'subject' => 'English',
                'grade' => 'A-',
                'percentage' => '89%',
                'comments' => 'Very good'
            ]
        ];
        
        return view('parent.grades', compact('children', 'grades'));
    }

    public function attendance()
    {
        $parentId = session('parent_id');
        $children = Student::where('parent_id', $parentId)->with(['classRoom', 'section'])->get();
        
        // Sample attendance data
        $attendance = [
            [
                'date' => '2024-01-15',
                'child_name' => 'John Doe Jr.',
                'status' => 'Present',
                'time_in' => '8:00 AM',
                'time_out' => '3:00 PM',
                'notes' => '-'
            ],
            [
                'date' => '2024-01-14',
                'child_name' => 'John Doe Jr.',
                'status' => 'Present',
                'time_in' => '8:15 AM',
                'time_out' => '3:00 PM',
                'notes' => 'Late arrival'
            ]
        ];
        
        return view('parent.attendance', compact('children', 'attendance'));
    }

    public function chats()
    {
        $parentId = session('parent_id');
        $parent = ParentUser::find($parentId);
        $teachers = Teacher::where('status', 'active')->get();
        
        // Get messages for this parent
        $messages = Notification::where('recipient_id', $parentId)
            ->where('recipient_type', 'parent')
            ->orWhere(function($query) use ($parentId) {
                $query->where('recipient_type', 'teacher')
                      ->where('metadata->from_parent', $parentId);
            })
            ->orderBy('created_at', 'asc')
            ->get();
        
        return view('parent.chats', compact('parent', 'teachers', 'messages'));
    }

    public function getChatMessages($teacherId)
    {
        $parentId = session('parent_id');
        
        // Get all messages between this parent and teacher
        $messages = Notification::where(function($query) use ($parentId, $teacherId) {
            // Messages received by parent from this teacher
            $query->where('recipient_id', $parentId)
                  ->where('recipient_type', 'parent');
        })->orWhere(function($query) use ($parentId, $teacherId) {
            // Messages sent by parent to this teacher
            $query->where('recipient_id', $teacherId)
                  ->where('recipient_type', 'teacher')
                  ->where('metadata->from_parent', $parentId);
        })->orWhere(function($query) use ($parentId, $teacherId) {
            // Messages sent by parent to this teacher (alternative check)
            $query->where('recipient_id', $teacherId)
                  ->where('recipient_type', 'teacher')
                  ->where('metadata->to_teacher', $teacherId);
        })->orderBy('created_at', 'asc')->get();
        
        // Debug log
        \Log::info('Chat messages query result:', [
            'parent_id' => $parentId,
            'teacher_id' => $teacherId,
            'messages_count' => $messages->count(),
            'messages' => $messages->toArray()
        ]);
        
        return response()->json($messages);
    }

    public function messages()
    {
        $parentId = session('parent_id');
        $messages = Notification::where('recipient_id', $parentId)
            ->where('recipient_type', 'parent')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('parent.messages', compact('messages'));
    }

    public function markMessageAsRead($id)
    {
        $parentId = session('parent_id');
        $message = Notification::where('id', $id)
            ->where('recipient_id', $parentId)
            ->where('recipient_type', 'parent')
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

    public function replyToMessage(Request $request)
    {
        $request->validate([
            'message_id' => 'required|exists:notifications,id',
            'reply_text' => 'required|string|max:1000'
        ]);
        
        $parentId = session('parent_id');
        $parent = ParentUser::find($parentId);
        
        // Get the original message to find the teacher
        $originalMessage = Notification::find($request->message_id);
        $teacherId = $originalMessage->recipient_type === 'parent' ? 
                    $originalMessage->recipient_id : 
                    (json_decode($originalMessage->metadata)->from_teacher ?? 1);
        
        // Create reply notification
        Notification::create([
            'title' => 'Reply from ' . $parent->name,
            'message' => $request->reply_text,
            'type' => 'message',
            'recipient_type' => 'teacher',
            'recipient_id' => $teacherId,
            'recipient_email' => 'teacher@school.com', // In real app, get from teacher model
            'is_read' => false,
            'metadata' => json_encode([
                'from_parent' => $parent->id,
                'from_parent_name' => $parent->name,
                'reply_to' => $request->message_id,
                'conversation_id' => 'parent_' . $parent->id . '_teacher_' . $teacherId
            ])
        ]);
        
        return redirect()->back()->with('success', 'Reply sent successfully!');
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000'
        ]);
        
        $parentId = session('parent_id');
        $parent = ParentUser::find($parentId);
        $teacher = Teacher::find($request->teacher_id);
        
        // Create message notification
        Notification::create([
            'title' => $request->subject,
            'message' => $request->message,
            'type' => 'message',
            'recipient_type' => 'teacher',
            'recipient_id' => $teacher->id,
            'recipient_email' => $teacher->email,
            'is_read' => false,
            'metadata' => json_encode([
                'from_parent' => $parent->id,
                'from_parent_name' => $parent->name,
                'to_teacher' => $teacher->id,
                'to_teacher_name' => $teacher->name,
                'conversation_id' => 'parent_' . $parent->id . '_teacher_' . $teacher->id
            ])
        ]);
        
        return redirect()->back()->with('success', 'Message sent successfully!');
    }

    public function profile()
    {
        $parentId = session('parent_id');
        $parent = ParentUser::find($parentId);
        
        return view('parent.profile', compact('parent'));
    }

    public function updateProfile(Request $request)
    {
        $parentId = session('parent_id');
        $parent = ParentUser::find($parentId);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:parents,email,' . $parentId,
            'current_password' => 'nullable|string',
            'new_password' => 'nullable|string|min:6|confirmed',
        ]);
        
        // Check current password if provided
        if ($request->filled('current_password')) {
            if ($parent->password !== $request->current_password) {
                return back()->withErrors(['current_password' => 'Current password is incorrect']);
            }
        }
        
        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
        ];
        
        // Update password if new password is provided
        if ($request->filled('new_password')) {
            $updateData['password'] = $request->new_password;
        }
        
        $parent->update($updateData);
        
        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
}
