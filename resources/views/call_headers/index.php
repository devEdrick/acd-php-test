<?php ob_start(); ?>
<h1>Calls</h1>

<a class="btn btn-primary mb-2" href="/calls/create">Create New Call</a>

<table class="table">
    <thead class="thead-light">
        <tr>
            <th>Call ID</th>
            <th>Date</th>
            <th>IT Person</th>
            <th>User Name</th>
            <th>Subject</th>
            <th>Total Time</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($callHeaders as $callHeader) : ?>
            <tr>
                <td><?= $callHeader['Callid'] ?></td>
                <td><?= $callHeader['Date'] ?></td>
                <td><?= $callHeader['ITPerson'] ?></td>
                <td><?= $callHeader['UserName'] ?></td>
                <td><?= $callHeader['Subject'] ?></td>
                <td><?= sprintf('%02d:%02d', $callHeader['Total_Hours'] ?? 0, $callHeader['Total_Minutes'] ?? 0) ?></td>
                <td><?= $callHeader['Status'] ?></td>
                <td>
                    <a href="/calls/<?= $callHeader['Callid'] ?>" class="btn btn-sm btn-info">View</a>
                    <a href="/calls/<?= $callHeader['Callid'] ?>/edit" class="btn btn-sm btn-warning">Edit</a>
                    <form action="/calls/<?= $callHeader['Callid'] ?>/delete" method="post" class="d-inline">
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>