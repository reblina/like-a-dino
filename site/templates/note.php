<?php
/*
  Templates render the content of your pages.

  They contain the markup together with some control structures
  like loops or if-statements. The `$page` variable always
  refers to the currently active page.

  To fetch the content from each field we call the field name as a
  method on the `$page` object, e.g. `$page->title()`.

  This note template renders a blog article. It uses the `$page->cover()`
  method from the `note.php` page model (/site/models/page.php)

  It also receives the `$tag` variable from its controller
  (/site/controllers/note.php) if a tag filter is activated.

  Snippets like the header and footer contain markup used in
  multiple templates. They also help to keep templates clean.

  More about templates: https://getkirby.com/docs/guide/templates/basics
*/
?>
<?php snippet('header') ?>

<?php if ($cover = $page->cover()): ?>
<a href="<?= $cover->url() ?>" data-lightbox class="img" style="--w:2; --h:1">
  <img src="<?= $cover->crop(1200, 600)->url() ?>" alt="<?= $cover->alt()->esc() ?>">
</a>
<?php endif ?>

<article class="note">
  <header class="note-header h1">
    <h1 class="note-title"><?= $page->title()->esc() ?></h1>
    <?php if ($page->subheading()->isNotEmpty()): ?>
    <p class="note-subheading"><small><?= $page->subheading()->esc() ?></small></p>
    <?php endif ?>
  </header>
  <div class="note text">
    <?= $page->text()->toBlocks() ?>
  </div>
  <footer class="note-footer">
    <?php if (!empty($tags)): ?>
    <ul class="note-tags">
      <?php foreach ($tags as $tag): ?>
      <li>
        <a href="<?= $page->parent()->url() . '/tag/' . $tag ?>"><?= esc($tag) ?></a>
      </li>
      <?php endforeach ?>
    </ul>
    <?php endif ?>

    <time class="note-date" datetime="<?= $page->date()->toDate('c') ?>">Published on <?= $page->date()->esc() ?></time>
  </footer>

  <?php snippet('prevnext') ?>
</article>

<?php snippet('footer') ?>
