<?php
/**
 * Règle de saint Benoît
 *
 * Process rule entries
 *
 * @author    Michel Corne <mcorne@yahoo.com>
 * @copyright 2014 Michel Corne
 * @license   http://www.opensource.org/licenses/gpl-3.0.html GNU GPL v3
 * @link      http://regle-de-saint-benoit.blogspot.fr/
 */

require_once 'Zend/Gdata.php';
require_once 'Zend/Gdata/ClientLogin.php';
require_once 'Zend/Gdata/Query.php';

class Blog
{
    protected $_client;
    protected $_blogId;
    protected $_feeds = array();

    public function __construct($user = null, $password = null, $title = null)
    {
        if ($user and $password) {
            $this->getClient($user, $password);

            if ($title) {
                $this->getBlogId($title);
            }
        }
    }

    public function createPost($title, $content)
    {
        $uri = 'http://www.blogger.com/feeds/' . $this->_blogId . '/posts/default';

        $entry = $this->_client->newEntry();
        $entry->title = $this->_client->newTitle($title);
        $entry->content = $this->_client->newContent($content);
        $entry->content->setType('text');

        $post = $this->_client->insertEntry($entry, $uri);
        list(,, $postId) = explode('-', $post->id->text);

        return $postId;
    }

    public function getBlogId($title)
    {
        $uri = 'http://www.blogger.com/feeds/default/blogs';

        if (! $this->_blogId = $this->getFeedEntry($uri, $title)) {
            throw new Exception('invalid blog');
        }
    }

    public function getClient($user, $password)
    {
        $client = Zend_Gdata_ClientLogin::getHttpClient(
            $user, $password, 'blogger', null,
            Zend_Gdata_ClientLogin::DEFAULT_SOURCE, null, null,
            Zend_Gdata_ClientLogin::CLIENTLOGIN_URI, 'GOOGLE');

        $this->_client = new Zend_Gdata($client);
    }

    public function getFeedEntry($uri, $title)
    {
        if (!isset($this->_feeds[$uri])) {
            $query = new Zend_Gdata_Query($uri);
            $query->setMaxResults(100);
            $this->_feeds[$uri] = $this->_client->getFeed($query);
        }

        $b = $this->_feeds[$uri]->entries;
        foreach($this->_feeds[$uri]->entries as $entry) {
            $a= $entry->getAlternateLink()->href;
            if ($entry->getTitleValue() == $title or strpos($entry->getAlternateLink()->href, $title) !== false) {
                $idText = explode('-', $entry->id->text);

                return $idText[2];
            }
        }

        return null;
    }

    public function getPostId($title)
    {
        $uri = 'http://www.blogger.com/feeds/' . $this->_blogId . '/posts/default';

        return $this->getFeedEntry($uri, $title);
    }

    public function updatePost($title, $content, $postId)
    {
        $uri = 'http://www.blogger.com/feeds/' . $this->_blogId . '/posts/default/' . $postId;
        $query = new Zend_Gdata_Query($uri);
        $entry = $this->_client->getEntry($query);
        $entry->content->text = $this->_client->newContent($content);

        $control = $this->_client->newControl();
        $draft = $this->_client->newDraft('no');
        $control->setDraft($draft);
        $entry->control = $control;

        $post = $entry->save();

        return $postId;
    }

    public function savePost($title, $content)
    {
        if ($postId = $this->getPostId($title)) {
            $this->updatePost($title, $content, $postId);
        } else {
            $postId = $this->createPost($title, $content);
        }

        return $postId;
    }
}
