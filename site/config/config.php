<?php

/**
 * The config file is optional. It accepts a return array with config options
 * Note: Never include more than one return statement, all options go within this single return array
 * In this example, we set debugging to true, so that errors are displayed onscreen. 
 * This setting must be set to false in production.
 * All config options: https://getkirby.com/docs/reference/system/options
 */
return [
    'debug' => true,

    'db' => [
        'host'     => 'ddev-like-a-dino-db',
        'database' => 'db',
        'user'     => 'root',
        'password' => 'root',
    ],
    'hooks' => [
    'page.create:after' => function ($page) {
        $customID = uniqid(); // Generate a unique ID
        $page->update([
        'customID' => $customID
        ]);
    }
    ],
    'routes' => [
        [
            'pattern' => '/blog/(:any)',
            'action' => function(string $articleSlug){
                go('notes/' . $articleSlug);
            }
        ],
        [
            'pattern' => 'notes/tag/(:any)',
            'action' => function(string $tag){
                return page('notes')->render([
                    'tag' => $tag
                ]);
            }
        ],
        [
            'pattern' => 'notes/api',
            'action' => function(){
                return [
                    'count' => 17
                ];
            }
        ],
        [
            'pattern' => 'notes/(:any)/cover',
            'action' => function(string $articleSlug){
                return page('notes/' . $articleSlug)->image();
            }
        ],
        [
            'pattern' => 'photography/(:any)/photo/(:any)',
            'method' => 'GET|POST',
            'action' => function(string $albumSlug, string $filename){
                
                $album = page('photography/' . $albumSlug);

                if($album === null) {
                    return null;
                }

                $image = $album->image($filename);

                if($image === null) {
                    return null;
                }

                $page = new Page([
                    'slug' => $filename,
                    'parent' => $album,
                    'template' => 'photo',
                    'content' => [
                        'caption' => $image->caption(), 
                        'alt' => $image->alt(),     
                        'photographer' => $image->photographer(), 
                        'license' => $image->license(), 
                        'link' => $image->link()
                    ]
                ]);

                return $page->render([
                    'photo' => $image
                ]);
            }
        ],
    ]
];
