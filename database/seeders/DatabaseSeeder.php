<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create permissions
        $permissions = [
            'view posts',
            'create posts',
            'edit posts',
            'delete posts',
            'view categories',
            'create categories',
            'edit categories',
            'delete categories',
            'view tags',
            'create tags',
            'edit tags',
            'delete tags',
            'view users',
            'create users',
            'edit users',
            'delete users',
            'view roles',
            'create roles',
            'edit roles',
            'delete roles',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo([
            'view posts',
            'view categories',
            'view tags',
        ]);

        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo([
            'view posts',
            'create posts',
            'edit posts',
            'delete posts',
            'view categories',
            'create categories',
            'edit categories',
            'delete categories',
            'view tags',
            'create tags',
            'edit tags',
            'delete tags',
        ]);

        $superAdminRole = Role::create(['name' => 'super-admin']);
        $superAdminRole->givePermissionTo(Permission::all());

        // Create super admin
        $superAdmin = User::create([
            'name' => 'System Admin',
            'email' => 'markc@renta.net',
            'password' => Hash::make('25RKkUJ4vfsDxSzz'),
            'email_verified_at' => now(),
        ]);
        $superAdmin->assignRole($superAdminRole);

        // Create regular users
        User::factory(5)->create()->each(function ($user) use ($userRole) {
            $user->assignRole($userRole);
        });

        // Create categories
        $categories = [
            [
                'name' => 'Technology',
                'slug' => 'technology',
                'description' => 'Posts about the latest technologies and innovations.'
            ],
            [
                'name' => 'Business',
                'slug' => 'business',
                'description' => 'Articles on business strategies, management, and entrepreneurship.'
            ],
            [
                'name' => 'Lifestyle',
                'slug' => 'lifestyle',
                'description' => 'Content about daily life, wellness, and personal development.'
            ],
            [
                'name' => 'Science',
                'slug' => 'science',
                'description' => 'Discoveries, research, and scientific advancements.'
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create tags
        $tags = [
            ['name' => 'AI', 'slug' => 'ai'],
            ['name' => 'Web Development', 'slug' => 'web-development'],
            ['name' => 'Finance', 'slug' => 'finance'],
            ['name' => 'Health', 'slug' => 'health'],
        ];

        foreach ($tags as $tag) {
            Tag::create($tag);
        }

        // Create posts
        $users = User::all();
        $categories = Category::all();
        $tags = Tag::all();

        for ($i = 1; $i <= 20; $i++) {
            $title = 'Sample Blog Post ' . $i;
            $isPublished = rand(0, 10) > 2; // 80% chance of being published
            $isFeatured = rand(0, 10) > 7; // 30% chance of being featured

            $post = Post::create([
                'title' => $title,
                'slug' => Str::slug($title),
                'excerpt' => 'This is a sample excerpt for blog post ' . $i . '. It gives a brief overview of the content.',
                'content' => '<p>This is the content of blog post ' . $i . '. Here you would find detailed information about the topic.</p>
                <h2>Section 1</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                <h2>Section 2</h2>
                <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>',
                'user_id' => $users->random()->id,
                'category_id' => $categories->random()->id,
                'is_published' => $isPublished,
                'is_featured' => $isFeatured && $isPublished, // Only published posts can be featured
                'published_at' => $isPublished ? now()->subDays(rand(1, 30)) : null,
            ]);

            // Attach 1-3 random tags to each post
            $post->tags()->attach($tags->random(rand(1, 3)));
        }
    }
}
