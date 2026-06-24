<?php
/**
 * Integration tests for the testimonial submission AJAX handler.
 *
 * @package Sculpture_Theme
 */

class TestimonialAjaxTest extends WP_Ajax_UnitTestCase
{
    public function set_up(): void
    {
        parent::set_up();
        $_POST = [];
    }

    /**
     * Dispatch the handler and return the decoded JSON response.
     *
     * @return array<string, mixed>
     */
    private function dispatch(): array
    {
        try {
            $this->_handleAjax('submit_testimonial');
        } catch (WPAjaxDieContinueException $e) {
            // Expected: wp_send_json_*() ends the request.
        }

        return json_decode($this->_last_response, true);
    }

    public function test_rejects_invalid_nonce(): void
    {
        $_POST['testimonial_nonce'] = 'not-a-real-nonce';

        $response = $this->dispatch();

        $this->assertFalse($response['success']);
        $this->assertArrayHasKey('message', $response['data']);
    }

    public function test_rejects_when_required_fields_missing(): void
    {
        $_POST['testimonial_nonce'] = wp_create_nonce('submit_testimonial');
        // No name / email / rating / message provided.

        $response = $this->dispatch();

        $this->assertFalse($response['success']);

        $no_posts = get_posts(['post_type' => 'testimonial', 'post_status' => 'any', 'numberposts' => -1]);
        $this->assertCount(0, $no_posts, 'No testimonial should be created on validation failure.');
    }

    public function test_rejects_invalid_email(): void
    {
        $_POST['testimonial_nonce'] = wp_create_nonce('submit_testimonial');
        $_POST['client_name']       = 'Jane Doe';
        $_POST['client_email']      = 'not-an-email';
        $_POST['rating']            = '5';
        $_POST['message']           = 'Lovely work.';

        $response = $this->dispatch();

        $this->assertFalse($response['success']);
    }

    public function test_creates_pending_testimonial_on_valid_submission(): void
    {
        $admin = self::factory()->user->create(['role' => 'administrator']);
        wp_set_current_user($admin);

        $_POST['testimonial_nonce'] = wp_create_nonce('submit_testimonial');
        $_POST['client_name']       = 'Jane Doe';
        $_POST['client_email']      = 'jane@example.com';
        $_POST['client_company']    = 'Acme Galleries';
        $_POST['rating']            = '4';
        $_POST['message']           = 'Wonderful sculpture, highly recommended.';
        $_POST['show_rating']       = '1';

        $response = $this->dispatch();

        $this->assertTrue($response['success']);

        $posts = get_posts([
            'post_type'   => 'testimonial',
            'post_status' => 'pending',
            'numberposts' => -1,
        ]);

        $this->assertCount(1, $posts);
        $this->assertSame('Jane Doe', $posts[0]->post_title);
        $this->assertSame('pending', $posts[0]->post_status);
        $this->assertEquals(4, get_post_meta($posts[0]->ID, 'rating', true));
        $this->assertEquals('jane@example.com', get_post_meta($posts[0]->ID, 'client_email', true));
    }
}
