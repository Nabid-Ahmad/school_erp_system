<?php
$file = 'resources/views/layouts/sidebar.blade.php';
$content = file_get_contents($file);

$replacements = [
    // Master Data
    '            <!-- Master Data -->
            <div class="px-6 py-2 mt-6 mb-2">
                <p class="text-[10px] font-black uppercase text-purple-300 tracking-widest">Master Data</p>
            </div>' => '            <!-- Master Data -->
            @canany([\'manage classes\', \'manage subjects\', \'manage teachers\', \'manage students\'])
            <div class="px-6 py-2 mt-6 mb-2">
                <p class="text-[10px] font-black uppercase text-purple-300 tracking-widest">Master Data</p>
            </div>
            @endcanany',
            
    '<a href="{{ route(\'classes.index\') }}"' => '@can(\'manage classes\')
            <a href="{{ route(\'classes.index\') }}"',
    '<span>Classes</span>
            </a>' => '<span>Classes</span>
            </a>
            @endcan',
            
    '<a href="{{ route(\'subjects.index\') }}"' => '@can(\'manage subjects\')
            <a href="{{ route(\'subjects.index\') }}"',
    '<span>Subjects</span>
            </a>' => '<span>Subjects</span>
            </a>
            @endcan',

    '<a href="{{ route(\'teachers.index\') }}"' => '@can(\'manage teachers\')
            <a href="{{ route(\'teachers.index\') }}"',
    '<span>Teachers</span>
            </a>' => '<span>Teachers</span>
            </a>
            @endcan',

    '<a href="{{ route(\'students.index\') }}"' => '@can(\'manage students\')
            <a href="{{ route(\'students.index\') }}"',
    '<span>Students</span>
            </a>' => '<span>Students</span>
            </a>
            @endcan',

    // Operations
    '            <!-- Operations -->
            <div class="px-6 py-2 mt-6 mb-2">
                <p class="text-[10px] font-black uppercase text-purple-300 tracking-widest">Operations</p>
            </div>' => '            <!-- Operations -->
            @canany([\'manage attendances\', \'manage results\', \'manage promotions\', \'manage fees\', \'manage expenses\', \'manage salaries\'])
            <div class="px-6 py-2 mt-6 mb-2">
                <p class="text-[10px] font-black uppercase text-purple-300 tracking-widest">Operations</p>
            </div>
            @endcanany',

    '<a href="{{ route(\'attendances.index\') }}"' => '@can(\'manage attendances\')
            <a href="{{ route(\'attendances.index\') }}"',
    '<span>Attendance</span>
            </a>' => '<span>Attendance</span>
            </a>
            @endcan',

    '<a href="{{ route(\'results.index\') }}"' => '@can(\'manage results\')
            <a href="{{ route(\'results.index\') }}"',
    '<span>Results</span>
            </a>' => '<span>Results</span>
            </a>
            @endcan',

    '<a href="{{ route(\'promotions.index\') }}"' => '@can(\'manage promotions\')
            <a href="{{ route(\'promotions.index\') }}"',
    '<span>Promotions</span>
            </a>' => '<span>Promotions</span>
            </a>
            @endcan',

    '<a href="{{ route(\'fees.index\') }}"' => '@can(\'manage fees\')
            <a href="{{ route(\'fees.index\') }}"',
    '<span>Fees Collected</span>
            </a>' => '<span>Fees Collected</span>
            </a>
            @endcan',

    '<a href="{{ route(\'expenses.index\') }}"' => '@can(\'manage expenses\')
            <a href="{{ route(\'expenses.index\') }}"',
    '<span>Expenses</span>
            </a>' => '<span>Expenses</span>
            </a>
            @endcan',

    '<a href="{{ route(\'salaries.index\') }}"' => '@can(\'manage salaries\')
            <a href="{{ route(\'salaries.index\') }}"',
    '<span>Staff Payroll</span>
            </a>' => '<span>Staff Payroll</span>
            </a>
            @endcan',

    // Website CMS
    '            <!-- Website CMS -->
            <div class="px-6 py-2 mt-6 mb-2">
                <p class="text-[10px] font-black uppercase text-purple-300 tracking-widest">Website CMS</p>
            </div>' => '            <!-- Website CMS -->
            @canany([\'manage fees\', \'manage galleries\', \'manage events\'])
            <div class="px-6 py-2 mt-6 mb-2">
                <p class="text-[10px] font-black uppercase text-purple-300 tracking-widest">Website CMS</p>
            </div>
            @endcanany',

    '<a href="{{ route(\'fee-structures.index\') }}"' => '@can(\'manage fees\')
            <a href="{{ route(\'fee-structures.index\') }}"',
    '<span>Fee Structure</span>
            </a>' => '<span>Fee Structure</span>
            </a>
            @endcan',

    '<a href="{{ route(\'galleries.index\') }}"' => '@can(\'manage galleries\')
            <a href="{{ route(\'galleries.index\') }}"',
    '<span>Gallery</span>
            </a>' => '<span>Gallery</span>
            </a>
            @endcan',

    '<a href="{{ route(\'events.index\') }}"' => '@can(\'manage events\')
            <a href="{{ route(\'events.index\') }}"',
    '<span>Events</span>
            </a>' => '<span>Events</span>
            </a>
            @endcan',

    '<a href="{{ route(\'users.index\') }}"' => '@if(auth()->user()->role === \'admin\')
            <div class="px-6 py-2 mt-6 mb-2">
                <p class="text-[10px] font-black uppercase text-purple-300 tracking-widest">System Admin</p>
            </div>
            <a href="{{ route(\'users.index\') }}"',
    '<span>User Management</span>
            </a>' => '<span>User Management</span>
            </a>',

    '<a href="{{ route(\'settings.index\') }}"' => '<a href="{{ route(\'settings.index\') }}"',
    '<span>School Settings</span>
            </a>' => '<span>School Settings</span>
            </a>
            @endif'
];

foreach ($replacements as $search => $replace) {
    $content = str_replace($search, $replace, $content);
}

file_put_contents($file, $content);
echo "Sidebar patched!\n";
?>
