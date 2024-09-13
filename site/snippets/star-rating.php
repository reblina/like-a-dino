<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = $_POST['username'];
  $comment = $_POST['comment'];
  $rating = intval($_POST['rating']);
  
  $data = [
    'commentID' => $commentID,
    'rating' => $rating,
    'siteID' => $page->id()
  ];
  
  Db::insert('starReviews', $data);
}

?>