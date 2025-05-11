<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_loads(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Welcome to our Blog');
    }

    public function test_about_page_loads(): void
    {
        $response = $this->get('/about');

        $response->assertStatus(200);
        $response->assertSee('About Us');
    }

    public function test_blog_page_loads(): void
    {
        $response = $this->get('/blog');

        $response->assertStatus(200);
        $response->assertSee('Blog');
    }

    public function test_blog_post_detail_page_loads(): void
    {
        // Create a test user
        $user = User::factory()->create();
        
        // Create a category
        $category = Category::create([
            'name' => 'Test Category',
            'slug' => 'test-category',
            'description' => 'A test category',
        ]);
        
        // Create a post
        $post = Post::create([
            'title' => 'Test Post',
            'slug' => 'test-post',
            'excerpt' => 'This is a test post',
            'content' => 'This is the content of the test post',
            'user_id' => $user->id,
            'category_id' => $category->id,
            'is_published' => true,
            'published_at' => now()->subDay(),
        ]);
        
        $response = $this->get('/blog/' . $post->slug);

        $response->assertStatus(200);
        $response->assertSee('Test Post');
    }
}