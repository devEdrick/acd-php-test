<?php ob_start(); ?>
<h1>Create New Call Detail</h1>

<?php if (isset($error)) : ?>
    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<form action="/calls/<?= $callHeader['Callid'] ?>/details/store" method="post">
    <div class="form-group">
        <label for="date">Date:</label>
        <input type="datetime-local" id="date" name="date" class="form-control" value="<?= $callDetail['Date'] ?? '' ?>" required>
    </div>

    <div class="form-group">
        <label for="details">Details:</label>
        <textarea id="details" name="details" class="form-control" rows="4"><?= $callDetail['Details'] ?? '' ?></textarea>
    </div>

    <div class="form-group">
        <label for="hours">Hours:</label>
        <input type="number" id="hours" name="hours" class="form-control" min="0" max="24" value="<?= $callDetail['Hours'] ?? '' ?>" required>
    </div>

    <div class="form-group">
        <label for="minutes">Minutes:</label>
        <input type="number" id="minutes" name="minutes" class="form-control" min="0" max="59" value="<?= $callDetail['Minutes'] ?? '' ?>" required>
    </div>

    <button type="submit" class="btn btn-primary">Create Detail</button>
</form>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>