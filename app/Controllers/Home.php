<?php

namespace App\Controllers;

use Config\Site;

class Home extends BaseController
{
    protected $siteConfig;

    public function __construct()
    {
        $this->siteConfig = new Site();
    }

    public function index()
    {
        // Define the constant if not already defined
        if (!defined('LABEL_ALL_CITIES')) {
            define('LABEL_ALL_CITIES', 'All Cities');
        }

        // Get URI segments using CI4 syntax with default values
        $uri = service('uri');
        $segments = $uri->getSegments();
        
        $firstsegment = isset($segments[0]) ? $segments[0] : '';
        $secondsegment = isset($segments[1]) ? $segments[1] : '';

        // Sample banner data (replace with actual data from your database)
        $topBannerList = [
            [
                'title' => 'Banner 1',
                'bannerImage' => $this->siteConfig->images_content_path . 'banner1.jpg',
                'url' => 'https://example.com/banner1',
                'target' => '_self'
            ],
            [
                'title' => 'Banner 2',
                'bannerImage' => $this->siteConfig->images_content_path . 'banner2.jpg',
                'url' => 'https://example.com/banner2',
                'target' => '_self'
            ]
        ];

        // Sample events list data (replace with actual data from your database)
        $eventsList = [
            'eventList' => [
                [
                    'id' => 1,
                    'title' => 'Sample Event 1',
                    'description' => 'Event description 1',
                    'image' => $this->siteConfig->images_content_path . 'event1.jpg',
                    'date' => '2024-01-01',
                    'location' => 'Bengaluru',
                    'category' => 'Professional'
                ],
                [
                    'id' => 2,
                    'title' => 'Sample Event 2',
                    'description' => 'Event description 2',
                    'image' => $this->siteConfig->images_content_path . 'event2.jpg',
                    'date' => '2024-01-02',
                    'location' => 'Mumbai',
                    'category' => 'Entertainment'
                ]
            ],
            'totalCount' => 2
        ];

        // Prepare view data with all necessary configuration
        $viewData = [
            // City and Country defaults
            'defaultCityName' => $this->siteConfig->defaultCityName,
            'defaultCountryName' => $this->siteConfig->defaultCountryName,
            'firstsegment' => $firstsegment,
            'secondsegment' => $secondsegment,

            // Static paths (using the CDN paths from Site config)
            'images_static_path' => $this->siteConfig->images_static_path,
            'css_public_path' => $this->siteConfig->css_public_path,
            'js_public_path' => $this->siteConfig->js_public_path,
            'images_content_path' => $this->siteConfig->images_content_path,
            'images_cloud_path' => $this->siteConfig->images_cloud_path,

            // Category defaults
            'defaultCategory' => 'All Categories',
            'defaultCategoryId' => 0,
            'defaultCustomFilterName' => 'Anytime',
            'defaultCustomFilterId' => 0,

            // Lists for filters (these should be populated from your data source)
            'cityList' => [],  // Populate from your city model/service
            'categoryList' => [], // Populate from your category model/service
            'customFilterList' => [
                ['id' => 1, 'name' => 'Today'],
                ['id' => 2, 'name' => 'Tomorrow'],
                ['id' => 3, 'name' => 'This Weekend'],
                ['id' => 4, 'name' => 'This Week'],
                ['id' => 5, 'name' => 'Next Week'],
                ['id' => 6, 'name' => 'This Month']
            ],

            // Banner data
            'topBannerList' => $topBannerList,

            // Events list data
            'eventsList' => $eventsList,
            
            // Pagination variables
            'page' => 1, // Default to first page
            'limit' => 12 // Default limit per page
        ];

        return view('home_view', $viewData);
    }

    public function search()
    {
        return $this->index();
    }
}
