<?php snippet('header') ?>

<article>
  <h1 class="h1">
    <a href="<?= $page->parent()->url() ?>">
      <?= $page->parent()->title() ?>
    </a>
    <?= $page->title() ?>
  </h1>

  <?= $photo ?>
  <?php snippet('process') ?>

  <div class="containercontainer">
    <div class="container">

      <div class="head">
        <h1>Hi there, we are happy to hear from you!</h1>
      </div>

      <form action="" method="post" >
        
        <div class="star-rating">
          <label class="star-users">Rate this picture</label>
          <span class="star" data-value="1">&#9733;</span>
          <span class="star" data-value="2">&#9733;</span>
          <span class="star" data-value="3">&#9733;</span>
          <span class="star" data-value="4">&#9733;</span>
          <span class="star" data-value="5">&#9733;</span>
          <input type="hidden" name="rating" id="rating" value="0" required/>
        </div>
      
        <input type="text" placeholder="Enter your name here" class="input-field" name="username" required>
        <textarea placeholder="Enter your comment..." class="input-field" name="comment" rows="4" required></textarea>

        <input type="submit" class="button" id="publish">
      </form>
      
      <div class="head">
        <h1>What others have commented:</h1>
      </div>

      <?php
            $id = $page->id();
            $averageQuery = Db::query('SELECT AVG(rating) as averageRating FROM starReviews WHERE siteID = :siteID AND rating > 0', [
              'siteID' => $id
            ]);

            $average = round(floatval($averageQuery->first()->averageRating), 2);
            
            if( $average > 0) {
              echo '<p class = "star-users">' . 'Users have rated this picture ' . $average . '/5' . '</p>';
            } else {
              echo '<p class = "star-users"> No ratings yet.. </p>';
            }
          ?>

      <?php
        $id = $page->id();
        $query = 'siteID LIKE "' . $id . '" ORDER BY created_at DESC';

        $comments = Db::select('comments', '*', $query);

        foreach ($comments as $comment) {
          echo '<div class="commentcontainer">';
          echo '<p>' . $comment->username() . '</p>';
          echo '<p class="display-date">' . 'Posted on ' . date_format(date_create($comment->created_at()), 'D jS \o\f M Y H:i') . '</p>';

          $starQuery = 'commentID LIKE "' . $comment->commentID() . '"';
          $starCount = floatval(Db::select('starReviews', '*', $starQuery)->first()->rating());
      
          if($starCount > 0){
            for($i = 0; $i < $starCount; $i++){
              echo '<span class="gold-star">&#9733;</span>';
            }
          }
          echo '<p class="comment-content">' . $comment->comment() . '</p>';
          
          echo '</div>';
        }
      ?>
      
    </div>
  </div>

  <script>
    <?php require_once("./assets/js/photo.js"); ?>
  </script>

</article>
<?php snippet('footer') ?>