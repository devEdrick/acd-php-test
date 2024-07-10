<?php ob_start(); ?>
<h1>Create New Call</h1>

<form action="/calls/store" method="post">
    <div class="form-group">
        <label for="date">Date:</label>
        <input type="datetime-local" id="date" name="date" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="it_person">IT Person:</label>
        <input type="text" id="it_person" name="it_person" class="form-control">
    </div>

    <div class="form-group">
        <label for="username">User Name:</label>
        <input type="text" id="username" name="username" class="form-control">
    </div>

    <div class="form-group">
        <label for="subject">Subject:</label>
        <input type="text" id="subject" name="subject" class="form-control">
    </div>

    <div class="form-group">
        <label for="details">Details:</label>
        <textarea id="details" name="details" class="form-control" rows="4"></textarea>
    </div>

    <div class="form-group">
        <label for="status">Status:</label>
        <select id="status" name="status" class="form-control" required>
            <option value="New">New</option>
            <option value="In Progress">In Progress</option>
            <option value="Completed">Completed</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Create Call</button>
</form>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>