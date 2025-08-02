<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Manager;
use App\Models\ParentUser;
use App\Models\Teacher;
use App\Models\Vice;
use App\Models\ClassRoom;
use App\Models\Student;
use App\Models\Section;
use App\Models\Notification;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create sample sections
        Section::create(['name' => 'A']);
        Section::create(['name' => 'B']);
        Section::create(['name' => 'C']);
        Section::create(['name' => 'D']);

        // Create sample users
        Manager::create([
            'name' => 'Admin Manager', 
            'email' => 'manager@weowl.com', 
            'password' => 'password123'
        ]);
        
        ParentUser::create([
            'name' => 'John Parent', 
            'email' => 'parent@weowl.com', 
            'password' => 'password123'
        ]);
        
        ParentUser::create([
            'name' => 'Jane Parent', 
            'email' => 'jane@weowl.com', 
            'password' => 'password123'
        ]);
        
        Teacher::create([
            'name' => 'Sarah Teacher', 
            'email' => 'teacher@weowl.com', 
            'password' => 'password123',
            'subject' => 'Mathematics',
            'experience_years' => 5,
            'qualification' => 'Master\'s in Education',
            'hire_date' => '2020-01-15',
            'phone' => '+962 79 123 4567',
            'address' => 'Amman, Jordan',
            'status' => 'active'
        ]);
        
        Teacher::create([
            'name' => 'Mike Teacher', 
            'email' => 'mike@weowl.com', 
            'password' => 'password123',
            'subject' => 'Science',
            'experience_years' => 3,
            'qualification' => 'Bachelor\'s in Science',
            'hire_date' => '2021-03-20',
            'phone' => '+962 79 234 5678',
            'address' => 'Amman, Jordan',
            'status' => 'active'
        ]);
        
        Teacher::create([
            'name' => 'Lisa Teacher', 
            'email' => 'lisa@weowl.com', 
            'password' => 'password123',
            'subject' => 'English',
            'experience_years' => 4,
            'qualification' => 'Master\'s in English',
            'hire_date' => '2020-09-10',
            'phone' => '+962 79 345 6789',
            'address' => 'Amman, Jordan',
            'status' => 'active'
        ]);
        
        Teacher::create([
            'name' => 'John Teacher', 
            'email' => 'john@weowl.com', 
            'password' => 'password123',
            'subject' => 'History',
            'experience_years' => 6,
            'qualification' => 'Bachelor\'s in History',
            'hire_date' => '2019-08-15',
            'phone' => '+962 79 456 7890',
            'address' => 'Amman, Jordan',
            'status' => 'on_leave'
        ]);
        
        Vice::create([
            'name' => 'Mike Vice', 
            'email' => 'vice@weowl.com', 
            'password' => 'password123'
        ]);
        
        // Create sample classes
        ClassRoom::create([
            'name' => 'Class 1A',
            'teacher_id' => 1,
            'subject' => 'Mathematics',
            'schedule' => 'Mon-Fri 8:00 AM',
            'room_number' => '101',
            'capacity' => 25,
            'description' => 'First grade mathematics class'
        ]);
        
        ClassRoom::create([
            'name' => 'Class 1B',
            'teacher_id' => 2,
            'subject' => 'Science',
            'schedule' => 'Mon-Fri 9:00 AM',
            'room_number' => '102',
            'capacity' => 23,
            'description' => 'First grade science class'
        ]);
        
        ClassRoom::create([
            'name' => 'Class 2A',
            'teacher_id' => 3,
            'subject' => 'English',
            'schedule' => 'Mon-Fri 10:00 AM',
            'room_number' => '201',
            'capacity' => 28,
            'description' => 'Second grade English class'
        ]);
        
        ClassRoom::create([
            'name' => 'Class 2B',
            'teacher_id' => 4,
            'subject' => 'History',
            'schedule' => 'Mon-Fri 11:00 AM',
            'room_number' => '202',
            'capacity' => 26,
            'description' => 'Second grade history class'
        ]);

        // Create sample students
        Student::create([
            'parent_id' => 1,
            'first_name' => 'Ahmed',
            'last_name' => 'Mohsen',
            'class_id' => 1,
            'class_name' => 'Class 1A',
            'section_id' => 1,
            'section' => 'A'
        ]);

        Student::create([
            'parent_id' => 1,
            'first_name' => 'Sara',
            'last_name' => 'Mohsen',
            'class_id' => 2,
            'class_name' => 'Class 1B',
            'section_id' => 2,
            'section' => 'B'
        ]);

        Student::create([
            'parent_id' => 2,
            'first_name' => 'Yousef',
            'last_name' => 'Saeed',
            'class_id' => 1,
            'class_name' => 'Class 1A',
            'section_id' => 1,
            'section' => 'A'
        ]);

        Student::create([
            'parent_id' => 2,
            'first_name' => 'Layla',
            'last_name' => 'Saeed',
            'class_id' => 3,
            'class_name' => 'Class 2A',
            'section_id' => 1,
            'section' => 'A'
        ]);

        // Create sample notifications
        Notification::createForAll(
            'Welcome to WeOwl',
            'Welcome to our school management system. We hope you have a great academic year!',
            'info'
        );

        Notification::createForUser(
            'New Student Registration',
            'Ahmed Mohsen has been successfully registered in Class 1A.',
            'success',
            'parent',
            1
        );

        Notification::createForUser(
            'Class Assignment',
            'You have been assigned to teach Class 1A (Mathematics).',
            'info',
            'teacher',
            1
        );

        Notification::createForUser(
            'System Update',
            'The school management system has been updated with new features.',
            'info',
            'manager',
            1
        );
    }
}
