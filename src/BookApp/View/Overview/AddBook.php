<h1>Add new book</h1>
<div class="form-links">
    <a href="/">&lt; Back to library</a>
</div>
<?php if (isset($errors) && !empty($errors)) { ?>
    <div class="errors">
        <?php foreach ($errors as $error) { ?>
            <span class="error"><?php echo htmlspecialchars($error); ?></span><br />
        <?php } ?>
    </div>
<?php } ?>
<form name="form-add-book" action="/add-book" method="post">
    <input type="text" name="name" maxlength="128" placeholder="Book name *"<?php if (isset($name)) { echo ' value="' . htmlspecialchars($name) . '"'; } ?> />
    <br />
    <input type="text" name="author" maxlength="64" placeholder="Name of the author *"<?php if (isset($author)) { echo ' value="' . htmlspecialchars($author) . '"'; } ?> />
    <br />
    <input type="text" name="year" maxlength="4" placeholder="Year *"<?php if (isset($year)) { echo ' value="' . htmlspecialchars($year) . '"'; } ?> />
    <br />
    <input type="text" name="isbn" placeholder="ISBN"<?php if (isset($isbn)) { echo ' value="' . htmlspecialchars($isbn) . '"'; } ?> />
    <br />
    <input type="submit" name="add-book-submit" value="Add book" />
</form>
<div class="warning">
    Fields marked with an * are required!
</div>
