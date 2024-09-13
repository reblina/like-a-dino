<?php
$id = $page->id();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $comment = htmlspecialchars($_POST['comment']);
    $username = htmlspecialchars($_POST['username']);
    $rating = isset($_POST['rating']) ? (int) $_POST['rating'] : 0;

    $commentID = Db::insert('comments', [
        'siteID' => $id,
        'comment' => $comment,
        'username' => $username
    ]);

    if ($commentID) {
        Db::insert('starReviews', [
            'commentID' => $commentID,
            'siteID' => $id,
            'rating' => $rating
        ]);
    }
}
?>
