<h3><?php echo __('Login'); ?></h3>

<?php $i = 0; ?>

<?php foreach ($services_view AS $val): ?>
    <?php if ($i): ?>
        <hr />
    <?php endif; ?>
    <?php $i++; ?>
    <?php if (count($services_view) > 1): ?>
        <h4><?php echo $val['name']; ?></h4>
    <?php endif; ?>
    <?php if (isset($val['description'])): ?>
        <p>
            <?php echo $val['description']; ?>
        </p>
    <?php endif; ?>
    <?php echo View::factory($val['login_view']); ?>
<?php endforeach; ?>