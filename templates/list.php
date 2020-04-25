<!-- templates/list.php -->
<?php $title = 'CV Template' ?>

<?php ob_start() ?>

        <?php foreach ($posts as $post): ?>
		
		 <div class="w3-container">
          <h5 class="w3-opacity"><b><?= $post['title'] ?></b></h5>
          <h6 class="w3-text-teal"><i class="fa fa-calendar fa-fw w3-margin-right"></i><?= date("Y-m-d", strtotime($post['created_at'])) ?></h6>
          <p><?= $post['body'] ?></p>
          <hr>
         </div>

        <?php endforeach ?>

<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>
