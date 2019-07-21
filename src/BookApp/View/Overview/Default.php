<h1>Library</h1>
<?php if (isset($messages) && !empty($messages)) { ?>
    <div class="messages">
        <?php foreach ($messages as $message) { ?>
            <span class="<?php echo htmlspecialchars($message['type']); ?>"><?php echo htmlspecialchars($message['text']); ?></span><br />
        <?php } ?>
    </div>
<?php } ?>
<div class="filter">
    <form name="form-filter-books" action="/" method="post">
        <input type="text" name="name" maxlength="128" placeholder="Filter books by name ..."<?php if (isset($filters['name'])) { echo ' value="' . htmlspecialchars($filters['name']) . '"'; } ?> />
        <?php if (!empty($authors)) { ?>
            <select name="author" title="Filter by author">
                <option value="">All authors</option>
                <?php foreach ($authors as $author) { ?>
                    <option value="<?php echo htmlspecialchars($author['author']); ?>"<?php if ($author['author'] === $filters['author']) { echo ' selected'; } ?>><?php echo htmlspecialchars($author['author']); ?></option>
                <?php } ?>
            </select>
        <?php } ?>
        <?php if (!empty($years)) { ?>
            <select name="year" title="Filter by year">
                <option value="">All years</option>
                <?php foreach ($years as $year) { ?>
                    <option value="<?php echo htmlspecialchars($year['year']); ?>"<?php if ((int)$year['year'] === $filters['year']) { echo ' selected'; } ?>><?php echo htmlspecialchars($year['year']); ?></option>
                <?php } ?>
            </select>
        <?php } ?>
        <input type="submit" name="filter-books-submit" value="Filter" />
    </form>
</div>
<div class="table-links">
    <a href="/add-book">+ Add new book</a>
</div>
<table>
    <thead>
        <tr>
            <th>Book name</th>
            <th>Author</th>
            <th>Year</th>
            <th>Added</th>
            <th>ISBN</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($books as $book) { ?>
            <tr>
                <td><?php echo htmlspecialchars($book['name']); ?></td>
                <td><?php echo htmlspecialchars($book['author']); ?></td>
                <td><?php echo htmlspecialchars($book['year']); ?></td>
                <td><?php echo date('j.n.Y H:i:s', strtotime($book['added'])); ?></td>
                <td><?php echo htmlspecialchars($book['isbn']); ?></td>
                <td class="links">
                    <a href="/remove-book/?id=<?php echo $book['id']; ?>">Remove</a>
                </td>
            </tr>
        <?php } ?>
        <?php if (empty($books)) { ?>
            <tr>
                <td class="links" colspan="6">
                    No results were found
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
