<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once(APPPATH . 'handlers/blog_handler.php');

class Blog extends CI_Controller
{

    var $blogHandler;

    public function __construct()
    {
        parent::__construct();
        $this->blogHandler = new blog_handler();
    }

    public function index()
    {
        $template = 'templates/blog_template';
        $data['content'] = 'blog/blog-index';

        if ($this->input->get()) {
            $inputArray = $this->input->get();
            $searchblog = $this->blogHandler->searchBlog($inputArray);
            if (count($searchblog) > 0) {
                redirect(site_url() . 'blog/' . $searchblog[0]['slug']);
            } else {
                redirect(site_url() . 'blog');
            }
        }

        $input['key'] = 'AIzaSyAPtUBOud52mhCzOPp1TS9jbJMMJ4SDN0I';
        $input['channelId'] = 'UCHdIYvSeiLCaElFFINPKAMg';
        $input['maxResults'] = 6;
        $input['part'] = 'snippet' . ',' . 'id';
        $input['order'] = 'date';
        $url = "https://www.googleapis.com/youtube/v3/search?" . http_build_query($input, 'a', '&');

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $json_response = curl_exec($curl);
        curl_close($curl);
        $latestVideos = json_decode($json_response, true);
        
        $home_meta = $this->db->select('meta_title, meta_description, meta_keywords')->from('blog_meta_contents')->where('id', 1)->limit(1)->get()->result_array();

        $blogData = $this->blogHandler->allArticles();
        $popularArticles = $this->blogHandler->getPopularArticles();
        $data['latestVideos'] = $latestVideos;
        $data['blog_categories'] = $blogData['blog_categories'];
        $data['articles'] = $blogData['blog_articles'];
        $data['category_articles'] = $blogData['category_articles'];
        $data['popuplar_articles'] = $popularArticles['popular_articles'];
        $data['blog_meta_title'] = !empty($home_meta[0]['meta_title']) ? $home_meta[0]['meta_title'] : 'MeraEvents Blog';
        $data['blog_meta_description'] = !empty($home_meta[0]['meta_description']) ? $home_meta[0]['meta_description'] : 'MeraEvents Blog';
        $data['blog_meta_keywords'] = !empty($home_meta[0]['meta_keywords']) ? $home_meta[0]['meta_keywords'] : 'MeraEvents Blog';
        $this->load->view($template, $data);
    }

    public function details($slug)
    {
        $data['pageTitle'] = 'MeraEvents | Article Details';
        $template = 'templates/blog_template';
        $data['content'] = 'blog/blog-details';

        if ($this->input->get()) {
            $inputArray = $this->input->get();
            $searchblog = $this->blogHandler->searchBlog($inputArray);
            if (count($searchblog) > 0) {
                redirect(site_url() . 'blog/' . $searchblog[0]['slug']);
            } else {
                redirect(site_url() . 'blog');
            }
        }

        $articles = $this->blogHandler->articleDetails($slug);
        $categorieslist = $this->blogHandler->getBlogCategories();
        $blogData = $this->blogHandler->allArticles();

        $popularArticles = $this->blogHandler->getPopularArticles();

        $getcomments = $this->blogHandler->getarticleComments($articles['articles_data'][0]['id']);
        $data['popuplar_articles'] = $popularArticles['popular_articles'];
        $data['comments'] = $getcomments;
        $data['nArticles'] = $articles['relatedposts'];
        $data['categoriesList'] = $articles['relatedCategories'];
        $data['categories'] = $categorieslist;
        $data['blog_categories'] = $blogData['blog_categories'];
        $data['articles'] = $blogData['blog_articles'];
        $data['article_details'] = $articles['articles_data'][0];
        $data['blog_meta_title'] = !empty($articles['articles_data'][0]['metatitle']) ? $articles['articles_data'][0]['metatitle'] : (!empty($articles['articles_data'][0]['title']) ? $articles['articles_data'][0]['title'] : 'MeraEvents Blog');
        $data['blog_meta_description'] = !empty($articles['articles_data'][0]['metadescription']) ? $articles['articles_data'][0]['metadescription'] : 'MeraEvents Blog';
        $data['blog_meta_keywords'] = !empty($articles['articles_data'][0]['metakeywords']) ? $articles['articles_data'][0]['metakeywords'] : 'MeraEvents Blog';
        $this->load->view($template, $data);
    }

    public function category($slug)
    {
        $template = 'templates/blog_template';
        $data['content'] = 'blog/blog-category';

        if ($this->input->get()) {
            $inputArray = $this->input->get();
            $searchblog = $this->blogHandler->searchBlog($inputArray);
            if (count($searchblog) > 0) {
                redirect(site_url() . 'blog/' . $searchblog[0]['slug']);
            } else {
                redirect(site_url() . 'blog');
            }
        }

        $cat_articles = $this->blogHandler->getCategoryArticles($slug);
        $popularArticles = $this->blogHandler->getPopularArticles();
        $categorieslist = $this->blogHandler->getBlogCategories();
        $data['popuplar_articles'] = $popularArticles['popular_articles'];
        $data['articles']['blog_articles'] = $cat_articles['category-articles'];
        $data['articles']['category_name'] = $cat_articles['category_name'];
        $data['categories'] = $categorieslist;
        $data['article_details'] = $articles['articles_data'][0];
        $data['blog_meta_title'] = !empty($cat_articles['category_name']) ? $cat_articles['category_name'] : 'MeraEvents Blog';
        $data['blog_meta_description'] = !empty($cat_articles['category_metadescription']) ? $cat_articles['category_metadescription'] : 'MeraEvents Blog';
        $data['blog_meta_keywords'] = !empty($cat_articles['category_metakeywords']) ? $cat_articles['category_metakeywords'] : 'MeraEvents Blog';
        $this->load->view($template, $data);
    }

    public function savecomments()
    {
        $inputArray = $this->input->post();
        $comments = $this->blogHandler->savecomments($inputArray);
        echo $comments['status'];
        exit;
    }

}

?>