<?php
/*
  Templates render the content of your pages.

  They contain the markup together with some control structures
  like loops or if-statements. The `$page` variable always
  refers to the currently active page.

  To fetch the content from each field we call the field name as a
  method on the `$page` object, e.g. `$page->title()`.

  This default template must not be removed. It is used whenever Kirby
  cannot find a template with the name of the content file.

  Snippets like the header and footer contain markup used in
  multiple templates. They also help to keep templates clean.

  More about templates: https://getkirby.com/docs/guide/templates/basics
*/
?>
<?php snippet('header') ?>

<article>
  <h1 class="h1"><?= $page->title()->esc() ?></h1>
  <h1 class="h1"><?= $page->intro()->esc() ?></h1>
  <div class="text">
    <?= $page->text()->kt() ?>
  </div>

  <?php if ($page->year()->isNotEmpty()): ?>
    <h1>Year</h1>
    <dd><?= $page->year() ?></dd>
  <?php endif?>

  <?php if ($page->category()->isNotEmpty()): ?>
    <h1>Category</h1>
    <dd><?= $page->category() ?></dd>
  <?php endif?>

  <?php if ($page->tags()->isNotEmpty()): ?>
    <h1>Tags</h1>
    <dd><?= $page->tags() ?></dd>
  <?php endif?>

  <?php $location = $page->mymap()->toLocation();?>

  <?php if ($location->has('lat')): ?>
    <?php if ($location->lat()->isNotEmpty()): ?>
      <h1>Location</h1>
      <dd><?= $page->mymap() ?></dd>
    <?php endif?>
  <?php endif?>

</article>

<?php snippet('footer') ?>
