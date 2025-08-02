<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\TeacherController;
use App\Models\Manager;
use App\Models\ParentUser;
use App\Models\Teacher;
use App\Models\Vice;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Registration Routes
Route::get('/register/parent', function() { return view('auth.register-parent'); })->name('register.parent');
Route::post('/register/parent', [AuthController::class, 'registerParent'])->name('register.parent.post');
Route::get('/register/teacher', function() { return view('auth.register-teacher'); })->name('register.teacher');
Route::post('/register/teacher', [AuthController::class, 'registerTeacher'])->name('register.teacher.post');

// Parent Login Routes
Route::get('/parent/login', [AuthController::class, 'showParentLogin'])->name('parent.login');
Route::post('/parent/login', [AuthController::class, 'parentLogin'])->name('parent.login.post');

// Teacher Login Routes
Route::get('/teacher/login', [AuthController::class, 'showTeacherLogin'])->name('teacher.login');
Route::post('/teacher/login', [AuthController::class, 'teacherLogin'])->name('teacher.login.post');

// Logout Routes
Route::get('/parent/logout', function() { 
    session()->forget('parent_id'); 
    return redirect('/'); 
})->name('parent.logout');

Route::get('/teacher/logout', function() { 
    session()->forget('teacher_id'); 
    return redirect('/'); 
})->name('teacher.logout');

Route::get('/manager/logout', function() { 
    session()->forget('manager_id'); 
    return redirect('/'); 
})->name('manager.logout');

// Teacher Routes
Route::middleware(['auth.teacher'])->group(function () {
    Route::get('/teacher/dashboard', [TeacherController::class, 'dashboard'])->name('teacher.dashboard');
    Route::get('/teacher/classes', [TeacherController::class, 'classes'])->name('teacher.classes');
    Route::get('/teacher/class/{id}', [TeacherController::class, 'viewClass'])->name('teacher.view-class');
    Route::get('/teacher/student/{id}', [TeacherController::class, 'studentDetails'])->name('teacher.student-details');
    Route::get('/teacher/grades', [TeacherController::class, 'grades'])->name('teacher.grades');
    Route::post('/teacher/grade/add', [TeacherController::class, 'addGrade'])->name('teacher.add-grade');
    Route::get('/teacher/attendance', [TeacherController::class, 'attendance'])->name('teacher.attendance');
    Route::post('/teacher/attendance/mark', [TeacherController::class, 'markAttendance'])->name('teacher.mark-attendance');
    Route::get('/teacher/chats', [TeacherController::class, 'chats'])->name('teacher.chats');
    Route::get('/teacher/chat/messages/{parentId}', [TeacherController::class, 'getChatMessages'])->name('teacher.chat.messages');
    Route::post('/teacher/chat/send', [TeacherController::class, 'sendMessage'])->name('teacher.chat.send');
    Route::post('/teacher/message/read/{id}', [TeacherController::class, 'markMessageAsRead'])->name('teacher.message.read');
    Route::get('/teacher/profile', [TeacherController::class, 'profile'])->name('teacher.profile');
    Route::post('/teacher/update-profile', [TeacherController::class, 'updateProfile'])->name('teacher.update-profile');
});

// Parent Routes
Route::middleware(['auth.parent'])->group(function () {
    Route::get('/parent/dashboard', [ParentController::class, 'dashboard'])->name('parent.dashboard');
    Route::get('/parent/children', [ParentController::class, 'children'])->name('parent.children');
    Route::get('/parent/child/{id}', [ParentController::class, 'childDetails'])->name('parent.child.details');
    Route::get('/parent/grades', [ParentController::class, 'grades'])->name('parent.grades');
    Route::get('/parent/attendance', [ParentController::class, 'attendance'])->name('parent.attendance');
    Route::get('/parent/chats', [ParentController::class, 'chats'])->name('parent.chats');
    Route::get('/parent/messages', [ParentController::class, 'messages'])->name('parent.messages');
    Route::get('/parent/chat/messages/{teacherId}', [ParentController::class, 'getChatMessages'])->name('parent.chat.messages');
    Route::get('/parent/profile', [ParentController::class, 'profile'])->name('parent.profile');
    Route::post('/parent/update-profile', [ParentController::class, 'updateProfile'])->name('parent.update-profile');
    Route::post('/parent/message/read/{id}', [ParentController::class, 'markMessageAsRead'])->name('parent.message.read');
    Route::post('/parent/message/reply', [ParentController::class, 'replyToMessage'])->name('parent.message.reply');
    Route::post('/parent/chat/send', [ParentController::class, 'sendMessage'])->name('parent.chat.send');
    
    // Temporary route for testing - remove in production
    Route::get('/parent/test-messages', function() {
        $parentId = session('parent_id');
        $teacher = \App\Models\Teacher::first();
        
        if ($parentId && $teacher) {
            // Create a test message from teacher to parent
            \App\Models\Notification::create([
                'title' => 'Test Message from Teacher',
                'message' => 'Hello! This is a test message from your teacher.',
                'type' => 'message',
                'recipient_type' => 'parent',
                'recipient_id' => $parentId,
                'recipient_email' => 'parent@test.com',
                'is_read' => false,
                'metadata' => json_encode(['from_teacher' => $teacher->id])
            ]);
            
            return redirect()->back()->with('success', 'Test message created!');
        }
        
        return redirect()->back()->with('error', 'Could not create test message');
    })->name('parent.test-messages');
});

