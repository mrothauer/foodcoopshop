<?php
/**
 *
 * FoodCoopShop - The open source software for your foodcoop
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @since         FoodCoopShop 1.5.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 * @author        Mario Rothauer <office@foodcoopshop.com>
 * @copyright     Copyright (c) Mario Rothauer, https://www.rothauer-it.com
 * @link          https://www.foodcoopshop.com
 */
use App\Test\TestCase\AppCakeTestCase;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;

class BlogPostsControllerTest extends AppCakeTestCase
{

    public $BlogPost;

    public function setUp()
    {
        parent::setUp();
        $this->BlogPost = TableRegistry::getTableLocator()->get('BlogPosts');
    }

    public function testBlogPostDetailOnlinePublicLoggedOut()
    {
        $this->browser->get($this->Slug->getBlogPostDetail(2, 'Demo Blog Artikel'));
        $this->assert200OkHeader();
    }

    public function testBlogPostDetailOfflinePublicLoggedOut()
    {
        $blogPostId = 2;
        $this->changeBlogPost($blogPostId, 0, 0, 0);
        $this->browser->get($this->Slug->getBlogPostDetail($blogPostId, 'Demo Blog Artikel'));
        $this->assert404NotFoundHeader();
    }

    public function testBlogPostDetailOnlinePrivateLoggedOut()
    {
        $blogPostId = 2;
        $this->changeBlogPost($blogPostId, 1);
        $this->browser->get($this->Slug->getBlogPostDetail($blogPostId, 'Demo Blog Artikel'));
        $this->assertAccessDeniedWithRedirectToLoginForm();
    }

    public function testBlogPostDetailOnlinePrivateLoggedIn()
    {
        $this->loginAsCustomer();
        $blogPostId = 2;
        $this->changeBlogPost($blogPostId, 1);
        $this->browser->get($this->Slug->getBlogPostDetail($blogPostId, 'Demo Blog Artikel'));
        $this->assert200OkHeader();
    }

    public function testBlogPostDetaiNonExistingLoggedOut()
    {
        $blogPostId = 3;
        $this->browser->get($this->Slug->getBlogPostDetail($blogPostId, 'Demo Blog Artikel'));
        $this->assert404NotFoundHeader();
    }

    public function testBlogPostDetailOnlinePublicManufacturerPrivateLoggedOut()
    {
        $blogPostId = 2;
        $manufacturerId = 15;
        $this->changeBlogPost($blogPostId, 0, $manufacturerId);
        $this->changeManufacturer($manufacturerId, 'is_private', 1);
        $this->browser->get($this->Slug->getBlogPostDetail($blogPostId, 'Demo Blog Artikel'));
        $this->assertAccessDeniedWithRedirectToLoginForm();
    }

    public function testSendBlogPostAsSuperadmin()
    {
        $this->loginAsSuperadmin();
        $this->browser->get('/admin/blog-posts/sendBlogPost/2');

        $this->EmailLog = TableRegistry::getTableLocator()->get('EmailLogs');
        $emailLogs = $this->EmailLog->find('all')->toArray();
        $this->assertEmailLogs(
            $emailLogs[0],
            'Neuer Blog-Artikel',
            [],
            [Cake\Core\Configure::read('appDb.FCS_APP_EMAIL')],
            [],
            [
                Configure::read('test.loginEmailCustomer') ,
                Configure::read('test.loginEmailAdmin'),
                Configure::read('test.loginEmailSuperadmin')
            ]
        );
    }

    public function testSendBlogPostAsManufacturer() {
        $this->loginAsMeatManufacturer();
        $this->browser->get('/admin/blog-posts/sendBlogPost/2');
        $this->assertAccessDeniedWithRedirectToLoginForm();
    }

    protected function changeBlogPost($blogPostId, $isPrivate = 0, $manufacturerId = 0, $active = 1)
    {
        $query = 'UPDATE ' . $this->BlogPost->getTable() . ' SET is_private = :isPrivate, id_manufacturer = :manufacturerId, active = :active WHERE id_blog_post = :blogPostId;';
        $params = [
            'blogPostId' => $blogPostId,
            'isPrivate' => $isPrivate,
            'manufacturerId' => $manufacturerId,
            'active' => $active
        ];
        $statement = $this->dbConnection->prepare($query);
        $statement->execute($params);
    }
}
