<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
</head>

<body>

    <?= $this->include('components/header') ?>

    <?= $this->include('components/sidebar') ?>

    <?= $this->renderSection('content') ?>

    <?= $this->include('components/footer') ?>

</body>

</html>