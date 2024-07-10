<?php ob_start(); ?>
<h1>Call Header</h1>

<p><strong>Call ID:</strong> <?= $callHeader['Callid'] ?></p>
<p><strong>Date:</strong> <?= $callHeader['Date'] ?></p>
<p><strong>IT Person:</strong> <?= $callHeader['ITPerson'] ?></p>
<p><strong>Subject:</strong> <?= $callHeader['Subject'] ?></p>
<p><strong>Total Time:</strong> <?= sprintf('%02d:%02d', $callHeader['Total_Hours'] ?? 0, $callHeader['Total_Minutes'] ?? 0) ?></p>
<p><strong>Status:</strong> <?= $callHeader['Status'] ?></p>

<h2>Call Details</h2>
<a href="/calls/<?= $callHeader['Callid'] ?>/details/create" class="btn btn-primary mb-2">Add Call Detail</a>

<table class="table">
    <thead class="thead-light">
        <tr>
            <th>Date</th>
            <th>Details</th>
            <th>Hours</th>
            <th>Minutes</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($callDetails as $callDetail) : ?>
            <tr>
                <td><?= $callDetail['Date'] ?></td>
                <td><?= $callDetail['Details'] ?></td>
                <td><?= $callDetail['Hours'] ?></td>
                <td><?= $callDetail['Minutes'] ?></td>
                <td>
                    <a href="/calls/<?= $callHeader['Callid'] ?>/details/<?= $callDetail['DetailID'] ?>/edit" class="btn btn-sm btn-warning">Edit</a>
                    <form action="/calls/<?= $callHeader['Callid'] ?>/details/<?= $callDetail['DetailID'] ?>/delete" method="post" class="d-inline">
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