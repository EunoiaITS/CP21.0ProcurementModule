<!doctype html>
<html class="no-js" lang="en">
<head>
    <?= $this->element('head') ?>
</head>
<body>
<?= $this->element('header') ?>
<?= $this->element('menus') ?>
<div class="container">
    <?= $this->Flash->render() ?>
</div>
<?= $this->fetch('content') ?>
<?= $this->element('footer') ?>
</body>
</html>