<?php ob_start(); ?>
<h1>Edit Call</h1>

<form action="/calls/<?= $callHeader['Callid'] ?>/update" method="post">
    <div class="form-group">
        <label for="date">Date:</label>
        <input type="datetime-local" id="date" name="date" class="form-control" value="<?= $callHeader['Date'] ?>" required>
    </div>

    <div class="form-group">
        <label for="it_person">IT Person:</label>
        <input type="text" id="it_person" name="it_person" class="form-control" value="<?= $callHeader['ITPerson'] ?>">
    </div>

    <div class="form-group">
        <label for="username">User Name:</label>
        <input type="text" id="username" name="username" class="form-control" value="<?= $callHeader['UserName'] ?>">
    </div>

    <div class="form-group">
        <label for="subject">Subject:</label>
        <input type="text" id="subject" name="subject" class="form-control" value="<?= $callHeader['Subject'] ?>">
    </div>

    <div class="form-group">
        <label for="details">Details:</label>
        <textarea id="details" name="details" class="form-control" rows="4"><?= $callHeader['Details'] ?></textarea>
    </div>

    <div class="form-group">
        <label for="status">Status:</label>
        <select id="status" name="status" class="form-control" required>
            <option value="New" <?= $callHeader['Status'] === 'New' ? 'selected' : '' ?>>New</option>
            <option value="In Progress" <?= $callHeader['Status'] === 'In Progress' ? 'selected' : '' ?>>In Progress</option>
            <option value="Completed" <?= $callHeader['Status'] === 'Completed' ? 'selected' : '' ?>>Completed</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Update Call</button>
</form>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>