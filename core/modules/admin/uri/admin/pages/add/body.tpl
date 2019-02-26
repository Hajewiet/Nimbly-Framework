
<h1>Add page</h1>
<form class="nb-form">
    <label>URL:
        <input type="text" maxlength="64" name="url"
                placeholder="url" value="[sticky url]" required />
    </label>
    <label>Title:
        <input type="text" maxlength="64" name="title"
                placeholder="page title" value="[sticky title]" required />
    </label>
    <input
        type="submit"
        value="Save"
        class="nb-button"
        data-post=".pages"
        data-done='{"redirect": "admin/pages", "msg": "Page created"}'
    />
</form>
