<?php $errors = array(); ?>
<?php if (count($errors) > 0) : ?>
    <div class="error">
        <?php foreach ($errors as $error) : ?>
            <E><?php echo $error ?></E>
        <?php endforeach ?>
    </div>
<?php endif ?>