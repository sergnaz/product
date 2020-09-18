0. add to /etc/hosts:
    127.0.0.1 product.dev
1. docker-compose up -d
2. ./vendor/bin/phpunit tests
3. http://product.dev/ or curl -i http://product.dev/ ;echo
    {
            'model' : 'ThinkPad E495',
            'type' : 'notebook',
            'manufacturer' : 'Lenovo',
            'description' : 'This notebook is the best what you can buy for a reasonable price'
            'photos' : [
                'http:\\product\1\photo\101',
                'http:\\product\1\photo\102',
                'http:\\product\1\photo\103',
            ],
            'videos' : [
                'http:\\product\1\video\201',
                'http:\\product\1\video\202',
            ]
        }

Scenarios
=====================
Given an authorized user
When the customer sends a request like GET http://product.dev/1/json
Then the customer receives an product's info in json format like:
    {
        'model' : 'ThinkPad E495',
        'type' : 'notebook',
        'manufacturer' : 'Lenovo',
        'description' : 'This notebook is the best what you can buy for a reasonable price'
        'photos' : [
            'http:\\product\1\photo\101',
            'http:\\product\1\photo\102',
            'http:\\product\1\photo\103',
        ],
        'videos' : [
            'http:\\product\1\video\201',
            'http:\\product\1\video\202',
        ]
    }
    
Given an authorized user
When the customer sends a request like GET http://product.dev/1/xml
Then the customer receives an product's info in json format like:
    <?xml version="1.0"?>
    <product>
        <model>ThinkPad E495</model>
        <type>notebook</type>
        <manufacturer>Lenovo</manufacturer>
        <description>This notebook is the best what you can buy for a reasonable price</description>
        <photos>
            <photo>http:\\product\1\photo\101</photo>
            <photo>http:\\product\1\photo\102</photo>
            <photo>http:\\product\1\photo\103</photo>
        </photos>
        <videos>
            <video>http:\\product\1\video\201</video>
            <video>http:\\product\1\video\202</video>
        </videos>
    </product>
    
Given non authorized user
When the user tries to send a request GET http://product.dev/1/xml
Then the user receives a result with 400 status and no data