// Manager Routes
Route::get('/manager/login', [AuthController::class, 'showManagerLogin'])->name('manager.login');
Route::post('/manager/login', [AuthController::class, 'managerLogin'])->name('manager.login.post');

// Protected Manager Routes
Route::middleware(['auth.manager'])->group(function () {
    Route::get('/manager/dashboard', [ManagerController::class, 'dashboard'])->name('manager.dashboard');
    Route::get('/manager/add-student', function() { return view('manager.add-student'); })->name('manager.add-student');
    Route::post('/manager/add-student', [ManagerController::class, 'addStudent'])->name('manager.add-student.post');
    Route::get('/manager/add-teacher', function() { return view('manager.add-teacher'); })->name('manager.add-teacher');
    Route::post('/manager/add-teacher', [ManagerController::class, 'addTeacher'])->name('manager.add-teacher.post');

    // Class Management Routes
    Route::get('/manager/manage-classes', [ManagerController::class, 'manageClasses'])->name('manager.manage-classes');
    Route::get('/manager/add-class', function() { return view('manager.add-class'); })->name('manager.add-class');
    Route::post('/manager/add-class', [ManagerController::class, 'addClass'])->name('manager.add-class.post');
    Route::get('/manager/edit-class/{id}', function($id) { 
        $class = \App\Models\ClassRoom::findOrFail($id);
        $teachers = \App\Models\Teacher::all();
        return view('manager.edit-class', compact('class', 'teachers')); 
    })->name('manager.edit-class');
    Route::post('/manager/edit-class/{id}', [ManagerController::class, 'editClass'])->name('manager.edit-class.post');
    Route::get('/manager/view-class/{id}', [ManagerController::class, 'viewClass'])->name('manager.view-class');
    Route::delete('/manager/delete-class/{id}', [ManagerController::class, 'deleteClass'])->name('manager.delete-class');
    Route::post('/manager/assign-students/{classId}', [ManagerController::class, 'assignStudentsToClass'])->name('manager.assign-students');
    Route::post('/manager/remove-students/{classId}', [ManagerController::class, 'removeStudentsFromClass'])->name('manager.remove-students');

    // Student Management Routes
    Route::get('/manager/students', [ManagerController::class, 'manageStudents'])->name('manager.students');
    Route::get('/manager/view-student/{id}', [ManagerController::class, 'viewStudent'])->name('manager.view-student');
    Route::get('/manager/edit-student/{id}', [ManagerController::class, 'editStudent'])->name('manager.edit-student');
    Route::post('/manager/edit-student/{id}', [ManagerController::class, 'updateStudent'])->name('manager.edit-student.post');

    // Teacher Management Routes
    Route::get('/manager/teachers', [ManagerController::class, 'manageTeachers'])->name('manager.teachers');
    Route::get('/manager/view-teacher/{id}', [ManagerController::class, 'viewTeacher'])->name('manager.view-teacher');
    Route::get('/manager/edit-teacher/{id}', [ManagerController::class, 'editTeacher'])->name('manager.edit-teacher');
    Route::post('/manager/edit-teacher/{id}', [ManagerController::class, 'updateTeacher'])->name('manager.edit-teacher.post');

    // Parent Management Routes
    Route::get('/manager/parents', [ManagerController::class, 'manageParents'])->name('manager.parents');
    Route::get('/manager/view-parent/{id}', [ManagerController::class, 'viewParent'])->name('manager.view-parent');
    Route::get('/manager/edit-parent/{id}', [ManagerController::class, 'editParent'])->name('manager.edit-parent');
    Route::post('/manager/edit-parent/{id}', [ManagerController::class, 'updateParent'])->name('manager.edit-parent.post');
    Route::get('/manager/add-parent', [ManagerController::class, 'addParent'])->name('manager.add-parent');
    Route::post('/manager/add-parent', [ManagerController::class, 'storeParent'])->name('manager.add-parent.post');

    Route::get('/manager/profile', function() { 
        $manager = Manager::find(session('manager_id'));
        return view('manager.profile', compact('manager')); 
    })->name('manager.profile');
});

// Vice Manager Routes
Route::get('/vice/login', [AuthController::class, 'showViceLogin'])->name('vice.login');
Route::post('/vice/login', [AuthController::class, 'viceLogin'])->name('vice.login.post');
Route::get('/vice/dashboard', [ManagerController::class, 'viceDashboard'])->name('vice.dashboard');
Route::get('/vice/classes', function() { return view('vice.classes'); })->name('vice.classes');
Route::get('/vice/teachers', function() { return view('vice.teachers'); })->name('vice.teachers');
Route::get('/vice/add-user', function() { return view('vice.add-user'); })->name('vice.add-user');
Route::get('/vice/attendance-reports', function() { return view('vice.attendance-reports'); })->name('vice.attendance-reports');
Route::get('/vice/profile', function() { 
    $vice = Vice::find(session('vice_id'));
    return view('vice.profile', compact('vice')); 
})->name('vice.profile');
Route::get('/vice/logout', function() { session()->flush(); return redirect('/'); })->name('vice.logout');
