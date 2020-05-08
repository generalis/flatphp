<!-- templates/list.php -->
<?php $title = 'Public part. List of Posts' ?>

<?php ob_start() ?>

    <h1>Public part</h1>

    <h1>List of Posts</h1>
    <ul>
        <?php foreach ($posts as $post): ?>
        <li>
            <a href="/flatphp/show.php?id=<?= $post['id'] ?>">
                <?= $post['title'] ?>
            </a>
        </li>
        <?php endforeach ?>
    </ul>

    <?php require 'pagination_links.php' ?>

<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>
