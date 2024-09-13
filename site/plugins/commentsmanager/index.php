<?php

Kirby::plugin('blina/commentsmanager', [
    'routes' => [
        [
            'pattern' => 'panel/pages/photography+(:any)/files/(:any)/(:any)',
            'GET'     => 'GET',
            'action'  => function () {
                $page = $this->model();
                $id = $page->id();
                $query = 'siteID LIKE "' . $id . '"';

                $comments = Db::select('comments', '*', $query);
                return [
                    'component' => 'k-comments-view',
                    'props' => [
                        'comments' => $comments
                    ]
                ];
            }
        ],
        [
            'pattern' => 'comment/delete/(:any)',
            'method'  => 'DELETE',
            'action'  => function ($commentId = null) {
                if ($commentId === null) {
                    echo '<p>No ID provided...</p>';
                    exit();
                }
                Db::delete('comments', ['commentID' => (int)$commentId]);
                return ['status' => 'success', 'commentID' => $commentId];
            }
        ]
    ],
    'fields' => [
        'commentsmanager' => [
            'props' => [
                'value' => function($value = null) {

                    $page = $this->model();
                    $url = $page->url();
                    $parsedUrl = parse_url($url);
                    
                    $pathParts = explode('/', trim($parsedUrl['path'], '/'));
                
                    $siteID = $pathParts[2] . '/' . $pathParts[3] . '/' . $pathParts[5]; 
                    
                    $query = 'siteID LIKE "' . $siteID . '"';

                    $comments = Db::select('comments', '*', $query);
                    
                    if(count($comments) === 0) {
                        return [];
                    }

                    foreach ($comments as $comment) {
                        $data[] = [
                            'commentID' => $comment->commentID(),
                            'username' => $comment->username(),
                            'comment'  => $comment->comment()
                        ];
                    }
                    
                    return $data;
                },
                'average' => function($average = null){
                    
                    $page = $this->model();
                    $id = $page->id();
                    
                    $averageQuery = Db::query('SELECT AVG(rating) as averageRating FROM starReviews WHERE siteID = :siteID AND rating > 0', [
                        'siteID' => $id
                    ]);

                    $average = round(floatval($averageQuery->first()->averageRating), 2);

                    return $average;
                }
            ]
        ]
    ]
])

?>