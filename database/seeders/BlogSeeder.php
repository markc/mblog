<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use App\Models\Setting;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a test user
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        // Create categories
        $categories = [
            ['name' => 'Technology', 'slug' => 'technology'],
            ['name' => 'Web Development', 'slug' => 'web-development'],
            ['name' => 'Laravel', 'slug' => 'laravel'],
            ['name' => 'JavaScript', 'slug' => 'javascript'],
            ['name' => 'Design', 'slug' => 'design'],
        ];

        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }

        // Create tags
        $tags = [
            ['name' => 'PHP', 'slug' => 'php'],
            ['name' => 'Laravel', 'slug' => 'laravel'],
            ['name' => 'Filament', 'slug' => 'filament'],
            ['name' => 'Vue.js', 'slug' => 'vuejs'],
            ['name' => 'React', 'slug' => 'react'],
            ['name' => 'CSS', 'slug' => 'css'],
            ['name' => 'HTML', 'slug' => 'html'],
            ['name' => 'API', 'slug' => 'api'],
            ['name' => 'Database', 'slug' => 'database'],
            ['name' => 'Tutorial', 'slug' => 'tutorial'],
        ];

        foreach ($tags as $tagData) {
            Tag::create($tagData);
        }

        // Create sample posts
        $posts = [
            [
                'title' => 'Getting Started with Laravel 12',
                'slug' => 'getting-started-with-laravel-12',
                'content' => '<h2>Introduction to Laravel 12</h2><p>Laravel 12 brings exciting new features and improvements that make web development even more enjoyable. In this comprehensive guide, we\'ll explore the key features and show you how to get started.</p><h3>What\'s New</h3><p>Laravel 12 introduces several new features including improved performance, better developer experience, and enhanced security measures.</p><p>This framework continues to be the go-to choice for PHP developers worldwide.</p>',
                'excerpt' => 'Learn about the exciting new features in Laravel 12 and how to get started with this powerful PHP framework.',
                'published_at' => now()->subDays(1),
                'is_published' => true,
                'user_id' => $user->id,
                'category_id' => Category::where('slug', 'laravel')->first()->id,
            ],
            [
                'title' => 'Building Admin Panels with Filament',
                'slug' => 'building-admin-panels-with-filament',
                'content' => '<h2>Why Choose Filament?</h2><p>Filament is a collection of beautiful full-stack components for Laravel that accelerates the development of admin interfaces.</p><h3>Key Features</h3><ul><li>Beautiful UI components</li><li>Form builder</li><li>Table builder</li><li>Rich widgets</li></ul><p>With Filament, you can create stunning admin panels in minutes rather than days.</p>',
                'excerpt' => 'Discover how Filament makes building beautiful admin panels for Laravel applications incredibly easy and fast.',
                'published_at' => now()->subDays(3),
                'is_published' => true,
                'user_id' => $user->id,
                'category_id' => Category::where('slug', 'web-development')->first()->id,
            ],
            [
                'title' => 'Modern JavaScript Frameworks Comparison',
                'slug' => 'modern-javascript-frameworks-comparison',
                'content' => '<h2>The JavaScript Ecosystem</h2><p>The JavaScript ecosystem is vast and constantly evolving. Let\'s compare the most popular frameworks.</p><h3>React</h3><p>React continues to dominate the frontend landscape with its component-based architecture.</p><h3>Vue.js</h3><p>Vue.js offers a gentler learning curve while maintaining powerful capabilities.</p><h3>Angular</h3><p>Angular provides a complete framework solution for enterprise applications.</p>',
                'excerpt' => 'A comprehensive comparison of React, Vue.js, and Angular to help you choose the right framework for your project.',
                'published_at' => now()->subDays(5),
                'is_published' => true,
                'user_id' => $user->id,
                'category_id' => Category::where('slug', 'javascript')->first()->id,
            ],
            [
                'title' => 'Future of Web Development',
                'slug' => 'future-of-web-development',
                'content' => '<h2>Looking Ahead</h2><p>The web development landscape is constantly evolving. Let\'s explore what the future holds.</p><h3>Emerging Technologies</h3><p>From WebAssembly to Progressive Web Apps, new technologies are reshaping how we build for the web.</p>',
                'excerpt' => 'Explore the upcoming trends and technologies that will shape the future of web development.',
                'published_at' => now()->addDays(1),
                'is_published' => false,
                'user_id' => $user->id,
                'category_id' => Category::where('slug', 'technology')->first()->id,
            ],
        ];

        foreach ($posts as $postData) {
            $post = Post::create($postData);

            // Attach random tags to posts
            $randomTags = Tag::inRandomOrder()->take(rand(2, 4))->pluck('id');
            $post->tags()->attach($randomTags);
        }

        // Create sample pages
        $pages = [
            [
                'title' => 'About Us',
                'slug' => 'about',
                'content' => '<h2>Welcome to Our Blog</h2><p>We are passionate developers sharing our knowledge and experiences with the community.</p><p>Our mission is to provide high-quality content that helps fellow developers grow and succeed in their careers.</p><h3>Our Team</h3><p>We have a diverse team of experts covering various aspects of web development, from backend to frontend, and everything in between.</p>',
                'is_published' => true,
            ],
            [
                'title' => 'Contact',
                'slug' => 'contact',
                'content' => '<h2>Get in Touch</h2><p>We\'d love to hear from you! Whether you have questions, suggestions, or just want to say hello, feel free to reach out.</p><h3>Email</h3><p>You can reach us at: <a href="mailto:hello@example.com">hello@example.com</a></p><h3>Social Media</h3><p>Follow us on our social media channels for the latest updates and behind-the-scenes content.</p>',
                'is_published' => true,
            ],
        ];

        foreach ($pages as $pageData) {
            Page::create($pageData);
        }

        // Create sample settings
        $settings = [
            'site_name' => 'Tech Blog',
            'site_description' => 'A modern blog about web development, built with Laravel and Filament',
            'posts_per_page' => 6,
            'layout_style' => 'top_navbar',
            'header_color' => '#f59e0b',
            'enable_comments' => true,
            'social_github' => 'https://github.com',
            'social_twitter' => 'https://twitter.com',
        ];

        foreach ($settings as $key => $value) {
            Setting::set($key, $value);
        }
    }
}
