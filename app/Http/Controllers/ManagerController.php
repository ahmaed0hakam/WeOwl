<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Manager;
use App\Models\ParentUser;
use App\Models\Teacher;
use App\Models\Vice;
use App\Models\Student;
use App\Models\ClassRoom;
use App\Models\Section;
use App\Models\Notification;

class ManagerController extends Controller
{
    public function dashboard()
    {
        // Check if manager is logged in
        if (!session('manager_id')) {
            return redirect()->route('manager.login');
        }

        $manager = Manager::find(session('manager_id'));
        
        // Get statistics
        $totalStudents = Student::count();
        $totalTeachers = Teacher::count();
        $totalClasses = ClassRoom::count();
        $totalParents = ParentUser::count();
        
        return view('manager.dashboard', compact('manager', 'totalStudents', 'totalTeachers', 'totalClasses', 'totalParents'));
    }

    public function parentDashboard()
    {
        // Check if parent is logged in
        if (!session('parent_id')) {
            return redirect()->route('parent.login');
        }

        $parent = ParentUser::find(session('parent_id'));
        
        // Get parent statistics
        $totalChildren = 2; // Mock data
        $attendanceRate = '85%';
        $averageGrade = 'A-';
        $unreadMessages = 3;
        
        return view('parent.dashboard', compact('parent', 'totalChildren', 'attendanceRate', 'averageGrade', 'unreadMessages'));
    }

    public function teacherDashboard()
    {
        // Check if teacher is logged in
        if (!session('teacher_id')) {
            return redirect()->route('teacher.login');
        }

        $teacher = Teacher::find(session('teacher_id'));
        
        // Get teacher statistics
        $totalStudents = 25;
        $totalClasses = 2;
        $attendanceRate = '92%';
        $unreadMessages = 2;
        
        return view('teacher.dashboard', compact('teacher', 'totalStudents', 'totalClasses', 'attendanceRate', 'unreadMessages'));
    }

    public function viceDashboard()
    {
        // Check if vice manager is logged in
        if (!session('vice_id')) {
            return redirect()->route('vice.login');
        }

        $vice = Vice::find(session('vice_id'));
        
        // Get vice manager statistics
        $totalStudents = 150;
        $totalTeachers = 12;
        $totalClasses = 8;
        $attendanceRate = '88%';
        
        return view('vice.dashboard', compact('vice', 'totalStudents', 'totalTeachers', 'totalClasses', 'attendanceRate'));
    }

    // Add Teacher
    public function addTeacher(Request $request)
    {
        if (!session('manager_id')) {
            return redirect()->route('manager.login');
        }

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:6|confirmed',
            'subject' => 'required|string|max:255',
            'experience_years' => 'nullable|integer|min:0|max:50',
            'qualification' => 'nullable|string|max:255',
            'hire_date' => 'required|date',
            'address' => 'nullable|string',
        ]);

        // Create teacher
        Teacher::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'password' => $request->password,
            'subject' => $request->subject,
            'experience_years' => $request->experience_years,
            'qualification' => $request->qualification,
            'hire_date' => $request->hire_date,
            'address' => $request->address,
            'status' => 'active'
        ]);

        return redirect()->route('manager.dashboard')->with('success', 'Teacher added successfully!');
    }

    // Manager Profile Management
    public function updateProfile(Request $request)
    {
        if (!session('manager_id')) {
            return redirect()->route('manager.login');
        }

        $manager = Manager::find(session('manager_id'));
        
        if (!$manager) {
            return redirect()->route('manager.login');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:managers,email,' . $manager->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'current_password' => 'nullable|string',
            'new_password' => 'nullable|string|min:6|confirmed',
        ]);

        // Update basic info
        $manager->name = $request->name;
        $manager->email = $request->email;
        
        // Update password if provided
        if ($request->filled('new_password')) {
            if ($request->current_password !== $manager->password) {
                return back()->withErrors(['current_password' => 'Current password is incorrect']);
            }
            $manager->password = $request->new_password;
        }

        $manager->save();

        return redirect()->route('manager.profile')->with('success', 'Profile updated successfully!');
    }

    // Add Student
    public function addStudent(Request $request)
    {
        if (!session('manager_id')) {
            return redirect()->route('manager.login');
        }

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'class_id' => 'required|exists:class_rooms,id',
            'parent_id' => 'required|exists:parents,id',
            'section_id' => 'required|exists:sections,id',
        ]);

        // Get the class and section details
        $classRoom = ClassRoom::find($request->class_id);
        $section = Section::find($request->section_id);
        $parent = ParentUser::find($request->parent_id);

        // Create student
        $student = Student::create([
            'parent_id' => $request->parent_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'class_id' => $request->class_id,
            'class_name' => $classRoom->name,
            'section_id' => $request->section_id,
            'section' => $section->name,
        ]);

        // Create notification for parent
        Notification::createForUser(
            'New Student Registration',
            "Your child {$student->first_name} {$student->last_name} has been registered in {$classRoom->name}.",
            'success',
            'parent',
            $parent->id,
            $parent->email
        );

        // Create notification for teacher
        if ($classRoom->teacher_id) {
            Notification::createForUser(
                'New Student Assigned',
                "Student {$student->first_name} {$student->last_name} has been assigned to your class {$classRoom->name}.",
                'info',
                'teacher',
                $classRoom->teacher_id
            );
        }

        return redirect()->route('manager.dashboard')->with('success', 'Student added successfully!');
    }

    // Class Management Methods
    public function manageClasses()
    {
        if (!session('manager_id')) {
            return redirect()->route('manager.login');
        }

        $classes = ClassRoom::with(['teacher', 'students'])->get();
        return view('manager.manage-classes', compact('classes'));
    }

    public function addClass(Request $request)
    {
        if (!session('manager_id')) {
            return redirect()->route('manager.login');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'teacher_id' => 'required|exists:teachers,id',
            'subject' => 'required|string|max:255',
            'schedule' => 'required|string|max:255',
            'room_number' => 'required|string|max:50',
            'capacity' => 'required|integer|min:1|max:100',
            'description' => 'nullable|string',
        ]);

        $class = ClassRoom::create($request->all());

        // Create notification for teacher
        $teacher = Teacher::find($request->teacher_id);
        Notification::createForUser(
            'New Class Assignment',
            "You have been assigned to teach {$class->name} ({$class->subject}).",
            'info',
            'teacher',
            $teacher->id,
            $teacher->email
        );

        return redirect()->route('manager.manage-classes')->with('success', 'Class created successfully!');
    }

    public function editClass(Request $request, $id)
    {
        if (!session('manager_id')) {
            return redirect()->route('manager.login');
        }

        $class = ClassRoom::findOrFail($id);
        $oldTeacherId = $class->teacher_id;

        $request->validate([
            'name' => 'required|string|max:255',
            'teacher_id' => 'required|exists:teachers,id',
            'subject' => 'required|string|max:255',
            'schedule' => 'required|string|max:255',
            'room_number' => 'required|string|max:50',
            'capacity' => 'required|integer|min:1|max:100',
            'description' => 'nullable|string',
        ]);

        $class->update($request->all());

        // Create notification if teacher changed
        if ($oldTeacherId != $request->teacher_id) {
            $newTeacher = Teacher::find($request->teacher_id);
            Notification::createForUser(
                'Class Assignment Updated',
                "You have been assigned to teach {$class->name} ({$class->subject}).",
                'info',
                'teacher',
                $newTeacher->id,
                $newTeacher->email
            );
        }

        return redirect()->route('manager.manage-classes')->with('success', 'Class updated successfully!');
    }

    public function viewClass($id)
    {
        if (!session('manager_id')) {
            return redirect()->route('manager.login');
        }

        $class = ClassRoom::with(['teacher', 'students'])->findOrFail($id);
        $availableStudents = Student::whereNull('class_id')->orWhere('class_id', '!=', $id)->get();
        return view('manager.view-class', compact('class', 'availableStudents'));
    }

    public function deleteClass($id)
    {
        if (!session('manager_id')) {
            return redirect()->route('manager.login');
        }

        $class = ClassRoom::with('students')->findOrFail($id);
        
        // Notify students and teacher about class deletion
        foreach ($class->students as $student) {
            Notification::createForUser(
                'Class Cancelled',
                "Your class {$class->name} has been cancelled. Please contact the administration for reassignment.",
                'warning',
                'student',
                $student->id
            );
        }

        if ($class->teacher_id) {
            Notification::createForUser(
                'Class Cancelled',
                "Your class {$class->name} has been cancelled.",
                'warning',
                'teacher',
                $class->teacher_id
            );
        }

        $class->delete();

        return redirect()->route('manager.manage-classes')->with('success', 'Class deleted successfully!');
    }

    // Assign Students to Class
    public function assignStudentsToClass(Request $request, $classId)
    {
        if (!session('manager_id')) {
            return redirect()->route('manager.login');
        }

        $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:students,id',
        ]);

        $class = ClassRoom::findOrFail($classId);
        $students = Student::whereIn('id', $request->student_ids)->get();
        
        // Update students to this class
        Student::whereIn('id', $request->student_ids)->update([
            'class_id' => $classId,
            'class_name' => $class->name,
        ]);

        // Create notifications for students and parents
        foreach ($students as $student) {
            Notification::createForUser(
                'Class Assignment',
                "You have been assigned to {$class->name}.",
                'info',
                'student',
                $student->id
            );

            Notification::createForUser(
                'Student Class Assignment',
                "Your child {$student->first_name} {$student->last_name} has been assigned to {$class->name}.",
                'info',
                'parent',
                $student->parent_id
            );
        }

        return redirect()->route('manager.view-class', $classId)->with('success', 'Students assigned successfully!');
    }

    // Remove Students from Class
    public function removeStudentsFromClass(Request $request, $classId)
    {
        if (!session('manager_id')) {
            return redirect()->route('manager.login');
        }

        $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:students,id',
        ]);

        $class = ClassRoom::findOrFail($classId);
        $students = Student::whereIn('id', $request->student_ids)->get();

        // Set students to no class
        Student::whereIn('id', $request->student_ids)->update([
            'class_id' => null,
            'class_name' => 'Unassigned',
        ]);

        // Create notifications for students and parents
        foreach ($students as $student) {
            Notification::createForUser(
                'Class Removal',
                "You have been removed from {$class->name}.",
                'warning',
                'student',
                $student->id
            );

            Notification::createForUser(
                'Student Class Removal',
                "Your child {$student->first_name} {$student->last_name} has been removed from {$class->name}.",
                'warning',
                'parent',
                $student->parent_id
            );
        }

        return redirect()->route('manager.view-class', $classId)->with('success', 'Students removed successfully!');
    }

    // Student Management Methods
    public function manageStudents()
    {
        if (!session('manager_id')) {
            return redirect()->route('manager.login');
        }

        $students = Student::with(['classRoom', 'parent'])->get();
        return view('manager.students', compact('students'));
    }

    public function viewStudent($id)
    {
        if (!session('manager_id')) {
            return redirect()->route('manager.login');
        }

        $student = Student::with(['classRoom', 'parent'])->findOrFail($id);
        return view('manager.view-student', compact('student'));
    }

    public function editStudent($id)
    {
        if (!session('manager_id')) {
            return redirect()->route('manager.login');
        }

        $student = Student::findOrFail($id);
        $classes = ClassRoom::all();
        $parents = ParentUser::all();
        $sections = Section::all();
        
        return view('manager.edit-student', compact('student', 'classes', 'parents', 'sections'));
    }

    public function updateStudent(Request $request, $id)
    {
        if (!session('manager_id')) {
            return redirect()->route('manager.login');
        }

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'class_id' => 'nullable|exists:class_rooms,id',
            'parent_id' => 'required|exists:parents,id',
            'section_id' => 'required|exists:sections,id',
        ]);

        $student = Student::findOrFail($id);
        $classRoom = $request->class_id ? ClassRoom::find($request->class_id) : null;
        $section = Section::find($request->section_id);

        $student->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'class_id' => $request->class_id,
            'class_name' => $classRoom ? $classRoom->name : 'Unassigned',
            'section_id' => $request->section_id,
            'section' => $section->name,
        ]);

        return redirect()->route('manager.students')->with('success', 'Student updated successfully!');
    }

    // Teacher Management Methods
    public function manageTeachers()
    {
        if (!session('manager_id')) {
            return redirect()->route('manager.login');
        }

        $teachers = Teacher::all();
        return view('manager.teachers', compact('teachers'));
    }

    public function viewTeacher($id)
    {
        if (!session('manager_id')) {
            return redirect()->route('manager.login');
        }

        $teacher = Teacher::findOrFail($id);
        $classes = ClassRoom::where('teacher_id', $id)->get();
        
        return view('manager.view-teacher', compact('teacher', 'classes'));
    }

    public function editTeacher($id)
    {
        if (!session('manager_id')) {
            return redirect()->route('manager.login');
        }

        $teacher = Teacher::findOrFail($id);
        return view('manager.edit-teacher', compact('teacher'));
    }

    public function updateTeacher(Request $request, $id)
    {
        if (!session('manager_id')) {
            return redirect()->route('manager.login');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers,email,' . $id,
            'subject' => 'required|string|max:255',
            'experience_years' => 'nullable|integer|min:0|max:50',
            'qualification' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'status' => 'required|in:active,on_leave,inactive',
        ]);

        $teacher = Teacher::findOrFail($id);
        $teacher->update($request->all());

        return redirect()->route('manager.teachers')->with('success', 'Teacher updated successfully!');
    }

    // Parent Management Methods
    public function manageParents()
    {
        if (!session('manager_id')) {
            return redirect()->route('manager.login');
        }

        $parents = ParentUser::with('students')->get();
        return view('manager.parents', compact('parents'));
    }

    public function viewParent($id)
    {
        if (!session('manager_id')) {
            return redirect()->route('manager.login');
        }

        $parent = ParentUser::with('students')->findOrFail($id);
        return view('manager.view-parent', compact('parent'));
    }

    public function editParent($id)
    {
        if (!session('manager_id')) {
            return redirect()->route('manager.login');
        }

        $parent = ParentUser::findOrFail($id);
        return view('manager.edit-parent', compact('parent'));
    }

    public function updateParent(Request $request, $id)
    {
        if (!session('manager_id')) {
            return redirect()->route('manager.login');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:parents,email,' . $id,
        ]);

        $parent = ParentUser::findOrFail($id);
        $parent->update($request->all());

        return redirect()->route('manager.parents')->with('success', 'Parent updated successfully!');
    }

    public function addParent()
    {
        if (!session('manager_id')) {
            return redirect()->route('manager.login');
        }

        return view('manager.add-parent');
    }

    public function storeParent(Request $request)
    {
        if (!session('manager_id')) {
            return redirect()->route('manager.login');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:parents,email',
            'password' => 'required|string|min:6',
        ]);

        ParentUser::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        return redirect()->route('manager.parents')->with('success', 'Parent added successfully!');
    }

    // Parent Profile Management
    public function updateParentProfile(Request $request)
    {
        if (!session('parent_id')) {
            return redirect()->route('parent.login');
        }

        $parent = ParentUser::find(session('parent_id'));
        
        if (!$parent) {
            return redirect()->route('parent.login');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:parents,email,' . $parent->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'current_password' => 'nullable|string',
            'new_password' => 'nullable|string|min:6|confirmed',
        ]);

        // Update basic info
        $parent->name = $request->name;
        $parent->email = $request->email;
        
        // Update password if provided
        if ($request->filled('new_password')) {
            if ($request->current_password !== $parent->password) {
                return back()->withErrors(['current_password' => 'Current password is incorrect']);
            }
            $parent->password = $request->new_password;
        }

        $parent->save();

        return redirect()->route('parent.profile')->with('success', 'Profile updated successfully!');
    }
}
